<?php

namespace App\Models;

class AgentServer extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ip',
        'memo',
        'reg_date',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * agent.
     **/
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
