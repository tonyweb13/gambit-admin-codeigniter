<?php


use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencyInitialData extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$json = file_get_contents( database_path('seeds/data/currency-iso-4217.json') );
		$json = json_decode($json);

		foreach ($json as $item) {
			Currency::create([
				'code' => $item->Code,
				'country' => $item->Country
			]);
		}
	}
}