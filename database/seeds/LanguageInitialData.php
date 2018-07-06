<?php


use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageInitialData extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$json = file_get_contents( database_path('seeds/data/language-iso-639.json') );
		$json = json_decode($json);

		foreach ($json as $item) {
			Language::create([
				'code1' => $item->Code1,
				'code2' => $item->Code2,
				'name' => $item->Name,
			]);
		}
	}
}