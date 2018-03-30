<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $guarded = ['id'];

    
    public function articles()
    {
        return $this->hasMany('App\Models\Article');

    }


    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);

    }


    public function targets()
    {
        return $this->hasMany('App\Models\Subscribe');

    }


    public function comments()
    {
        return $this->hasMany('App\Models\Comment');

    }


    public function subscribes()
    {
        return $this->morphMany('App\Models\Subscribe', 'target');

    }


    public function incrArticlesCount()
    {
        $this->count++;
        $this->timestamps = false;
        $this->save();

    }


    //
}
