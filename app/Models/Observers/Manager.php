<?php

namespace App\Models\Observers;

use App\Models\Language;
use App\Models\Manager as Model;
use Carbon\Carbon;

class Manager
{
    /**
     * created.
     *
     * Registration date will always be the current timestamp the record was created.
     * If there is no Language defined, then set to English.
     *
     * @param Model $model
     */
    public function created(Model $model)
    {
        $model->reg_date = Carbon::now();
        if (empty($model->language_id)) {
            $model->language_id = Language::where('en')->first()->id;
        }
        $model->locked = false;
        $model->save();
    }
}
