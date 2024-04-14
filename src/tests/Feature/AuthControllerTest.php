<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Manager;
use App\Models\Admin;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    // 新規会員登録ページ表示テスト
    public function test_userRegister()
    {
        $response = $this->get('/register/user');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    // ユーザー新規登録処理テスト
    public function test_postUserRegister()
    {
        $userData = [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
        ];
        $response = $this->post('/register/user', $userData);
        $response->assertRedirect('/thanks');
        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@example.com',
        ]);
    }

    // ユーザーログインページ表示テスト
    public function test_userLogin()
    {
        $response = $this->get('/login/user');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    // ユーザーログイン処理テスト(未２FA時、二要素認証メール送信画面へリダイレクト)
    public function test_postUserLogin_not_2fa()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => null,
        ]);
        $response = $this->post('/login/user', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/email/verify');
    }

    // ユーザーログイン処理テスト(2FA済の時はトップページへリダイレクト)
    public function test_postUserLogin_2fa()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $response = $this->post('/login/user', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/');
    }

    // ユーザーログアウト処理テスト
    public function test_userLogout()
    {
        $user = User::factory()->create();
        $response=$this->actingAs($user,'web');
        $this->assertAuthenticated();
        $response = $this->post('/logout/user');
        $this->assertGuest();
    }

    // 店舗代表者新規登録ページ表示テスト(要管理者権限)
    public function test_managerRegister()
    {
        $admin = Admin::factory()->create();
        $response= $this->actingAs($admin,'admins');
        $this->assertAuthenticated('admins');
        $response = $this->get('/register/manager');
        $response->assertStatus(200);
    }

    // 店舗代表者新規登録処理テスト(要管理者権限)
    public function test_postManagerRegister()
    {
        $admin = Admin::factory()->create();
        $response=$this->actingAs($admin,'admins');
        Manager::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' =>'password',
        ]);
        $this->assertDatabaseHas('managers',[
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);
    }

    // 店舗代表者ログインページ表示テスト
    public function test_managerLogin()
    {
        $response = $this->get('/login/manager');
        $response->assertStatus(200);
        $response->assertViewIs('auth.manager_login');
    }

    // 店舗代表者ログイン処理テスト
    public function test_postManagerLogin()
    {
        Manager::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login/manager', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/menu/manager');
    }

    // 店舗代表者ログアウトテスト
    public function test_managerLogout()
    {
        $manager = Manager::factory()->create();
        $response=$this->actingAs($manager,'managers');
        $this->assertAuthenticated('managers');
        $response = $this->post('/logout/manager');
        $this->assertGuest('managers');
    }

    // 管理者新規登録ページ表示テスト
    public function test_adminRegister()
    {
        $response = $this->get('/register/admin');
        $response->assertStatus(200);
        $response->assertViewIs('auth.admin_register');
    }

    // 管理者新規登録処理テスト
    public function test_postAdminRegister()
    {
        Admin::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' =>'password',
        ]);
        $this->assertDatabaseHas('admins',[
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);
    }

    // 管理者ログインページ表示テスト
    public function test_adminLogin()
    {
        $response = $this->get('/login/admin');
        $response->assertStatus(200);
        $response->assertViewIs('auth.admin_login');
    }

    // 管理者ログイン処理テスト
    public function test_postAdminLogin()
    {
        Admin::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login/admin', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/menu/admin');
    }

    // 管理者ログアウト処理テスト
    public function test_adminLogout()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin,'admins');
        $this->assertAuthenticated('admins');
        $response = $this->post('/logout/admin');
        $this->assertGuest('admins');
    }
}
