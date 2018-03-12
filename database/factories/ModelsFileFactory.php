<?php

use Faker\Generator as Faker;

$factory->define(App\Models\File::class, function (Faker $faker) {
    return [
        'name' => 'test_foto.png'
	'article_id' => function () {
	    $uu=App\Models\Article::inRandomOrder()->first();
	    if($uu==null){
            	return factory(App\Models\Article::class)->create()->id;
	    }else{
		return $uu->id;
	    }
        }
    ];
});
