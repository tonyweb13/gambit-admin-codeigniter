<?php

namespace App\Models;

class SessionLog extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_url',
        'visit_ip',
        'country_id',
        'isp_provider',
        'services',
        'session_id',
        'logout_at',
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
     * activities.
     **/
    public function activities()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * country.
     **/
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
