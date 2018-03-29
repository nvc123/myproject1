<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
	'text' => $faker->paragraph,
	'description' => $faker->paragraph,
	'views' => 0,
	'date' => new DateTime(),
	'status' => 'published',
	'category_id' => function () {
            $uu=App\Models\Category::inRandomOrder()->first();
	    if($uu==null){
            	return factory(App\Models\Category::class)->create()->id;
	    }else{
		return $uu->id;
	    }
        },
	'user_id' => function () {
	    $uu=App\Models\User::inRandomOrder()->first();
	    if($uu==null){
            	return factory(App\Models\User::class)->create()->id;
	    }else{
		return $uu->id;
	    }
        },
	
	'file_id' => function () {
            return factory(App\Models\File::class)->create(['article_id' => 0])->id;
        },
	'comments_count' => 0
    ];
});
