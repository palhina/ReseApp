<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(GenresTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(ReservationsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(ManagersTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
    }
}