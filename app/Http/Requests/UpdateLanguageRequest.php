<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Language;

class UpdateLanguageRequest extends Request implements ResourceRequest
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
		    'code1' => 'required|string',
		    'code2' => 'string',
		    'name' => 'required|string|unique:'. $model->getTable() .',name,'. $model->name,
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
		return Language::class;
	}
}
