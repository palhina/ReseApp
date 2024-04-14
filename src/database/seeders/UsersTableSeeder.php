<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        [
            'name' => 'test',
            'email' => '111@mail.com',
            'password' =>bcrypt('1234567890'),
        ],
        [
            'name' => 'test2',
            'email' => '222@mail.com',
            'password' => bcrypt('1234567890')
        ],
        ];
        foreach ($users as $user) 
        {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
            ]);
        }
    }
}
