<?php

namespace App\Models;

class AgentAuthor extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id',
        'authored_id',
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
     * authored.
     **/
    public function authored()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * hierarchy.
     **/
    public function hierarchy()
    {
        return $this->hasOne(AgentHierarchy::class, 'agent_id');
    }

    /**
     * operations.
     **/
    public function agentOperations()
    {
        return $this->hasMany(AgentOperation::class);
    }

    /**
     * agentTransactionsFrom.
     **/
    public function agentTransactionsFrom()
    {
        return $this->hasMany(AgentTransaction::class, 'from_agent_id');
    }

    /**
     * agentTransactionsTo.
     **/
    public function agentTransactionsTo()
    {
        return $this->hasMany(AgentTransaction::class, 'to_agent_id');
    }

    /**
     * scopeRootAgent.
     *
     *
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeRoot($query)
    {
        return $query->whereAgentId(self::ROOT_AGENT_ID);
    }
}
