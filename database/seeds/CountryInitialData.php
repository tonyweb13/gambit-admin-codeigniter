<?php


use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryInitialData extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$json = file_get_contents( database_path('seeds/data/countries-iso-3166-1.json') );
		$json = json_decode($json);

		foreach ($json as $item) {
			Country::create([
				'alpha_code_2' => $item->Alpha2Code,
				'alpha_code_3' => $item->Alpha3Code,
				'numeric_code' => $item->NumericCode,
				'name' => $item->ShortName,
			]);
		}
	}
}