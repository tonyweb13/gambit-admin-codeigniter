<?php

namespace App\Http\Controllers\Resources;

use App\Http\Requests\CreateAgentRequest;
use App\Http\Requests\UpdateAgentRequest;

class Agent extends Resource
{
	use WithBasicResource;

	public static $notFoundPhrase = 'Agent not found';

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\CreateAgentRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateAgentRequest $request)
	{
		$this->model = $this->model->create($request->toArray());
		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateAgentRequest $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateAgentRequest $request, $id)
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
        $this->model = new \App\Models\Agent();
    }
}
