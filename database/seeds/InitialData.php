<?php


use App\Models\Agent;
use App\Models\AgentAuthor;
use App\Models\AgentConfiguration;
use App\Models\AgentHierarchy;
use App\Models\AgentOperation;
use App\Models\AgentTransaction;
use App\Models\Currency;
use App\Models\Gsp;
use App\Models\GspAdditionalInfo;
use App\Models\GspCurrency;
use App\Models\GspUrl;
use App\Models\Language;
use App\Models\Manager;
use App\Models\AgentServer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class InitialData extends Seeder
{
    protected $gsp;

    protected $manager;

    protected $agent;

    protected $server;

    /**
     * __construct
     *
     *
     * @access  public
     */
    public function __construct()
    {
        $this->gsp = new Collection;
        $this->manager = new Collection;
        $this->agent = new Collection;
        $this->server = new Collection;
    }

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        # Include RMB in the currency list
        Currency::create([
            'code' => 'RMB',
            'country' => 'China',
            'is_iso_standard' => false,
        ]);

        # Ctypes
        $ctypes = json_decode(file_get_contents( database_path('seeds/data/initial-tb_ctype.json') ));

        foreach($ctypes as $ctype) {
            $gsp = $this->getGsp($ctype->game_idx);

            $currencyModel = Currency::whereCode($ctype->currencyType)->first();
            if (empty($currencyModel)) throw new Exception("Undefined currency code {$ctype->currencyType}");

            $currencies = isset($gsp->currencies) ? $gsp->currencies: new Collection();
            $currency = $currencies->get($ctype->currencyType);
            if (empty($currency)) $currency = new stdClass;
            $gsp->api_url = $ctype->api_url;
            $currencies->push([
                'currency_id' => $currencyModel->id,
                'name' => $ctype->currencyType,
                'merch_id' => $ctype->branchID,
                'merch_pwd' => $ctype->branchpwd,
                'game_url' => $ctype->game_url,
                'api_url' => $ctype->api_url,
                'gsp_id' => $ctype->game_idx,
            ]);
            $gsp->currencies = $currencies->unique();

            $this->gsp->put($ctype->game_idx, $gsp);
        }

        # Currencies
        $currencies = json_decode(file_get_contents( database_path('seeds/data/initial-tb_currency.json') ));
        foreach($currencies as $currency) {
            $currencyModel = Currency::whereCode($currency->Currency)->first();
            if (empty($currencyModel)) throw new Exception("Undefined currency code {$currency->Currency}");
            $currencyModel->exchange_rate_against_usd = $currency->ExchangeRate;
            $currencyModel->save();
        }

        # GSP Added Information
        $gsps = $this->gspAddedInformation();
        foreach($gsps as $item) {
            $gsp = $this->getGsp($item['idx']);
            $gsp->name = $item['name'];
            $gsp->full_name = $item['full_name'];

            $gspAddOns = isset($gsp->addOns) ?  $gsp->addOns : new Collection();
            $gspAddOns->push([
                'gsp_id' => $item['idx'],
                'name' => 'official site',
                'value' => $item['official_site']
            ]);
            $gsp->addOns = $gspAddOns->unique();

            $this->gsp->put($item['idx'], $gsp);
        }

        $gameList = json_decode(file_get_contents( database_path('seeds/data/initial-tb_game_list.json') ));
        foreach($gameList as $game) {
            $gsp = $this->getGsp($game->idx);
            $gsp->name = $game->gName;
            $gsp->merch_id = $game->merch_id;
            $gspAddOns = isset($gsp->addOns) ?  $gsp->addOns : new Collection;

            $gspAddOns->push([
                'gsp_id' => $game->idx,
                'name' => 'merch_pwd',
                'value' => $game->merch_pwd
            ]);

            if (isset($game->merch_pwd2)) {
                $gspAddOns->push([
                    'gsp_id' => $game->idx,
                    'name' => 'merch_pwd2',
                    'value' => $game->merch_pwd2
                ]);
            }

            if (isset($game->merch_pwd3)) {
                $gspAddOns->push([
                    'gsp_id' => $game->idx,
                    'name' => 'merch_pwd3',
                    'value' => $game->merch_pwd3
                ]);
            }

            $gsp->addOns = $gspAddOns->unique();
            $this->gsp->put($game->idx, $gsp);
        }

        $gameRealList = json_decode(file_get_contents( database_path('seeds/data/initial-tb_game_real_list.json') ));
        foreach($gameRealList as $item) {
            if (in_array($item->idx, ['1002_1', '1012_1'])) continue;

            $gsp = $this->getGsp($item->idx);

            $gsp->gmt = $item->gmt;

            $this->gsp->put($item->idx, $gsp);
        }

        $managers = json_decode(file_get_contents( database_path('seeds/data/initial-tb_manager.json') ));
        foreach($managers as $item) {
            $manager = $this->getManager($item->idx);

            $lang = Language::whereCode2($item->language)->first();
            if (empty($lang)) throw new Exception("Language with code {$item->language} is not defined.");

            $manager->manager_id = $item->manager_id;
            $manager->manager_key = $item->manager_pwd;
            $manager->agent_id = $item->op_idx;
            $manager->language_id = $lang->id;
            $manager->token = $item->token;
            $manager->token_time = $item->token_time;
            $manager->phone = $item->phone;
            $manager->reg_date = $item->reg_date;
            $manager->memo = $item->memo;
            $manager->locked = ($item->use_yn=='Y') ? false : true;
            $this->manager->put($item->idx, $manager);
        }

        $ops = json_decode(file_get_contents( database_path('seeds/data/initial-tb_op.json') ));
        $gspMapping = [
            'game00' => 1000,
            'game02' => 1002,
            'game04' => 1004,
            'game05' => 1005,
            'game09' => 1009,
            'game12' => 1012,
            'game14' => 1014,
            'game16' => 1016,
            'game18' => 1055,
            'game55' => 1065,
            'game65' => 1018,
        ];
        foreach($ops as $op) {

            $agent = $this->getAgent($op->idx);
            $agent->idx = $op->idx;
            $agent->agent_id = $op->merch_id;
            $agent->agent_key = $op->merch_pwd;
            $agent->agent_code = $op->op_code;
            $agent->status = $op->status;
            $agent->reg_date = $op->reg_date;
            $agent->amount = $op->amount;
            $agent->limit = $op->limit;

            $agentOperations = isset($agent->agent_operations) ? $agent->agent_operations : [];
            foreach($gspMapping as $columnName => $gspIdx) {

                $gsp = $this->getGsp($gspIdx);
                $agentOperations[] = [
                    'gsp_id' => $gspIdx,
                    'agent_id' => $op->idx,
                    'allowed' => $op->{$columnName}
                ];

                $urls = isset($gsp->urls) ? $gsp->urls : new Collection();

                $urls->push([
                    'gsp_id' => $gspIdx,
                    'name' => 'url01',
                    'url' => $op->{$columnName . '_url01'}
                ]);
                if ($columnName == 'game00') {
                    $urls->push([
                        'gsp_id' => $gspIdx,
                        'name' => 'url02',
                        'url' => $op->{$columnName . '_url02'}
                    ]);
                    $urls->push([
                        'gsp_id' => $gspIdx,
                        'name' => 'url03',
                        'url' => $op->{$columnName . '_url03'}
                    ]);
                    $urls->push([
                        'gsp_id' => $gspIdx,
                        'name' => 'url04',
                        'url' => $op->{$columnName . '_url04'}
                    ]);
                }

                $gsp->urls = $urls->unique();
                $this->gsp->put($gspIdx, $gsp);

            }
            $agent->agentOperations = $agentOperations;
            $this->agent->put($op->idx, $agent);

        }

        $opBridges = json_decode(file_get_contents( database_path('seeds/data/initial-tb_op_bridge.json') ));
        foreach($opBridges as $bridge) {
            $agent = $this->getAgent($bridge->op_idx);

            if (!empty($bridge->uplevel_op)) $agent->author_id = $bridge->uplevel_op;

            $root = array_filter(explode('|', $bridge->op_code_divide));

            $parentIndex = count($root)-1;
            if (isset($root[$parentIndex])) {
                $agent->parent_id = $root[$parentIndex];
            }

            $this->agent->put($bridge->op_idx, $agent);

        }

        # TODO: Ask sir robert about this table
        $opConfigs = json_decode(file_get_contents( database_path('seeds/data/initial-tb_op_config.json') ));
        foreach($opConfigs as $config) {

            if ($this->agent->get($config->op_idx) == null) continue;

            $agent = $this->getAgent($config->op_idx);
	        $gsp = $this->gsp->get($config->game_code);
	        if (!empty($gsp)) {
		        $agentConfigurations = isset($agent->agentConfigurations) ? $agent->agentConfigurations : [];
		        $agentConfigurations[] = [
			        'rates' => $config->rates,
			        'exchange' => $config->exchange,
			        'gmt' => $config->gmt,
			        'gsp_id' => $config->game_code,
		        ];
		        $agent->agentConfigurations = $agentConfigurations;
	        }

            $this->agent->put($config->op_idx, $agent);
        }

        $servers = json_decode(file_get_contents( database_path('seeds/data/initial-tb_server.json') ));
        foreach($servers as $item) {
            $server = $this->getServer($item->idx);
            $server->agent_id = $item->merch_id;
            $server->name = $item->server_name;
            $server->ip = $item->server_ip;
            $server->memo = $item->memo;
            $server->reg_date = $item->reg_date;
            $this->server->put($item->idx, $server);
        }

        $this->runGspSeeding();
        $this->runOperationSeeding();
	    $this->runServerSeeding();
    }


    /**
     * getGsp
     *
     *
     * @param $idx
     * @access  public
     * @return mixed|stdClass
     */
    public function getGsp($idx)
    {
        $gsp = $this->gsp->get($idx);
        if (empty($gsp)) $gsp = new stdClass;

        return $gsp;
    }

    /**
     * getManager
     *
     *
     * @param $idx
     * @access  public
     * @return mixed|stdClass
     */
    public function getManager($idx)
    {
        $manager = $this->manager->get($idx);
        if (empty($manager)) $manager = new stdClass;

        return $manager;
    }

    /**
     * getServer
     *
     *
     * @param $idx
     * @access  public
     * @return mixed|stdClass
     */
    public function getServer($idx)
    {
        $server = $this->server->get($idx);
        if (empty($server)) $server = new stdClass;

        return $server;
    }

    /**
     * getAgent
     *
     *
     * @param $idx
     * @access  public
     * @return mixed|stdClass
     */
    public function getAgent($idx)
    {
        $agent = $this->agent->get($idx);
        if (empty($agent)) $agent = new stdClass;

        return $agent;
    }

    /**
     * gspAddedInformation
     *
     *
     * @return void
     * @access  public
     **/
    public function gspAddedInformation()
    {
        return [
            [
                'idx' => 1000,
                'name' => 'W88',
                'use' => 'Y',
                'full_name' => 'GAMEPLAY',
                'official_site' => 'http://gameplayint.com/',
            ],
            [
                'idx' => 1002,
                'name' => 'GD',
                'use' => 'Y',
                'full_name' => 'Gold Deluxe',
                'official_site' => 'http://golddeluxephil.com/EN/index.html',
            ],
            [
                'idx' => 1004,
                'name' => 'Xpro',
                'use' => 'Y',
                'full_name' => 'XProGaming',
                'official_site' => 'http://www.xprogaming.com/#',
            ],
            [
                'idx' => 1005,
                'name' => 'Micro',
                'use' => 'Y',
                'full_name' => 'Microgaming',
                'official_site' => 'https://www.microgaming.co.uk/',
            ],
            [
                'idx' => 1009,
                'name' => 'XTD',
                'use' => 'Y',
                'full_name' => 'XinTianDi',
                'official_site' => 'http://www.8xtd.com/web_en/about.html',
            ],
            [
                'idx' => 1012,
                'name' => 'AG',
                'use' => 'Y',
                'full_name' => 'Asia Gaming',
                'official_site' => 'http://www.asia-gaming.com/',
            ],
            [
                'idx' => 1014,
                'name' => 'Ezugi',
                'use' => 'Y',
                'full_name' => 'Ezugi',
                'official_site' => 'http://ezugi.com/',
            ],
            [
                'idx' => 1016,
                'name' => 'ASC',
                'use' => 'Y',
                'full_name' => 'ASC',
                'official_site' => 'N/A',
            ],
            [
                'idx' => 1055,
                'name' => 'Micro-c',
                'use' => 'N',
                'full_name' => 'Microgaming',
                'official_site' => 'https://www.microgaming.co.uk/',
            ],
            [
                'idx' => 1065,
                'name' => 'MicroUsd',
                'use' => 'Y',
                'full_name' => 'Microgaming',
                'official_site' => 'https://www.microgaming.co.uk/',
            ],
            [
                'idx' => 1018,
                'name' => 'CMD STAR',
                'use' => 'Y',
                'full_name' => 'CMD',
                'official_site' => 'N/A',
            ],
        ];
    }

    private function runGspSeeding()
    {
        $currencies = new Collection();
        $addOns = new Collection();
        $urls = new Collection();
        $gsps = new Collection();

        $this->gsp->each(function($item, $key) use(&$gsps, &$addOns, &$urls, &$currencies) {

            $gsps->push([
                'id' => $key,
                'name' =>$item->full_name,
                'gmt' => $item->gmt,
            ]);

            if (isset($item->urls)) {
                $urls = $urls->merge($item->urls->toArray());
            }

            if (isset($item->currencies)) {
                $currencies = $currencies->merge($item->currencies);
            }

        });

        Gsp::insert($gsps->unique()->toArray());
        GspAdditionalInfo::insert($addOns->unique()->toArray());
        GspUrl::insert($urls->unique()->toArray());
        GspCurrency::insert($currencies->unique()->toArray());

    }

    private function runOperationSeeding()
    {
        $agentOperations = new Collection();
        $agentConfigurations = $agents = [];
        $this->agent->each(function($item) use(&$agents, &$agentOperations, &$agentConfigurations) {

            $agents[] = [
	            'id' => $item->idx,
                'agent_id' => $item->agent_id,
                'agent_key' => $item->agent_key,
                'agent_code' => $item->agent_code,
                'status' => $item->status,
                'reg_date' => $item->reg_date,
                'amount' => $item->amount,
                'limit' => $item->limit,
            ];

            if (isset($item->agentConfigurations)) {
	            foreach($item->agentConfigurations as $configuration) {
		            $agentConfigurations[] = [
			            'agent_id' => $item->idx,
			            'rates' => $configuration['rates'],
						'exchange' => $configuration['exchange'],
						'gmt' => $configuration['gmt'],
						'gsp_id' => $configuration['gsp_id'],
		            ];
	            }
            }
            if (isset($item->agentOperations)) {
                $agentOperations = $agentOperations->merge($item->agentOperations);
            }

        });

        Agent::insert($agents);
        AgentOperation::insert($agentOperations->unique()->toArray());
        AgentConfiguration::insert($agentConfigurations);

        $managers = [];
        $this->manager->each(function($item) use(&$managers) {
            $managers[] = get_object_vars($item);
        });
        Manager::insert($managers);


        $this->agent->each(function($item){
            if (isset($item->author_id)) {
                AgentAuthor::create([
                    'agent_id' => $item->idx,
                    'authored_id' => $item->author_id,
                ]);
            }

            if (isset($item->parent_id)) {
                AgentHierarchy::create([
                    'agent_id' => $item->idx,
                    'parent_id' => $item->parent_id,
                ]);
            }
        });

    }

	private function runServerSeeding()
	{
		$servers = [];
		$this->server->each(function($item) use(&$servers) {
			$servers[] = get_object_vars($item);
		});

		AgentServer::insert($servers);
	}
}