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
        $user1 = \App\User::create([
           'name' => 'Som Chanda',
            'username' => 'chanda',
            'email' => 'somchanda18@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar1.jpg'
        ]);

        $user2 = \App\User::create([
            'name' => 'user2',
            'username' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar2.jpg'
        ]);

        $user3 = \App\User::create([
            'name' => 'user3',
            'username' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar3.jpg'
        ]);

        $user4 = \App\User::create([
            'name' => 'user4',
            'username' => 'user4',
            'email' => 'user4@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar4.jpg'
        ]);

        $user5 = \App\User::create([
            'name' => 'user 5',
            'username' => 'user5',
            'email' => 'user5@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar5.jpg'
        ]);

        $user6 = \App\User::create([
            'name' => 'user 6',
            'username' => 'user6',
            'email' => 'user6@gmail.com',
            'password' => Hash::make('chanda'),
            'avatar' => 'avatar6.jpg'
        ]);

        \App\followship::create([
           'user1_id' => $user2->id,
           'user2_id' => 1
        ]);

        \App\followship::create([
            'user1_id' => $user3->id,
            'user2_id' => 1
        ]);

        \App\followship::create([
            'user1_id' => $user4->id,
            'user2_id' => 1
        ]);

        \App\followship::create([
            'user1_id' => $user5->id,
            'user2_id' => 1
        ]);

        \App\followship::create([
            'user1_id' => 1,
            'user2_id' => $user6->id
        ]);

        \App\followship::create([
            'user1_id' => 6,
            'user2_id' => $user3->id
        ]);
    }
}
