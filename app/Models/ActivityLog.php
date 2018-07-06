<?php

namespace App\Models;

class ActivityLog extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action_code',
        'short_description',
        'long_description',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * loggable.
     **/
    public function loggable()
    {
        return $this->morphTo('responsible');
    }

    /**
     * session.
     **/
    public function sessionLog()
    {
        return $this->belongsTo(SessionLog::class);
    }
}
