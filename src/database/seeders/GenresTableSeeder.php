<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre; 

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ['寿司', '焼肉', '居酒屋', 'イタリアン', 'ラーメン'];

        Genre::insert(array_map(function ($genre) {
            return ['shop_genre' => $genre];
        }, $genres));
    }
}
