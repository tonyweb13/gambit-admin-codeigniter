<?php

namespace App\Transformers;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;

class Basic extends Transformer
{
    /**
     * transform.
     *
     *
     * @param Model $model
     *
     * @return array
     */
    public function transform(Model $model)
    {
        return $model->toArray();
    }

	/**
	 * fakerAvoidNull
	 *
	 *
	 * @param $formatter
	 * @access  public
	 * @return string
	 */
	public static function fakerAvoidNull($formatter)
	{
		$faker = Factory::create();
		do {
			$value = $faker->$formatter;
		} while(empty($value));

		return $value;
	}
}
