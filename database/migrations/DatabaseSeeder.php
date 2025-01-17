<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => '1', 
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'), 
            'role' => '1'
        ]);
    }
}
