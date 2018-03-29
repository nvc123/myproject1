<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	public $timestamps = false;
	protected $guarded = ['id'];
	
	public function article()
	{
	  return $this->belongsTo('App\Models\Article');
	}

	public function author()
	{
	  return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

    //
}
