<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Notification::class, function (Faker $faker) {
    return [
        'user_id' => function () {
	    $uu=App\Models\User::inRandomOrder()->first();
	    if($uu==null){
            	return factory(App\Models\User::class)->create()->id;
	    }else{
		return $uu->id;
	    }
        },
	'type' => 0,
	'payload' => '' // TODO: json
    ];
});
