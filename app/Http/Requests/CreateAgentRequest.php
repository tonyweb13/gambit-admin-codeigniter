<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Agent;

class CreateAgentRequest extends Request implements ResourceRequest
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
	    $modelName = $this->getResourceName();
	    $model = new $modelName;

        return [
	        'agent_id' => 'required|string|unique:' . $model->getTable() .',agent_id',
			'agent_key' => 'required|string',
			'agent_code' => 'required|string|unique:' . $model->getTable() .',agent_code',
			'status' => 'required|in:'. $this->transformToList($this->allowedDeniedChoices()),
			'limit' => 'required|boolean',
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
		return Agent::class;
	}
}
