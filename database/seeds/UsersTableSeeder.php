<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'appnotifications',
            'email' => 'appnotifications@email.com',
            'password' => bcrypt('123456'),
        ]);

        factory(User::class, 10)->create();
    }
}
