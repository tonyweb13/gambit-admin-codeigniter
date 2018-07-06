<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AgentOperation;

class UpdateAgentOperationRequest extends Request implements ResourceRequest
{
	use WithApiRequest, WithAllowedDenied, WithRulesHelper;
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
	    # TODO: Apply unique validation for [gsp_id, agent_id]
	    return [
		    'allowed' => 'required|in:' . $this->transformToList($this->allowedDeniedChoices()),
		    'gsp_id' => 'required',
		    'agent_id' => 'required',
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
		return AgentOperation::class;
	}
}
