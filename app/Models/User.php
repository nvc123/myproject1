<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

	public $role;
	public $timestamps = false;
	
	public function articles()
	{
	  return $this->hasMany('App\Models\Article');
	}

	public function notifications()
	{
	  return $this->hasMany('App\Models\Notification');
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
    //
}
