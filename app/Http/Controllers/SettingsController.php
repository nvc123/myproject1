<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\User;
use App\Models\Notification;


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
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'text' => 'required|string|min:6',
        ]);
        $user = Auth::user();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->text = $validatedData['text'];
        $user->timestamps = false;
        $user->save();
        return redirect()->back();

    }


    protected function articles()
    {
    
    }
    

    protected function getNotifications()
    {
        $user = Auth::user();
        $notifications=$user->notifications;// don't work
        //$notifications = Notification::where('user_id', $user->id)->get(); // TODO: костыль
        return view('user.notifications', ['notifications' => $notifications,
                       'title' => 'Уведомления']);

    }

    protected function removeAllNotifications()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)->delete();
        return redirect()->back();

    }


    protected function removeNotification($id)
    {
        $user = Auth::user();
        $notification = Notification::find($id);
        if ($notification->receiver->id === $user->id) {
            $notification->delete();
        }

        return redirect()->back();

    }


}
