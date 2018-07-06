<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;

class GspCurrency extends Resource
{
	public static $notFoundPhrase = 'GSP Currency not found';

	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function index($gspId)
	{
		$gsp = request()->gsp;
		return $this->respondWithPagination($gsp->gspCurrencies()->paginate(static::getPerPage()));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store($gspId, Request $request)
	{
		$this->model = $this->model->create($request->toArray());
		$this->model->gsp()->associate(request()->gsp);
		return $this->respondWithModel($this->transformer->transform($this->model));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($gspId, $id)
	{
		$model = $this->findResource($id, request()->gsp, 'gspCurrencies');
		if (!empty($model) and $this->model = $model) {
			return $this->respondWithModel( $this->transformer->transform($this->model) );
		}

		return $this->responseNotFound(static::$notFoundPhrase);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update($gspId, Request $request, $id)
	{
		$model = $this->findResource($id, request()->gsp, 'gspCurrencies');
		if (!empty($model) and $this->model = $model) {
			$data = $request->toArray();
			if (isset($data['gsp_id']) AND $data['gsp_id'] <> $model->gsp_id) {
				$this->model->gsp_id = $data['gsp_id'];
			}
			$this->model->update($data);
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
	public function destroy($gspId, $id)
	{
		$model = $this->findResource($id, request()->gsp, 'gspCurrencies');
		if (!empty($model) and $this->model = $model) {
			$this->model->delete();

			return $this->respondWithModel($this->transformer->transform($this->model));
		}
		return $this->responseNotFound(static::$notFoundPhrase);
	}


    /**
     * initModel.
     **/
    public function initModel()
    {
        $this->model = new \App\Models\GspCurrency();
    }

}
