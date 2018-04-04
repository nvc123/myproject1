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

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('first');
        $this->middleware('admin');
    }


    public function editCategory($id, Request $request)
    {
	if($id==0){
    	    $name=$request['name'];
	    if($name!=null && $name!=''){
	    	$category = Category::create(['name' => $name]);
		return redirect()->back();
	    }
	    return redirect()->back()->with('message', 'Невозможно создать категорию без имени');
	}
        $category = Category::find($id);
    	$name=$request['name'];
	if($name!=null && $name!=''){
	    $category->name=$name;
	    $category->save();
	}
	return redirect()->back();
    }

    public function removeCategory($id, Request $request)
    {
        $category = Category::find($id);
    	$count=$category->articles()->count();
	if($count==0){
	    $category->delete();
	    return redirect()->back();
	}
	return redirect()->back()->with('message', 'Невозможно удалить категорию т.к. в ней есть статьи');
    }

    public function lockUser($id)
    {
        $user = User::find($id);
    	$user->status=false;
	$user->save();
	return redirect()->back();//->with('message', 'Невозможно удалить категорию т.к. в ней есть статьи');
    }

    public function unlockUser($id)
    {
        $user = User::find($id);
    	$user->status=true;
	$user->save();
	return redirect()->back();//->with('message', 'Невозможно удалить категорию т.к. в ней есть статьи');
    }

    public function createUserPage()
    {
	$roles=['user', 'moderator', 'admin'];
    	return view('admin.createUser', ['roles' => $roles]);
    }

    public function createUser(Request $request)
    {
	$validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'role'     => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
        try {
            $validatedData['password']        = bcrypt(array_get($validatedData, 'password'));
            $validatedData['activation_code'] = '';
            $validatedData['text'] = null;
	    $validatedData['status'] = true;
	    
            $user                             = User::create($validatedData);
        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect()->back()->with('message', $exception->getMessage());
        }
    	return redirect()->route('users');
    }

    public function editUserPage($id)
    {
	$user=User::find($id);
	$roles=['user', 'moderator', 'admin'];
    	return view('admin.editUser', [
		'roles' => $roles,
		'user' => $user]);
    }

    public function removeUser($id)
    {
	if($id != Auth::user()->id){
	    $user=User::find($id);
	    $user->delete();
	}
	return redirect()->route('users');
    }


    public function editUser($id, Request $request)
    {
	$user=User::find($id);
	if($user->email==$request['email']){
	    $validatedData = $request->validate([
            	'name'     => 'required|string|max:255',
            	'role'     => 'required|string',
            ]);
	}else{
	    $validatedData = $request->validate([
            	'name'     => 'required|string|max:255',
            	'role'     => 'required|string',
		'email'    => 'required|string|email|max:255|unique:users',
            ]);
	}
	//'email'    => 'required|string|email|max:255|unique:users',
	
        try {
	    if($request['password']!=null && strlen($request['password'])>2){
	    	$user->password=bcrypt(array_get($request, 'password'));
	    }
	    $user->name=$validatedData['name'];
	    $user->email=$request['email'];
	    $user->text=$request['text'];
	    $user->role=$validatedData['role'];
	    $user->save();
        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect()->back()->with('message', $exception->getMessage());
        }
    	return redirect()->route('users');
    }

}
