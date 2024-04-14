<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation; 

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reservations = [
        [
            'user_id' => '1',
            'shop_id' => '1',
            'rsv_date' => '2021-4-01',
            'rsv_time' => '17:00',
            'rsv_guests' => '1',
        ],
        ];
        foreach ($reservations as $reservation) 
        {
            Reservation::create([
                'user_id' => $reservation['user_id'],
                'shop_id' => $reservation['shop_id'],
                'rsv_date' => $reservation['rsv_date'],
                'rsv_time' => $reservation['rsv_time'],
                'rsv_guests' => $reservation['rsv_guests'],
            ]);
        }
    }
}
