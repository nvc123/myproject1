<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Article;
use App\Http\Controllers\HomeController;
use App\Models\Tag;
use Carbon\Carbon;
use App\Models\Category;
	

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('first');

    }


    public function index()
    {
	$users=User::all();
	$isAdmin=(Auth::user()->role=='admin');
        
        //от {{$article->author()->name}} в категории {{$article->category()->name}}
        return view('user.users', [
	    'title' => 'Пользователи',
	    'isAdmin' => $isAdmin,
	    'users' => $users,
	    ]);

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id, Request $request)
    {
        $user = User::find($id);
    	$page = $request['page'];
        if ($page == null) {
            $page = 1;
        }
	$alltags = Tag::all();
        $name = $request['name'];
        $date = $request['daterange'];
        $category = $request['category'];
        $texttags = '';
        $categories = Category::all();
        $ids = $request['tags'];
	if ($ids != null && count($ids)>0){
            $tags = Tag::find($ids);
	    $texttags = $tags->implode('id', ',');
	}
        $mquery = $user->articles()->where('status', 'published');
	$mquery = HomeController::filters($request, $mquery);
	$articles = $mquery->paginate(HomeController::ARITCLES_PER_PAGE);
	if ($request->ajax()) {
            if ($articles != null && count($articles) > 0) {
                return view('article.ajax', [
                    'articles' => $articles,
                    'page' => $request['page']])->render();
            } else {
                return null;
            }
        }
	$maxs=$user->articles()->orderBy('views', 'desc')->limit(5)->get();
	$cuser = Auth::user();
	$target=User::find($id);
	$subscribesCount=$target->subscribes()->where('user_id', $cuser->id)->count();
	$isSubscribed=($subscribesCount!=0);
	$isAdmin=($cuser->role=='admin');
        return view('user.view', [
        'user' => $user,
        'page' => $page,
        'articles' => $articles,
        'isSubscribed' => $isSubscribed,
        'isAdmin' => $isAdmin,
        'maxArticles' => $maxs,
        'texttags' => $texttags,
        'name' => $name,
        'daterange' => $date,
        'categories' => $categories,
        'category' => $category,
        'alltags' => $alltags,
        'title' => 'Профиль пользователя ' . $user->name]);

    }

    public function myArticles(Request $request)
    {
        $user = Auth::user();
    	$page = $request['page'];
        if ($page == null) {
            $page = 1;
        }
	$articles=$user->articles()->paginate(HomeController::ARITCLES_PER_PAGE);
	if ($request->ajax()) {
            if ($articles != null && count($articles) > 0) {
                return view('article.ajax', [
                    'articles' => $articles,
                    'page' => $request['page']])->render();
            } else {
                return null;
            }
        }
        return view('user.articles', [
        'user' => $user,
        'page' => $page,
        'articles' => $articles,
        'title' => 'Мои статьи']);

    }


}
/*
    <select class="js-example-basic-multiple input-medium" name="tags[]" multiple="multiple">
        @foreach($alltags as $tag)
          <option value="{{$tag->id}}">{{$tag->name}}</option>
        @endforeach
    </select>
*/