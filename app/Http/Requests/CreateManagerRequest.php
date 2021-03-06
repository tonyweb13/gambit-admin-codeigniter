<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Manager;

class CreateManagerRequest extends Request implements ResourceRequest
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
		    'manager_id' => 'required|string|unique:'. $model->getTable() .',manager_id',
			'manager_key' => 'required|string',
			'agent_id' => 'required',
			'phone' => 'required',
		    'language_id' => 'required|',
			'memo' => 'string',
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
		return Manager::class;
	}
}
