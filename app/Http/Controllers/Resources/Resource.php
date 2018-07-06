<?php

namespace App\Http\Controllers\Resources;

use App\Transformers\Basic;
use App\Http\Controllers\ApiController;

abstract class Resource extends ApiController
{
    public static $notFoundPhrase = 'Model not found';

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \App\Transformers\Basic
     */
    protected $transformer;

    /**
     * __construct.
     *
     *
     * @param Basic $transformer
     */
    public function __construct(Basic $transformer)
    {
        $this->transformer = $transformer;
        $this->initModel();
    }

	/**
	 * @param $id
	 *
	 * @param \Illuminate\Database\Eloquent\Model|null $parentModel
	 * @param string $relation
	 * @return mixed
	 */
    protected function findResource($id, $parentModel=null, $relation='')
    {
	    if (!empty($parentModel) AND !empty($relation)) {
		    $parentModel =  $parentModel->with([$relation=>function($query) use($id) {
			    $query->where('id', $id);
		    }])->where('id', $parentModel->id)->first();
		    return $parentModel->{$relation}->first();
	    }
        return $this->model->query()->find($id);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function getModel()
	{
		return $this->model;
	}
}
