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
        User::truncate();

        User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.net',
            'password' => bcrypt('password'),
            'is_admin' => true
        ]);
    }
}
