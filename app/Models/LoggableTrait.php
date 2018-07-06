<?php

namespace App\Models;

trait LoggableTrait
{
    /**
     * activities.
     **/
    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'responsible');
    }
}
