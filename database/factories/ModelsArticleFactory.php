<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
	'text' => $faker->paragraph,
	'description' => $faker->paragraph,
	'views' => 0,
	'date' => new DateTime(),
	'status' => 'new',
	'category_id' => function () {
            return App\Models\Category::inRandomOrder()->firstOrCreate(['name' => 'Category1'])->id;
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
            return factory(App\Models\File::class)->create()->id;
        }
    ];
});
