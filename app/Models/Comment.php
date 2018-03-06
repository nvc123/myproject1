<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	public $timestamps = false;
	
	public function article()
	{
	  return $this->hasOne('App\Models\Article');
	}

	public function author()
	{
	  return $this->hasOne('App\Models\User');
	}

    //
}
