<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Manager;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;

    // 検索機能テスト
    public function test_search()
    {
        $area = Area::factory()->create();
        $genre = Genre::factory()->create();
        $shop = Shop::factory()->create([
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'shop_name' => 'Test Shop',
        ]);
        // キーワード検索
        $response = $this->post('/search', [
            'keyword' => 'Test Shop',
        ]);
        $response->assertStatus(200)->assertSee('Test Shop');
        // エリアとジャンルから検索
        $response = $this->post('/search', [
            'shop_area' => $area->id,
            'shop_genre' => $genre->id,
        ]);
        $response->assertStatus(200)->assertSee('Test Shop');
    }

    // 店舗新規作成ページ表示テスト
    public function test_newShop()
    {
        $manager = Manager::factory()->create();
        $response= $this->actingAs($manager,'managers')->get('/create_shop');
        $response->assertStatus(200);
        $response->assertViewIs('create_shop');
    }

    // 店舗新規作成処理
    public function test_createShop()
    {
        $manager = Manager::factory()->create();
        $area = Area::factory()->create();
        $genre = Genre::factory()->create();
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('test_image.jpg');
        $file->storeAs('','test_image.jpg',['disk'=>'s3']);
        $response= $this->actingAs($manager,'managers')->post("/create_shop/{$manager->id}",[
            'shop_area' => $area->id,
            'shop_genre' => $genre->id,
            'shop_name' => 'Test Shop',
            'shop_comment' => 'Test Comment',
            'shop_photo' => $file,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('shops',[
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'shop_name' => 'Test Shop',
            'shop_comment' => 'Test Comment',
            'shop_photo' =>  'images/' . 'test_image.jpg',
        ]);
        Storage::disk('s3')->assertExists('test_image.jpg');
        $this->withoutExceptionHandling();

    }

    // 作成した店舗一覧画面の表示テスト
    public function test_checkShop()
    {
        $manager = Manager::factory()->create();
        $shop = Shop::factory()->create(['manager_id' => $manager->id]);
        $response= $this->actingAs($manager,'managers')->get('/check_shop');
        $response->assertStatus(200);
        $response->assertViewIs('edit_shop');
    }

    // 店舗更新情報入力画面表示テスト
    public function test_editShop()
    {
        $manager = Manager::factory()->create();
        $shop = Shop::factory()->create(['manager_id' => $manager->id]);
        $response= $this->actingAs($manager,'managers')->get("update_shop/{$shop->id}");
        $response->assertStatus(200);
        $response->assertViewIs('update_shop');
    }

    // 店舗情報更新処理テスト
    public function test_updateShop()
    {
        $manager = Manager::factory()->create();
        $shop = Shop::factory()->create(['manager_id' => $manager->id]);
        $area = Area::factory()->create(['id'=>1]);
        $genre = Genre::factory()->create(['id'=>1]);
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('test_image.jpg');
        $file->storeAs('','test_image.jpg',['disk'=>'s3']);
        $newShop = [
            'shop_area' => '1',
            'shop_genre' => '1',
            'shop_name' => 'Test Shop',
            'shop_comment' => 'Test Comment',
            'shop_photo' => $file,
        ];
        $response= $this->actingAs($manager,'managers')->put("update_shop/{$shop->id}",$newShop);
        $response->assertStatus(200);
        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'area_id' => '1',
            'genre_id' => '1',
            'shop_name' => 'Test Shop',
            'shop_comment' => 'Test Comment',
            'shop_photo' =>  'images/' . 'test_image.jpg',
        ]);
        Storage::disk('s3')->assertExists('test_image.jpg');
        $this->withoutExceptionHandling();
    }
}
