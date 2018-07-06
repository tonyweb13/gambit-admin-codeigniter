<?php

namespace App\Models;

trait SessionableTrait
{
    /**
     * sessions.
     **/
    public function sessions()
    {
        return $this->morphMany(SessionLog::class, 'responsible');
    }
}
