<?php

namespace App\Http\Controllers\Resources;

use App\Http\Requests\CreateCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;

class Currency extends Resource
{
	use WithBasicResource;

	public static $notFoundPhrase = 'Currency not found';

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\CreateCurrencyRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateCurrencyRequest $request)
	{
		$this->model = $this->model->create($request->toArray());
		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateCurrencyRequest $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateCurrencyRequest $request, $id)
	{
		$model = $this->findResource($id);
		if (!empty($model) and $this->model = $model) {

			$this->model->update($request->toArray());

			return $this->respondWithModel($this->transformer->transform($this->model));
		}

		return $this->responseNotFound(static::$notFoundPhrase);
	}

    /**
     * initModel.
     **/
    public function initModel()
    {
        $this->model = new \App\Models\Currency();
    }

}
