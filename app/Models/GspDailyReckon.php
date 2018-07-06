<?php

namespace App\Models;

class GspDailyReckon extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bet_count',
        'win_loss',
        'net_loss',
        'jcon',
        'jwin',
        'running',
        'from_date',
        'to_date',
        'to_year',
        'week_number',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * gsp.
     **/
    public function gsp()
    {
        return $this->belongsTo(Gsp::class);
    }

    /**
     * agent.
     **/
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
