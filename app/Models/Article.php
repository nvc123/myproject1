<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Tag;


class Article extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];

    
    public function files()
    {
        return $this->hasMany('App\Models\File')->where('name', 'not like', '%.png');
    }

    public function imgs()
    {
        return $this->hasMany('App\Models\File')->where('name', 'like', '%.png');
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


    public function likeArticles()
    {
	$article=$this;
	if(Config::get('app.caching_like_articles')){
	    $articles=Cache::get('like_articles_'.$article->id);
	    if($articles==null){
		$likes=$this->forceLikeArticles();
	    	$minutes=60;
            	Cache::put('like_articles_'.$article->id, $likes, $minutes);
	    }
	}else{
	    $articles=$this->forceLikeArticles();
	}
	return $articles;
    }

    public function forceLikeArticles()
    {
	$article=$this;
        $tagsid=[];
	$tags=$article->tags;
	foreach ($tags as $tag0)
	{
	    $tagsid[]=$tag0->id;
	}
	$articles=$article->category->articles()->where('id', '!=', $article->id)->withCount(['tags' => function ($query) use($tagsid)
	{
	    $query->whereIn('article_tags.tag_id', $tagsid);
	}])->orderBy('tags_count', 'desc')->orderBy('views', 'desc')->limit(5)->get();
	/*
	$tagsCount=count($article->tags);
	while($tagsCount>=0){
	    $mquery=$category->articles();
	    $tags=$article->tags()->limit($tagsCount)->get();
	}
	*/
	return $articles;
    }

    //
}
