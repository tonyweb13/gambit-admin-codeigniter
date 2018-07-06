<?php


namespace App\Http\Requests;


use App\Http\Controllers\ApiController;
use App\Models\Base;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

trait WithAllowedDenied
{
	/**
	 * statusChoices
	 *
	 * 
	 * @return void
	 * @access  public
	 **/
	public function allowedDeniedChoices()
	{
		return [
			Base::ALLOWED,
			Base::DENIED,
		];
	}
}