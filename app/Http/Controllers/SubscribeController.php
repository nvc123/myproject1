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
use App\Models\Subscribe;
use App\Models\Notification;


class SubscribeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('first');
        //$this->middleware('exist.category');
    }

    
    public function onUser($id)
    {
        $user = Auth::user();
	$target=User::find($id);
	$subscribesCount=$target->subscribes()->where('user_id', $user->id)->count();
	if($subscribesCount==0){
	    $subscribe=Subscribe::create(['user_id' => $user->id]);
	    $subscribe->target()->associate($target);
	    $subscribe->save();
	    //return $subscribesCount;
	}
	return redirect()->back();
    }

    public function onCategory($id)
    {
        $user = Auth::user();
	$target=Category::find($id);
	$subscribesCount=$target->subscribes()->where('user_id', $user->id)->count();
	if($subscribesCount==0){
	    $subscribe=Subscribe::create(['user_id' => $user->id]);
	    $subscribe->target()->associate($target);
	    $subscribe->save();
	    //return $subscribesCount;
	}
	return redirect()->back();
    }
    
    public static function sendNotification($target, $articleId, $ids)
    {
	if($ids==null){
	    $ids=[];
	}
	$nids=[];
	$subscribes=$target->subscribes()->whereNotIn('user_id', $ids)->get();
	foreach ($subscribes as $subscribe)
	{
	    $nids[]=$subscribe->user_id;
	    Notification::create(['user_id' => $subscribe->user_id, 'type' => 2,
	        'payload' => '{ "article":' . $articleId . '}']);
	}
	return $nids;
    }

}
