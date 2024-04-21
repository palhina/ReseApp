<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Manager;
use Illuminate\Support\Facades\Storage;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    // 飲食店予約機能テスト
    public function test_reserve()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $this->actingAs($user);
        $response = $this->post("/reservation/{$shop->id}", [
            'date' => '2031-01-01',
            'time' => '10:00:00',
            'number' => '10',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations',[
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'rsv_date' => '2031-01-01',
            'rsv_time' => '10:00:00',
            'rsv_guests' => '10',
        ]);
        $response->assertViewIs('done');
    }

    // 予約削除テスト
    public function test_cancel()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $reservation = Reservation::factory()->create(['user_id'=>$user->id, 'shop_id'=>$shop->id]);
        $this->actingAs($user)->delete("/cancel/{$reservation->id}");
        $this->assertDatabaseMissing('reservations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
    }

    // 予約変更ページ表示テスト
    public function test_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $shop = Shop::factory()->create();
        $reservation = Reservation::factory()->create(['shop_id'=>$shop->id]);
        $response = $this->get("/edit/{$reservation->id}");
        $response->assertStatus(200);
        $response->assertViewIs('edit');
    }

    // 予約変更処理テスト
    public function test_update()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);
        $newReservation = [
            'date' => '2030-05-20',
            'time' => '14:00:00',
            'number' => '2',
        ];
        $response = $this->actingAs($user)->put("/update/{$reservation->id}", $newReservation);
        $this->assertDatabaseHas('reservations', [
            'rsv_date' => '2030-05-20',
            'rsv_time' => '14:00:00',
            'rsv_guests' => '2',
        ]);
        $response->assertStatus(200);
        $response->assertViewIs('my_page');
    }

    // 予約一覧ページ表示テスト
    public function test_bookingConfirm()
    {
        $manager = Manager::factory()->create();
        $reservation = Reservation::factory()->create();
        $response= $this->actingAs($manager,'managers')->get('/booking_confirmation');
        $response->assertStatus(200);
        $response->assertViewIs('booking_confirmation');
    }

    // 予約詳細確認テスト
    public function test_bookingDetail()
    {
        $manager = Manager::factory()->create();
        $reservation = Reservation::factory()->create();
        $response= $this->actingAs($manager,'managers')->get("/booking_detail/{$reservation->id}");
        $response->assertStatus(200);
        $response->assertViewIs('booking_detail');
    }

    // QRコード表示テスト
    public function test_qr()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create();
        $response = $this->actingAs($user)->get("/qrcode/{$reservation->id}");
        $response->assertStatus(200);
        $response->assertViewIs('qr_code');
    }
}
