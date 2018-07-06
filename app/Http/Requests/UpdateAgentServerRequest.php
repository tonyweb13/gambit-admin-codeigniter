<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AgentServer;

class UpdateAgentServerRequest extends Request implements ResourceRequest
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
	    /** @var \Illuminate\Database\Eloquent\Model $model */
	    $model = new $modelName;

	    $id = request()->segment(4);
	    \Log::debug('agent server id is '. $id);
	    $model = $model->query()->find($id);

	    return [
		    'name' => 'required|string|unique:' . $model->getTable() .',name,' . $model->name,
		    'ip' => 'required|ip',
		    'memo' => 'required|string',
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
		return AgentServer::class;
	}
}
