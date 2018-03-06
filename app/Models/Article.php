<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	public $timestamps = false;
	
	public function files()
	{
	  return $this->hasMany('App\Models\File');
	}

	public function comments()
	{
	  return $this->hasMany('App\Models\Comment');
	}

	public function author()
	{
	  return $this->hasOne('App\Models\User');
	}

	public function foto()
	{
	  return $this->hasOne('App\Models\File');
	}

	public function tags()
	{
	  return $this->belongsToMany('App\Models\Tag', 'a2_ts');
	}
    //
}
