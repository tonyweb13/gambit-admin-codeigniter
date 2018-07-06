<?php

namespace App\Models;

class Manager extends Base
{
    use SessionableTrait, LoggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manager_id',
        'manager_key',
        'agent_id',
        'phone',
        'memo',
	    'language_id',
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
     * language.
     **/
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * hierarchy.
     **/
    public function hierarchy()
    {
        return $this->hasOne(ManagerHierarchy::class, 'manager_id');
    }

    /**
     * agentTransactions.
     **/
    public function agentTransactions()
    {
        return $this->hasMany(AgentTransaction::class);
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
        return $query->whereManagerId(self::ROOT_MANAGER_ID);
    }
}
