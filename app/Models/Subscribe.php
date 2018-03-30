<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
* types:
* 0 - user
* 1 - category
* 2 - none
*/
class Subscribe extends Model
{

    public $timestamps = false;

    
    public function user()
    {
        return $this->hasOne('App\Models\User');

    }


    public function target()
    {
        return $this->morphTo();

    }


    //
}
