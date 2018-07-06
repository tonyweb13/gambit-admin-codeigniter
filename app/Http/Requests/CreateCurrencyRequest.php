<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Currency;

class CreateCurrencyRequest extends Request implements ResourceRequest
{
	use WithApiRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	    $modelName = $this->getResourceName();
	    $model = new $modelName;

	    return [
		    'code' => 'required|string|unique:'. $model->getTable() .',code',
			'country' => 'required|string',
			'exchange_rate_against_usd' => 'numeric',
			'is_iso_standard' => 'boolean'
	    ];
    }

	/**
	 * getResourceName
	 *
	 *
	 * @return void
	 * @access  public
	 **/
	public function getResourceName()
	{
		return Currency::class;
	}
}
