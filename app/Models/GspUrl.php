<?php

namespace App\Models;

class GspUrl extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'name',
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
}
