<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Currency;

class UpdateCurrencyRequest extends Request implements ResourceRequest
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
		    'code' => 'required|string|unique:'. $model->getTable() .',code,'. $model->code,
		    'country' => 'required|string',
		    'exchange_rate_against_usd' => 'numeric',
		    'is_iso_standard' => 'boolean'
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
		return Currency::class;
	}
}
