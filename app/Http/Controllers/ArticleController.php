<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\Category;
use App\Models\Tag;


class ArticleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
	$this->middleware('first');
    }

    public function index()
    {
	//от {{$article->author()->name}} в категории {{$article->category()->name}}
	$articles=Article::whereHas('tags', function ($query) {
	    $query->where('tags.id', '1');
	})->get();
	$title=count($articles);
        return view('article.test', ['title' => $title,
				     'articles' => $articles]); 
    }

    public function get($id)
    {
	$article=Article::find($id);
        return view('article.view', [
		'title' => $article->name,
		'article' => $article]); 
    }

    public function postComment($id, Request $request)
    {
	$article=Article::find($id);
	$user = Auth::user();
        $comment=Comment::create(['text' => $request['text'],
				  'date' => new \DateTime(),
				  'user_id' => $user->id,
				  'article_id' => $article->id]);
	return redirect()->back();
    }

    public function createArticlePage(Request $request)
    {
	$categories=Category::all();
	$alltags=Tag::all();
	return view('article.create', [
		'title' => 'Новая статья',
		'categories' => $categories,
		'alltags' => $alltags]); 
    }

    public function createArticle(Request $request)
    {
	return $this->postArticle(0, $request);
    }

    public function postArticle($id, Request $request)
    {
	$validatedData = $request->validate([
            'name'     => 'required|string|min:3',
            'description'    => 'required|string|min:6',
            'text' => 'required|string|min:6',
	    'categories' => 'required',
	    'img' => 'required'
        ]);
	$f=$request->file('img');
	$user = Auth::user();
	//$path = Storage::putFileAs('/', $f, $f->getClientOriginalName());
	$tags=Tag::find($request['tags']);
	$destinationPath = public_path('/');
	$fname=$f->getClientOriginalName();
	$f->move($destinationPath, $f->getClientOriginalName());
	$file=File::create(['name' => $fname, 'article_id' => 0]);
	if($id==0){
	    $article=Article::create(['name' => $validatedData['name'],
				      'description' =>$validatedData['description'],
				      'text' =>$validatedData['text'],
				      'category_id' =>$validatedData['categories'],
				      'file_id' =>$file->id,
				      'user_id' =>$user->id,
				      'status' => 'published',
				      'comments_count' => 0,
				      'date' =>new \DateTime(),
				      'views' => 0]);
	}else{
	    
	}
	$article->tags()->saveMany($tags);
	return redirect('/article/'.$article->id);
    }

/*
<div class="row">
		@each('comment.view', $article->comments, 'comment')
	    <div>
*/
}
