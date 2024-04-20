<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = ['東京都', '大阪府', '福岡県'];
        Area::insert(array_map(function ($area) {
            return ['shop_area' => $area];
        }, $areas));
    }
}
