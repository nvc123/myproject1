<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public $timestamps = false;
	
	public function articles()
	{
	  return $this->hasMany('App\Models\Article');
	}

	public function subscribes()
	{
	  return $this->morphMany('App\Models\Subscrabe', 'target');
	}
    //
}
