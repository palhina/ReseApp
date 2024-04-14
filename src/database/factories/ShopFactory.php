<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Manager;

class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'area_id' => function () {
                return Area::factory()->create()->id;
            },
            'genre_id' => function () {
                return Genre::factory()->create()->id;
            },
            'manager_id'=> function () {
                return Manager::factory()->create()->id;
            },
            'shop_name' => $this->faker->company,
            'shop_photo' => $this->faker->imageUrl(),
            'shop_comment' => $this->faker->paragraph,
        ];
    }
}
