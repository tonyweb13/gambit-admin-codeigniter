<?php

namespace App\Models;

class ManagerHierarchy extends Base
{
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * scopeRootManager.
     *
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeRoot($query)
    {
        return $query->whereManagerId(self::ROOT_MANAGER_ID);
    }

    /**
     * parent.
     **/
    public function parent()
    {
        return $this->belongsTo(Manager::class);
    }

    /**
     * manager.
     **/
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
