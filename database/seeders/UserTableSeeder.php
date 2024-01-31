<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // creating admin
        User::create([
            "name" => "admin",
            "username" => "admin",
            "email" => "admin@gmail.com",
            "role" => \Role::Admin,
            "password" => "12345678",
        ]);

        $users = [
            [
                'name' => 'User One',
                'username' => 'UserOne',
                'email' => 'userone@example.com',
            ],
            [
                'name' => 'User Two',
                'username' => 'UserTwo',
                'email' => 'usertwo@example.com',
            ],
            [
                'name' => 'User Three',
                'username' => 'UserThree',
                'email' => 'userthree@example.com',
            ],
            [
                'name' => 'User Four',
                'username' => 'UserFour',
                'email' => 'userfour@example.com',
            ],
            [
                'name' => 'User Five',
                'username' => 'UserFive',
                'email' => 'userfive@example.com',
            ],
        ];

        /* 
            Here we use loop to create some dummy users if they are more than this
            then we can use insert to reduce database queries
        */


        foreach ($users as $user) {
            User::create([
                "name" => $user['name'],
                "username" => $user['username'],
                "email" => $user['email'],
                "password" => "12345678",
            ]);
        }
    }
}
