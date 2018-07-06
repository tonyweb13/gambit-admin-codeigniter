<?php


namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;

trait WithBasicResource
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return $this->respondWithPagination($this->model->query()->paginate(static::getPerPage()));
	}

	/**
	 * initModel.
	 **/
	abstract public function initModel();

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->model = $this->model->create($request->toArray());

		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$model = $this->findResource($id);
		if (!empty($model) and $this->model = $model) {
			return $this->respondWithModel( $this->transformer->transform($this->model) );
		}

		return $this->responseNotFound(static::$notFoundPhrase);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$model = $this->findResource($id);
		if (!empty($model) and $this->model = $model) {

			$this->model->update($request->toArray());

			return $this->respondWithModel($this->transformer->transform($this->model));
		}

		return $this->responseNotFound(static::$notFoundPhrase);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$model = $this->findResource($id);
		if (!empty($model) and $this->model = $model) {
			$this->model->delete();

			return $this->respondWithModel($this->transformer->transform($this->model));
		}
		return $this->responseNotFound(static::$notFoundPhrase);
	}

}