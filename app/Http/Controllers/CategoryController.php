<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('first');
        $this->middleware('exist.category');
    }

    public function index()
    {
        //от {{$article->author()->name}} в категории {{$article->category()->name}}
        $articles = Category::all();
        $user = Auth::user();
	$isAdmin=($user->role=='admin');
        return view('category.index', [
        'title' => 'Все Категории',
        'isAdmin' => $isAdmin,
        'categories' => $articles]);

    }

    public function articles($id, Request $request)
    {
        $category = Category::find($id);
        $mquery = $category->articles()->where('status', 'published');
	$mquery = HomeController::filters($request, $mquery);
	$articles = $mquery->paginate(HomeController::ARITCLES_PER_PAGE);
	$page = $request['page'];
        if ($page == null) {
            $page = 1;
        }
	$alltags = Tag::all();
        $name = $request['name'];
        $date = $request['daterange'];
        $username = $request['username'];
        $texttags = '';
        $ids = $request['tags'];
	if ($ids != null && count($ids)>0){
            $tags = Tag::find($ids);
	    $texttags = $tags->implode('id', ',');
	}
        
	if ($request->ajax()) {
            if ($articles != null && count($articles) > 0) {
                return view('article.ajax', [
                    'articles' => $articles,
                    'page' => $request['page']])->render();
            } else {
                return null;
            }
        }
	$categoryId=$category->id;
	$ausers=Article::select('user_id', DB::raw('SUM(views) as total_views'))->where('category_id', $category->id)->groupBy('user_id')->orderBy('total_views', 'desc')->limit(5)->get();
	$users=[];
	foreach ($ausers as $auser)
	{
	    $uu1=User::find($auser->user_id);
	    $uu1->total=$auser->total_views;
	    $users[]=$uu1;
	}
	$maxs=$category->articles()->orderBy('views', 'desc')->limit(5)->get();
        $cuser = Auth::user();
	$target=$category;
	$subscribesCount=$target->subscribes()->where('user_id', $cuser->id)->count();
	$isSubscribed=($subscribesCount!=0);
        return view('category.articles', [
        'title' => 'Категория ' . $category->name,
	'page' => $page,
        'texttags' => $texttags,
        'name' => $name,
        'category' => $category,
        'users' => $users,
        'ausers' => $ausers,
        'isSubscribed' => $isSubscribed,
        'maxArticles' => $maxs,
        'daterange' => $date,
        'username' => $username,
        'alltags' => $alltags,
        'articles' => $articles]);
    }


}
