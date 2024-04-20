<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $favorites = [
        [
            'user_id' => '1',
            'shop_id' => '1',
        ],
        [
            'user_id' => '1',
            'shop_id' => '2',
        ],
        ];
        foreach ($favorites as $favorite)
        {
            Favorite::create([
                'user_id' => $favorite['user_id'],
                'shop_id' => $favorite['shop_id'],
            ]);
        }
    }
}
