<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use Carbon\Carbon;
use App\Models\Category;

class HomeController extends Controller
{
    const ARITCLES_PER_PAGE = 18;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('first');

    }


    public static function filters(Request $request, $mquery)
    {
      	$ids = $request['tags'];
        $name = $request['name'];
        $date = $request['daterange'];
        $username = $request['username'];
        $category = $request['category'];
        if ($name != null) {
            $mquery = $mquery->where(function($query) use ($name){
		$query->where('name', 'like', '%' . $name . '%');
		$query->orWhere('description', 'like', '%' . $name . '%');
	    });
        } else {
            $name = '';
        }

        if ($date != null) {
            $dates = explode(' - ', $date);
            //$title=$date;
            $mquery = $mquery->whereDate('date', '>=', Carbon::parse($dates[0]))->whereDate('date', '<=', Carbon::parse($dates[1]));
        } else {
            $date = '';
        }

        if ($username != null) {
            $mquery = $mquery->whereHas('author', function ($query) use ($username) {
                $query->where('name', 'like', '%' . $username . '%');
            });
        } else {
            $username = '';
        }

        if ($category != null) {
            $mquery = $mquery->where('category_id', $category);
        } else {
            $category = '';
        }

        if (count($ids) > 0) {
            foreach ($ids as $id) {
                $mquery = $mquery->whereHas('tags', function ($query) use ($id) {
                    $query->where('tags.id', $id);
                });
            }
        }
	return $mquery;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alltags = Tag::all();
        $name = $request['name'];
        $date = $request['daterange'];
        $username = $request['username'];
        $category = $request['category'];
        $texttags = '';
        $categories = Category::all();
        $title = 'Главная страница';
        $mquery = Article::where('status', 'published');
        $mquery = self::filters($request, $mquery);
        $articles = $mquery->paginate(self::ARITCLES_PER_PAGE);
	$ids = $request['tags'];
	if ($ids != null && count($ids)>0){
            $tags = Tag::find($ids);
	    $texttags = $tags->implode('id', ',');
	}
        //?tags[]=1&tags[]=13
        if ($request->ajax()) {
            if ($articles != null && count($articles) > 0) {
                return view('article.ajax', [
                    'articles' => $articles,
                'page' => $request['page']])->render();
            } else {
                return null;
            }
        }

        $page = $request['page'];
        if ($page == null) {
            $page = 1;
        }

        return view('home', [
        'title' => $title,
        'articles' => $articles,
        'page' => $page,
        'texttags' => $texttags,
        'name' => $name,
        'daterange' => $date,
        'username' => $username,
        'categories' => $categories,
        'category' => $category,
        'alltags' => $alltags]);

    }


    //style="display:none"
    // style="display:none"
    //@each('article.item', $articles, 'article')
    //<span> &ensp;|&ensp;</span></span>
    /*
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Главная страница</div>

                @include('article.list')
            </div>
        </div>

    <div class="row container" style="margin-top:20px">
        <img class="float-left" src="/{{$article->foto->name}}" alt="{{$article->name}}" style="width:200px">
    </div>

    navbar navbar-expand-md navbar-light navbar-laravel
    navbar navbar-default navbar-fixed-top animated fadeInDown

    <div id="page{{$page}}">
    </div>


    <p class="card-text">{{$article->date}}
        от <a href="#">{{$article->author->name}}</a>
        в категории <a href="{{ route('categories') }}/{{$article->category->id}}">{{$article->category->name}}</a>
        </p>
    */
}
