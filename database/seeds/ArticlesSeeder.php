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
	
	factory(App\Models\Article::class, 300)->create()->each(function($u) {
		$tags=App\Models\Tag::inRandomOrder()->limit(rand(1, 5))->get();
        	$u->tags()->saveMany($tags);
		$files=factory(App\Models\File::class, 10)->create(['article_id' => $u->id]);
    	});
	 
	//factory(App\Models\Article::class, 30)->create();
    }
}
