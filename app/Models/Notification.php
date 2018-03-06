<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	public $timestamps = false;
	
	public function receiver()
	{
	  return $this->hasOne('App\Models\User');
	}
    //
}
