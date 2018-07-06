<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;

abstract class Transformer
{
    /**
     * transform.
     *
     *
     * @param Model $model
     */
    abstract public function transform(Model $model);
}
