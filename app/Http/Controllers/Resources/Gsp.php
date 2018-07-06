<?php

namespace App\Http\Controllers\Resources;

use App\Http\Requests\CreateGspRequest;
use App\Http\Requests\UpdateGspRequest;

class Gsp extends Resource
{
	use WithBasicResource;

	public static $notFoundPhrase = 'GSP not found';

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\CreateGspRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateGspRequest $request)
	{
		$this->model = $this->model->create($request->toArray());
		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateGspRequest $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateGspRequest $request, $id)
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
        $this->model = new \App\Models\Gsp();
    }
}
