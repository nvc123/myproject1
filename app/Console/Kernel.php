<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
	$schedule->call(function () {
	    if(Config::get('app.caching_like_articles')){
      	    	$articles=Article::all();
	    	foreach ($articles as $article)
	    	{
	    	    $likes=$article->forceLikeArticles();
	    	    $minutes=60;
            	    Cache::put('like_articles_'.$article->id, $likes, $minutes); 
	    	}
	    }
    	})->hourly();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');

    }


}
