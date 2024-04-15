<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use Carbon\Carbon;

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
            'email_verified_at' => Carbon::now(),
        ],
        [
            'name' => 'test2',
            'email' => '222@mail.com',
            'password' => bcrypt('1234567890'),
            'email_verified_at' => null
        ],
        ];
        foreach ($users as $user) 
        {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'email_verified_at' => $user['email_verified_at']
            ]);
        }
    }
}
