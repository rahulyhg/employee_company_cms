<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'name'           => 'Administrator',
            'email'          => 'admin@site.com',
            'type'          => 'admin',
            'password'       => bcrypt('password'),
            'remember_token' => str_random(10),
        ]);

        User::create([
            'name'           => 'Administrator',
            'email'          => 'manager@site.com',
            'type'          => 'manager',
            'password'       => bcrypt('password'),
            'remember_token' => str_random(10),
        ]);
    }
}
