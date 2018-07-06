<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\GspAdditionalInfo;

class UpdateGspAdditionalInformationRequest extends Request implements ResourceRequest
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
	    # TODO: Apply unique validation for [gsp_id, name]
	    return [
		    'name' => 'required',
		    'value' => 'required',
		    'gsp_id' => 'required',
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
		return GspAdditionalInfo::class;
	}
}
