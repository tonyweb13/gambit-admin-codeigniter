<?php

namespace App\Models\Observers;

use App\Models\Agent as Model;
use Carbon\Carbon;

class Agent
{
    /**
     * created.
     *
     * If there is no Registration date, then always set it to current timestamp it was created.
     * Amount field should be set to "0" for newly created Agent.
     *
     * @param Model $model
     */
    public function created(Model $model)
    {
        if (empty($model->reg_date)) {
            $model->reg_date = Carbon::now();
        }
        $model->amount = 0;
        $model->save();
    }
}
