<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MailNotification;


class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Comment::created(function ($comment) {
            $article = $comment->article;
            $article->incrCommentCount();
            $user = $article->author;
            Notification::create(['user_id' => $user->id, 'type' => 1, 'payload' => '{ "article":' . $article->id . '}']);
        });
        Article::created(function ($article) {
            $user = $article->author;
            $user->incrArticlesCount();
        });
	Notification::created(function ($notification) {
            $user = $notification->receiver;
            $user->notify(new MailNotification($notification));
        });
        //

    }


}
