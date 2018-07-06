<?php

namespace App\Models;

class AgentTransaction extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'balance_date',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * fromAgent.
     **/
    public function fromAgent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * toAgent.
     **/
    public function toAgent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * manager.
     **/
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
