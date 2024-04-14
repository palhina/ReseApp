<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Shop;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    // お気に入り追加機能テスト
    public function test_add_favorite()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $response = $this->actingAs($user)->post("/favorite/{$shop->id}");
        $response->assertOk();
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
    }

    // お気に入り削除機能テスト(店舗一覧ページより)
    public function test_deleteShop()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $favorite = Favorite::factory()->create(['user_id'=>$user->id, 'shop_id'=>$shop->id]);
        $this->actingAs($user)->delete("fav_delete_shop/{$shop->id}");
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
    }

    // お気に入り削除機能テスト(マイページより)
    public function test_deleteMyPage()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $favorite = Favorite::factory()->create(['user_id'=>$user->id, 'shop_id'=>$shop->id]);
        $this->actingAs($user)->delete("fav_delete_mypage/{$shop->id}");
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
    }
}
