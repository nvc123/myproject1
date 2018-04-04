<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    
    public function articles()
    {
        return $this->hasMany('App\Models\Article');

    }


    public function subscribes()
    {
        return $this->morphMany('App\Models\Subscribe', 'target');

    }


    //
}
