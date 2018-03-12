<?php

use Illuminate\Database\Seeder;

class SubscribesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Subscribe::class, 20)->create()->each(function($u) {
		$r=rand(0, 2);
		if($r===0){
        		$u->target()->save(App\Models\User::inRandomOrder()->first());
		}elseif ($r ===1) {
			$u->target()->save(App\Models\Category::inRandomOrder()->first());
		}
    	});
    }
}
