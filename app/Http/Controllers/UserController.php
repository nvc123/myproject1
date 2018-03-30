<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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
    public function get($id)
    {
        $user = User::find($id);
    
        return view('user.view', [
        'user' => $user,
        'title' => 'Профиль пользователя ' . $user->name]);

    }


}
/*
    <select class="js-example-basic-multiple input-medium" name="tags[]" multiple="multiple">
        @foreach($alltags as $tag)
          <option value="{{$tag->id}}">{{$tag->name}}</option>
        @endforeach
    </select>
*/