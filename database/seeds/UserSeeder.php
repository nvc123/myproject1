<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	factory(App\Model\User::class)->create([
		'name' => 'root',
		'role' => 'admin'
	]);
	factory(App\Model\User::class, 10)->create();
    }
}
