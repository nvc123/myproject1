<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];

    
    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');

    }


    //
}
