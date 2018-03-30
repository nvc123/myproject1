<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];

/*
ids:
0 - article status changed { "article": id, "status": status , "text": comment  }
1 - new comment { "article": id}
*/
        
    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');

    }


    //
}
