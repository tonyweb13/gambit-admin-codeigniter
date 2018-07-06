<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    const DENIED = 'D';
    const ALLOWED = 'A';

    const ROOT_AGENT_ID = 'root';
    const ROOT_AGENT_CODE = 'ze';
    const ROOT_MANAGER_ID = 'supermaster';

    /**
     * className.
     **/
    public function className()
    {
        return static::class;
    }
}
