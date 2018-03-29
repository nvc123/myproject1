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
	factory(App\Models\User::class)->create([
		'name' => 'root',
		'password' => bcrypt('147258369'),
		'role' => 'admin',
		'email' => 'nvc60@mail.ru'
	]);
	factory(App\Models\User::class, 10)->create();
    }
}
