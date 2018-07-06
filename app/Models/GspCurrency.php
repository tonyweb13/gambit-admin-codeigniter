<?php

namespace App\Models;

class GspCurrency extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'merch_id',
        'merch_pwd',
        'game_url',
        'api_url',
	    'gsp_id',
	    'currency_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * currency.
     **/
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * gsp.
     **/
    public function gsp()
    {
        return $this->belongsTo(Gsp::class);
    }
}
