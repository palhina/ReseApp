<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;

class HomeControllerTest extends TestCase
{
   use RefreshDatabase;

    // 店舗一覧ページ表示テスト
    public function test_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('shop_all');
    }

    // 店舗詳細情報表示テスト
    public function test_detail()
    {
        $shop = Shop::factory()->create();
        $response = $this->get("/detail/{$shop->id}");
        $response->assertStatus(200);
        $response->assertViewIs('shop_detail');
    }

    // マイページ表示テスト
    public function test_myPage()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id'=>$user->id]);
        $favorite =  Favorite::factory()->create(['user_id'=>$user->id]);
        $this->actingAs($user);
        $response = $this->get('/my_page');
        $response->assertStatus(200);
        $response->assertViewIs('my_page');
    }
}
