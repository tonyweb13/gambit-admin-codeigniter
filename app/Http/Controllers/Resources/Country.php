<?php

namespace App\Http\Controllers\Resources;

use App\Http\Requests\CreateCountryRequest;
use App\Http\Requests\UpdateCountryRequest;

class Country extends Resource
{
	use WithBasicResource;

	public static $notFoundPhrase = 'Country not found';

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\CreateCountryRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateCountryRequest $request)
	{
		$this->model = $this->model->create($request->toArray());
		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateCountryRequest $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateCountryRequest $request, $id)
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
        $this->model = new \App\Models\Country();
    }
}
