<?php

use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	/*
	factory(App\Models\Article::class, 30)->create()->each(function($u) {
        	$u->tags()->save(App\Models\Tag::inRandomOrder()->limit(rand(1, 5))->get());
    	});
	*/ 
	factory(App\Models\Article::class, 30)->create();
    }
}
