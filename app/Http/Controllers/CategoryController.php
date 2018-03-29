<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\HomeController;

class CategoryController extends Controller
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


    public function articles($id)
    {
	$category=Category::find($id);
	$articles=Article::where('status', 'published')->where('id', $id)->paginate(HomeController::ARITCLES_PER_PAGE);
        return view('category.articles', [
		'title' => 'Все статьи в категории '.$category->name,
		'articles' => $articles]); 
    }

}
