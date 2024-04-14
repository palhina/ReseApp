<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;

class RatingControllerTest extends TestCase
{
    use RefreshDatabase;

    // 評価ページ表示テスト
    public function test_rate()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/rate/{$shop->id}");
        $response->assertStatus(200);
        $response->assertViewIs('rating');
    }

    // 評価機能送信テスト
    public function test_review()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $this->actingAs($user);
        $response = $this->post("/rate/{$shop->id}", [
            'rating' => '5',
            'comment' => 'testComment',
        ]);
        $this->assertDatabaseHas('ratings',[
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'rating' => '5',
            'comment' => 'testComment',
        ]);
        $response->assertViewIs('thanks_rate');
    }
}
