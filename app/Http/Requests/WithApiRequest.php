<?php


namespace App\Http\Requests;


use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

trait WithApiRequest
{
	public function forbiddenResponse()
	{
		return with(new ApiController())->responseForbidden();
	}

	/**
	 * Handle a failed validation attempt.
	 *
	 * @param  \Illuminate\Contracts\Validation\Validator $validator
	 * @return mixed
	 * @throws HttpResponseException
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->response([
			'issues' => $this->formatErrors($validator),
			'resource' => $this->getResourceName(),
		]));
	}
}