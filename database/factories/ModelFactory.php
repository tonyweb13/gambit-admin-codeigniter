<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\Base as Model;
use App\Transformers\Basic;

$factory->define(App\Models\User::class, function (Faker\Generator $faker) use($factory) {
    return [
        'name' => Basic::fakerAvoidNull('name'),
        'email' => Basic::fakerAvoidNull('email'),
        'password' => Basic::fakerAvoidNull('password'),
        'remember_token' => Basic::fakerAvoidNull('md5'),
    ];
});

$factory->define(App\Models\Agent::class, function (Faker\Generator $faker) use($factory) {
    return [
        'agent_id' => Basic::fakerAvoidNull('userName'),
        'agent_key' => Basic::fakerAvoidNull('md5'),
        'agent_code' => Basic::fakerAvoidNull('username'),
        'status' => [Model::ALLOWED, Model::DENIED][rand(0,1)],
        'reg_date' => $faker->date('Y-m-d H:i:s'),
        'amount' => $faker->randomFloat(2),
        'limit' => $faker->boolean(),
    ];
});

$factory->define(App\Models\Gsp::class, function (Faker\Generator $faker) use($factory) {
	return [
		'name' => Basic::fakerAvoidNull('userName'),
		'gmt' => Basic::fakerAvoidNull('randomDigit'),
	];
});

$factory->define(App\Models\Manager::class, function (Faker\Generator $faker) use($factory) {
    $agent = App\Models\Agent::orderByRaw("RAND()")->first();
    $lang = App\Models\Language::orderByRaw("RAND()")->first();
    return [
        'manager_id' => Basic::fakerAvoidNull('userName'),
        'manager_key' => Basic::fakerAvoidNull('md5'),
        'agent_id' => $agent->id,
        'language_id' => $lang->id,
        'token' => $faker->text(20),
        'token_time' => $faker->text(10),
        'phone' => Basic::fakerAvoidNull('phoneNumber'),
        'reg_date' => $faker->date('Y-m-d H:i:s'),
        'locked' => $faker->boolean(),
        'memo' => $faker->paragraph(5),
    ];
});

$factory->define(App\Models\SessionLog::class, function (Faker\Generator $faker) use($factory) {
	$country = App\Models\Country::orderByRaw("RAND()")->first();
	$agent = App\Models\Agent::orderByRaw("RAND()")->first();
	$manager = App\Models\Manager::orderByRaw("RAND()")->first();
	$user = rand(0,1) ? $agent : $manager;
	return [
		'login_url' => Basic::fakerAvoidNull('url'),
		'visit_ip' => Basic::fakerAvoidNull('ipv4'),
		'country_id' => $country->id,
		'isp_provider' => Basic::fakerAvoidNull('company'),
		'services' => $faker->realText(10),
		'session_id' => Basic::fakerAvoidNull('md5'),
		'logout_at' => $faker->date('Y-m-d H:i:s'),
		'responsible_type' => $user->className(),
		'responsible_id' => $user->id
	];
});

$factory->define(App\Models\ActivityLog::class, function (Faker\Generator $faker) use($factory) {
	$sessionLog = $factory->create(App\Models\SessionLog::class);
	$user = App\Models\Agent::root()->first();

	return [
		'action_code' => strtoupper(Basic::fakerAvoidNull('countryCode')),
		'short_description' => $faker->realText(10),
		'long_description' => $faker->realText(20),
		'session_log_id' => $sessionLog->id,
		'responsible_type' => $user->className(),
		'responsible_id' => $user->id
	];
});

$factory->defineAs(App\Models\SessionLog::class, 'root-manager', function(Faker\Generator $faker) use($factory) {

	$country = App\Models\Country::orderByRaw("RAND()")->first();
	$user = App\Models\Manager::root()->first();

	return [
		'login_url' => Basic::fakerAvoidNull('url'),
		'visit_ip' => Basic::fakerAvoidNull('ipv4'),
		'country_id' => $country->id,
		'isp_provider' => Basic::fakerAvoidNull('company'),
		'services' => $faker->realText(10),
		'session_id' => Basic::fakerAvoidNull('md5'),
		'logout_at' => $faker->date('Y-m-d H:i:s'),
		'responsible_type' => $user->className(),
		'responsible_id' => $user->id
	];
});

$factory->defineAs(App\Models\SessionLog::class, 'root-agent', function(Faker\Generator $faker) use($factory) {

	$country = App\Models\Country::orderByRaw("RAND()")->first();
	$user = App\Models\Agent::root()->first();

	return [
		'login_url' => Basic::fakerAvoidNull('url'),
		'visit_ip' => Basic::fakerAvoidNull('ipv4'),
		'country_id' => $country->id,
		'isp_provider' => Basic::fakerAvoidNull('company'),
		'services' => $faker->realText(10),
		'session_id' => Basic::fakerAvoidNull('md5'),
		'logout_at' => $faker->date('Y-m-d H:i:s'),
		'responsible_type' => $user->className(),
		'responsible_id' => $user->id
	];
});

