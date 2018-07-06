<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Gsp;

class CreateGspRequest extends Request implements ResourceRequest
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
		    'name' => 'required|string|unique:'. $model->getTable() .',name',
			'gmt' => 'required|integer',
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
		return Gsp::class;
	}
}
