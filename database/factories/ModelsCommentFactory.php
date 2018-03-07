<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->paragraph,
	'date' => new DateTime(),
	'user_id' => function () {
	    $uu=App\Models\User::inRandomOrder()->first();
	    if($uu==null){
            	return factory(App\Models\User::class)->create()->id;
	    }else{
		return $uu->id;
	    }
        },
	'article_id' => function () {
	    $aa=App\Models\Article::inRandomOrder()->first();
	    if($aa==null){
            	return factory(App\Models\Article::class)->create()->id;
	    }else{
		return $aa->id;
	    }
        }
    ];
});
