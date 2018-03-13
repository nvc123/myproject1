<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
	$user = Auth::user();
        return view('settings', [
				'name' => $user->name,
				'email' => $user->email,
				'text' => $user->text
				]); 
    } 

    protected function set(Request $request)
    {
        /** @var User $user */
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'text' => 'required|string|min:6',
        ]);
	$user = Auth::user();
        $user->name=$validatedData['name'];
        $user->email=$validatedData['email'];
        $user->text=$validatedData['text'];
	$user->timestamps = false;
	$user->save();
        return redirect()->back();
    }
}
