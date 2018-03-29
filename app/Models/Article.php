<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	public $timestamps = false;
	protected $guarded = ['id'];
	
	public function files()
	{
	  return $this->hasMany('App\Models\File');
	}

	public function comments()
	{
	  return $this->hasMany('App\Models\Comment');
	}

	public function incrCommentCount()
	{
	  $this->comments_count++;
	  $this->timestamps = false;
	  $this->save();
	}

	public function author()
	{
	  return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

	public function category()
	{
	  return $this->belongsTo('App\Models\Category');
	}

	public function foto()
	{
	  return $this->belongsTo(\App\Models\File::class, 'file_id');
	}

	public function tags()
	{
	  return $this->belongsToMany('App\Models\Tag', 'article_tags');
	}
    //
}
