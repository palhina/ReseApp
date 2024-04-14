<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Shop;

class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },	
            'shop_id' => function () {
                return Shop::factory()->create()->id;
            },
        ];
    }
}
