<?php

namespace App\Models;

class SmsUsageHistory extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to',
        'network_code',
        'message_id',
        'msisdn',
        'status',
        'err_code',
        'price',
        'scts',
        'message_timestamp',
        'client_ref',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
