<?php


namespace App\Http\Requests;


use App\Http\Controllers\ApiController;
use App\Models\Base;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

trait WithRulesHelper
{
	/**
	 * transformToList
	 *
	 *
	 * @param array $list
	 * @return string
	 * @access  public
	 */
	public function transformToList($list = [])
	{
		return implode(',', $list);
	}
}