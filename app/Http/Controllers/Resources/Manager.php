<?php

namespace App\Http\Controllers\Resources;

use App\Http\Requests\CreateManagerRequest;
use App\Http\Requests\UpdateManagerRequest;

class Manager extends Resource
{
	use WithBasicResource;

	public static $notFoundPhrase = 'Manager not found';

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\CreateManagerRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateManagerRequest $request)
	{
		$this->model = $this->model->create($request->toArray());
		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateManagerRequest $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateManagerRequest $request, $id)
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
        $this->model = new \App\Models\Manager();
    }
}
