<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Country;

class CreateCountryRequest extends Request implements ResourceRequest
{
	use WithApiRequest, WithRulesHelper;

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

	    # TODO: Apply unique rule for alpha_code_2 and alpha_code_3
	    return [
		    'alpha_code_2' => 'required|string',
			'alpha_code_3' => 'required|string',
			'numeric_code' => 'required|integer',
			'name' => 'required|string|unique:' . $model->getTable() .',name',
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
		return Country::class;
	}
}
