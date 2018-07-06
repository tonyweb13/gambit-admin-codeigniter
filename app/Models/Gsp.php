<?php

namespace App\Models;

class Gsp extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gmt',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * operations.
     **/
    public function agentOperations()
    {
        return $this->hasMany(AgentOperation::class);
    }

    /**
     * gspUrls.
     **/
    public function gspUrls()
    {
        return $this->hasMany(GspUrl::class);
    }

    /**
     * gspUrls.
     **/
    public function gspAdditionalInfo()
    {
        return $this->hasMany(GspAdditionalInfo::class);
    }

    /**
     * gspCurrencies.
     **/
    public function gspCurrencies()
    {
        return $this->hasMany(GspCurrency::class);
    }

    /**
     * gspDailyReckons.
     **/
    public function gspDailyReckons()
    {
        return $this->hasMany(GspDailyReckon::class);
    }

	/**
	 * agentConfigurations.
	 **/
	public function agentConfigurations()
	{
		return $this->hasMany(AgentConfiguration::class);
	}
}
