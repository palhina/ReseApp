<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating; 

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratings = [
            [
                'user_id' => '1',
                'shop_id' => '1',
                'rating' => '4',
                'comment' =>'コースでいい値段ですが、お店の雰囲気はフォーマルな感じではなくカジュアルでいい雰囲気です。予約していきましたが、テーブルに感謝のメッセージが書かれてありました。',
                'rating_img' => '/images/sushi.jpg',
            ],
            [
                'user_id' => '2',
                'shop_id' => '1',
                'rating' => '5',
                'comment' =>'カジュアルな夜のお出かけにお勧めのスポット',
                'rating_img' => null,
            ],
            [
                'user_id' => '1',
                'shop_id' => '2',
                'rating' => '1',
                'comment' =>'提供が遅く、店員の愛想も悪い。もう二度と行きません。',
                'rating_img' => null,
            ],
            [
                'user_id' => '1',
                'shop_id' => '3',
                'rating' => '3',
                'comment' =>  null,
                'rating_img' => null,
            ],
        ];
        foreach ($ratings as $rating) 
        {
            Rating::create([
                'user_id' => $rating['user_id'],
                'shop_id' => $rating['shop_id'],
                'rating' => $rating['rating'],
                'comment' => $rating['comment'],
                'rating_img' => $rating['rating_img'],
            ]);
        }
    }
}
