<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticleExist
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
	$id=$request->route('id');
        if ($id!=null) {
	    $article=Article::find($id);
	    if($article==null){
            	return redirect('/home'); //TODO: error
	    }
        }

        return $next($request);

    }


}
