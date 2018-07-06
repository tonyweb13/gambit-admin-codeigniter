<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\GspCurrency;

class CreateGspCurrencyRequest extends Request implements ResourceRequest
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
	    # TODO: Apply unique validation for [currency_id, gsp_id]
        return [
	        'name' => 'required|string',
	        'merch_id' => 'required|string',
	        'merch_pwd' => 'required|string',
	        'game_url' => 'required|url',
	        'api_url' => 'required|url',
	        'gsp_id' => 'required',
	        'currency_id' => 'required',
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
		return GspCurrency::class;
	}
}
