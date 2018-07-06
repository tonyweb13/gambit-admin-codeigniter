<?php

namespace App\Models\Observers;

use App\Models\ActivityLog as Model;
use Carbon\Carbon;

class ActivityLog
{
    /**
     * created.
     *
     * Executed date will always be the current timestamp the record was created.
     *
     * @param Model $model
     */
    public function created(Model $model)
    {
        $model->executed_at = Carbon::now();
        $model->save();
    }
}
