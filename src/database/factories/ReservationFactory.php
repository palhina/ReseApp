<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;
use App\Models\User;
use App\Models\Reservation;

class ReservationFactory extends Factory
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
            'rsv_date' => $this->faker->dateTimeBetween('2001-01-01', '2051-12-31')->format('Y-m-d'),
            'rsv_time' => $this->faker->dateTimeBetween('09:00:00', '22:00:00')->format('H:i:s'),
            'rsv_guests' => $this->faker->numberBetween(1, 10),
        ];
    }
}
