<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Notification;

class ModeratorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('first');
    }

    public function index()
    {
	$articles=Article::where('status', 'moderated')->get();
        return view('moderator.view', [
        'articles' => $articles,
        'title' => 'Модерация']);
    }


    public function statusPublished($id)
    {
        $article = Article::find($id);
	if($article->status=='moderated'){
	    $article->status='published';
	    $article->save();
	    $user=$article->author;
	    Notification::create(['user_id' => $user->id, 'type' => 0,
	        'payload' => '{ "article":' . $article->id . ', "status": "published"}']);
	    return view('moderator.successfully', [
            'title' => 'Статья опубликована',
            'listType' => 'moderator',
            'article' => $article]);
	}
	// TODO: error
        return null;
    }

    public function statusNotPublished($id, Request $request)
    {
        $article = Article::find($id);
	if($article->status=='moderated'){
	    $article->status='not_published';
	    $article->save();
	    $user=$article->author;
	    Notification::create(['user_id' => $user->id, 'type' => 0, 
	        'payload' => '{ "article":' . $article->id . ', "status": "not_published" , "text":"'.$request['text'].'"}']);
	    return view('moderator.successfully', [
            'title' => 'Статья снята с публикации',
            'listType' => 'moderator',
            'article' => $article]);
	}
	// TODO: error
        return null;
    }


    public function statusLocked($id, Request $request)
    {
        $article = Article::find($id);
	if($article->status=='published'){
	    $article->status='locked';
	    $article->save();
	    $user=$article->author;
	    Notification::create(['user_id' => $user->id, 'type' => 0, 
	        'payload' => '{ "article":' . $article->id . ', "status": "locked" , "text":"'.$request['text'].'"}']);
	    return view('moderator.successfully', [
            'title' => 'Статья успешно заблокирована',
            'listType' => 'moderator',
            'article' => $article]);
	}
	// TODO: error
        return null;
    }

}