$factory->define(App\Models\Country::class, function (Faker\Generator $faker) use($factory) {
	return [
		'alpha_code_2' => Basic::fakerAvoidNull('randomLetter') . Basic::fakerAvoidNull('randomLetter'),
		'alpha_code_3' => Basic::fakerAvoidNull('randomLetter') . Basic::fakerAvoidNull('randomLetter') . Basic::fakerAvoidNull('randomLetter'),
		'numeric_code' => Basic::fakerAvoidNull('randomDigit') . Basic::fakerAvoidNull('randomDigit'),
		'name' => Basic::fakerAvoidNull('name'),
	];
});

$factory->define(App\Models\Currency::class, function (Faker\Generator $faker) use($factory) {
	return [
		'code' => Basic::fakerAvoidNull('username'),
		'country' => Basic::fakerAvoidNull('company'),
		'exchange_rate_against_usd' => $faker->randomFloat(1),
		'is_iso_standard' => $faker->boolean(),
	];
});

$factory->define(App\Models\AgentServer::class, function (Faker\Generator $faker) use($factory) {
	$agent = App\Models\Agent::orderByRaw("RAND()")->first();
	return [
		'agent_id' => $agent->id,
		'name' => Basic::fakerAvoidNull('name'),
		'ip' => Basic::fakerAvoidNull('ipv4'),
		'memo' => $faker->realText(10),
		'reg_date' => $faker->date('Y-m-d H:i:s'),
	];
});

$factory->define(App\Models\Language::class, function (Faker\Generator $faker) use($factory) {
	return [
		'code1' => Basic::fakerAvoidNull('randomLetter') . Basic::fakerAvoidNull('randomLetter'),
		'code2' => Basic::fakerAvoidNull('randomLetter') . Basic::fakerAvoidNull('randomLetter') . Basic::fakerAvoidNull('randomLetter'),
		'name' => Basic::fakerAvoidNull('name'),
	];
});

$factory->define(App\Models\AgentTransaction::class, function (Faker\Generator $faker) use($factory) {
	$fromAgent = App\Models\Agent::orderByRaw("RAND()")->first();
	$toAgent = App\Models\Agent::orderByRaw("RAND()")->whereNotIn('id', [$fromAgent->id])->first();
	$manager = App\Models\Manager::orderByRaw("RAND()")->first();
	return [
		'manager_id' => $manager->id,
		'from_agent_id' => $fromAgent->id,
		'to_agent_id' => $toAgent->id,
		'amount' => $faker->randomFloat(2),
		'balance_date' => $faker->date('Y-m-d H:i:s'),
	];
});

$factory->define(App\Models\AgentOperation::class, function (Faker\Generator $faker) use($factory) {
	$agent = factory(App\Models\Agent::class)->create(['agent_code'=>'test-e']);
	$gsp = App\Models\Gsp::orderByRaw("RAND()")->first();
	return [
		'gsp_id' => $gsp->id,
		'agent_id' => $agent->id,
		'allowed' => [Model::DENIED, Model::ALLOWED][rand(0,1)],
	];
});

$factory->define(App\Models\AgentConfiguration::class, function (Faker\Generator $faker) use($factory) {
	$agent = App\Models\Agent::orderByRaw("RAND()")->first();
	$gsp = App\Models\Gsp::orderByRaw("RAND()")->first();
	return [
		'agent_id' => $agent->id,
		'rates' => rand(10, 100),
		'exchange' => rand(10, 100),
		'gmt' => Basic::fakerAvoidNull('randomDigit'),
		'gsp_id' => $gsp->id,
	];
});

$factory->define(App\Models\GspAdditionalInfo::class, function (Faker\Generator $faker) use($factory) {
	$gsp = App\Models\Gsp::orderByRaw("RAND()")->first();
	return [
		'gsp_id' => $gsp->id,
		'name' => Basic::fakerAvoidNull('userName'),
		'value' => $faker->text(10),
	];
});

$factory->define(App\Models\GspCurrency::class, function (Faker\Generator $faker) use($factory) {
	$gsp = App\Models\Gsp::orderByRaw("RAND()")->first();
	$currency = App\Models\Currency::orderByRaw("RAND()")->first();
	return [
		'gsp_id' => $gsp->id,
		'currency_id' => $currency->id,
		'name' => Basic::fakerAvoidNull('name'),
		'merch_id' => Basic::fakerAvoidNull('userName'),
		'merch_pwd' => Basic::fakerAvoidNull('md5'),
		'game_url' => Basic::fakerAvoidNull('url'),
		'api_url' => Basic::fakerAvoidNull('url'),
	];
});

$factory->define(App\Models\GspUrl::class, function (Faker\Generator $faker) use($factory) {
	$gsp = App\Models\Gsp::orderByRaw("RAND()")->first();
	return [
		'gsp_id' => $gsp->id,
		'url' => Basic::fakerAvoidNull('url'),
		'name' => Basic::fakerAvoidNull('name'),
	];
});
