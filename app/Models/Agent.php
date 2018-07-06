<?php

namespace App\Models;

class Agent extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id',
        'agent_key',
        'agent_code',
        'status',
        'reg_date',
        'amount',
        'limit',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * managers.
     **/
    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    /**
     * configurations.
     **/
    public function configurations()
    {
        return $this->hasMany(AgentConfiguration::class);
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
    public function operations()
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
	 * activities
	 *
	 * 
	 * @return void
	 * @access  public
	 **/
	public function activities()
	{
		return $this->morphMany(ActivityLog::class, 'responsible');
	}

	/**
	 * servers
	 *
	 * 
	 * @return void
	 * @access  public
	 **/
	public function servers()
	{
		return $this->hasMany(AgentServer::class);
	}

	/**
	 * scopeRoot.
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
