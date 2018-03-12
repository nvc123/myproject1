<?php

use Faker\Generator as Faker;

$factory->define(App\Models\File::class, function (Faker $faker) {
    return [
        'name' => 'test_foto.png',
	'article_id' => function () {
	    return App\Models\Article::inRandomOrder()->first()->id;
        }
	
    ];
});
