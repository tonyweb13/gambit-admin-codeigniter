<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AgentConfiguration;

class UpdateAgentConfigurationRequest extends Request implements ResourceRequest
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
	    return [
		    'rates' => 'required|numeric',
		    'exchange' => 'required|numeric',
		    'gmt' => 'required|integer',
		    'agent_id' => 'required',
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
		return AgentConfiguration::class;
	}
}
