<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; 

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => 'admin_test',
                'email' => 'admin1@mail.com',
                'password' =>bcrypt('1234567890'),
            ],
        ];
        foreach ($admins as $admin) 
        {
            Admin::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => $admin['password'],
            ]);
        }
    }
}
