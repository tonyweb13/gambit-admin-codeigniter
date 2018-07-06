<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
class AgentConfiguration extends Resource
{
	public static $notFoundPhrase = 'Agent Configuration not found';

	/**
	 * Display a listing of the resource.
	 * @param $agentId
	 * @return \Illuminate\Http\Response
	 */
    public function index($agentId)
    {
	    $agent = request()->agent;
	    return $this->respondWithPagination($agent->configurations()->paginate(static::getPerPage()));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param $agentId
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
    public function store($agentId, Request $request)
    {
	    $this->model = $this->model->create($request->toArray());
	    $this->model->agent()->associate(request()->agent);
	    return $this->respondWithModel($this->transformer->transform($this->model));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $agentId
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
    public function show($agentId, $id)
    {
	    $model = $this->findResource($id, request()->agent, 'configurations');
	    if (!empty($model) and $this->model = $model) {
		    return $this->respondWithModel( $this->transformer->transform($this->model) );
	    }

	    return $this->responseNotFound(static::$notFoundPhrase);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $agentId
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
    public function update($agentId, Request $request, $id)
    {
	    $model = $this->findResource($id, request()->agent, 'configurations');
	    if (!empty($model) and $this->model = $model) {
		    $data = $request->toArray();
		    if (isset($data['agent_id']) AND $data['agent_id'] <> $model->agent_id) {
			    $this->model->agent_id = $data['agent_id'];
		    }
		    $this->model->update($data);
		    return $this->respondWithModel($this->transformer->transform($this->model));
	    }

	    return $this->responseNotFound(static::$notFoundPhrase);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $agentId
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
    public function destroy($agentId, $id)
    {
	    $model = $this->findResource($id, request()->agent, 'configurations');
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
        $this->model = new \App\Models\AgentConfiguration();
    }
}
