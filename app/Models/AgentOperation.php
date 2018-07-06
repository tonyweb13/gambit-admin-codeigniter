<?php

namespace App\Models;

class AgentOperation extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'allowed',
	    'gsp_id',
		'agent_id',
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
     * gsp.
     **/
    public function gsp()
    {
        return $this->belongsTo(Gsp::class);
    }
}
