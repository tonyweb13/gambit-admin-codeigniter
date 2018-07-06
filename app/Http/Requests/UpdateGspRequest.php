<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Gsp;

class UpdateGspRequest extends Request implements ResourceRequest
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
	    /** @var \Illuminate\Database\Eloquent\Model $model */
	    $model = new $modelName;

	    $id = request()->segment(2);
	    $model = $model->query()->find($id);

	    return [
		    'name' => 'required|string|unique:'. $model->getTable() .',name,'. $model->name,
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
