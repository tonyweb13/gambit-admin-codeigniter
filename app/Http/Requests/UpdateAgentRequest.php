<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Agent;

class UpdateAgentRequest extends Request implements ResourceRequest
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
	    /** @var \Illuminate\Database\Eloquent\Model $model */
	    $model = new $modelName;

	    $agentId = request()->segment(2);
	    $model = $model->query()->find($agentId);

	    return [
		    'agent_id' => 'required|string|unique:' . $model->getTable() .',agent_id,' . $model->agent_id,
		    'agent_key' => 'required|string',
		    'agent_code' => 'required|string|unique:' . $model->getTable() .',agent_code,' . $model->agent_code,
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
