<?php

namespace App\Models;

class AgentHierarchy extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id',
        'parent_id',
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

    /**
     * parent.
     **/
    public function parent()
    {
        return $this->belongsTo(Agent::class);
    }
}
