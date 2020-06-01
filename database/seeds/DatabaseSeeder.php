<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        \App\User::create([
           'name' => 'Som Chanda',
            'username' => 'chanda',
            'email' => 'somchanda18@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar1.jpg'
        ]);

        \App\User::create([
            'name' => 'Test User',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar2.jpg'
        ]);
    }
}
