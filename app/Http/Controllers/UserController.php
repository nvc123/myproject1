<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Article;
use App\Http\Controllers\HomeController;


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
        //от {{$article->author()->name}} в категории {{$article->category()->name}}
        return view('article.test', []);

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
        return view('user.view', [
        'user' => $user,
        'page' => $page,
        'articles' => $articles,
        'title' => 'Профиль пользователя ' . $user->name]);

    }

    public function myArticles(Request $request)
    {
        $user = User::find(Auth::user()->id); // костыль для работы отношений
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