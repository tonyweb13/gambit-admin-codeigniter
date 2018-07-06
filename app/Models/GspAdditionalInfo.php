<?php

namespace App\Models;

class GspAdditionalInfo extends Base
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gsp_additional_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
	    'gsp_id',
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

    # TODO: Decide whether gsp additional info should be based on combination of gsp and currency
//	/**
//	 * gspCurrency
//	 *
//	 *
//	 * @return void
//	 * @access  public
//	 **/
//	public function gspCurrency()
//	{
//		return $this->belongsTo(GspCurrency::class);
//	}
}
