<?php

namespace App\Http\Controllers\Resources;

use App\Http\Requests\CreateLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;

class Language extends Resource
{
	use WithBasicResource;

	public static $notFoundPhrase = 'Language not found';

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\CreateLanguageRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateLanguageRequest $request)
	{
		$this->model = $this->model->create($request->toArray());
		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateLanguageRequest $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateLanguageRequest $request, $id)
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
        $this->model = new \App\Models\Language();
    }

}
