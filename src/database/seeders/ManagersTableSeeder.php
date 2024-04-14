<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Manager; 

class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $managers = [
            [
                'name' => 'manager1',
                'email' => 'manager1@mail.com',
                'password' =>bcrypt('1234567890'),
            ],
            [
                'name' => 'manager2',
                'email' => 'manager2@mail.com',
                'password' =>bcrypt('1234567890'),
            ],
        ];
        foreach ($managers as $manager) 
        {
            Manager::create([
                'name' => $manager['name'],
                'email' => $manager['email'],
                'password' => $manager['password'],
            ]);
        }
    }
}
