<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Category;

class CategoryExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	$id=$request->route('id');
        if ($id!=null&&$id!=0) {
	    $article=Category::find($id);
	    if($article==null){
            	return redirect()->route('categories'); //TODO: error
	    }
        }

        return $next($request);
    }
}
