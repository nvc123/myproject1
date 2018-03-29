<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;

class TagController extends Controller
{
    //
    public function index()
    {
	//от {{$article->author()->name}} в категории {{$article->category()->name}}
	$articles=Category::all();
        return view('category.index', [
		'title' => 'Все Категории',
		'categories' => $articles]);
    }


    public function articles(Request $request)
    {
	$ids=$request['tags'];
	$mquery=Article::where('status', 'published');
	if(count($ids)>0){
	    foreach ($ids as $id)
	    {
		$mquery=$mquery->whereHas('tags', function ($query) use($id) {
	    	    $query->where('tags.id', $id);
		});
	    }
	    
	}//?tags[]=1&tags[]=13
	$articles=$mquery->get();
        return view('tag.articles', [
		'title' => 'Поиск по тегам',
		'articles' => $articles]); 
    }

}
