<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\CsvController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('shop.detail');
Route::post('/search', [ShopController::class, 'search']);

// 二段階認証
Route::get('/email/verify',[EmailVerificationController::class,'notification'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}',[EmailVerificationController::class,'verification'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification',[EmailVerificationController::class,'sendNotification'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// 要ユーザー認証
Route::middleware(['auth','verified','web'])->group(function () {
    // 予約処理、取り消し、変更
    Route::post('/reservation/{id}', [ReservationController::class, 'reserve']);
    Route::delete('/cancel/{id}', [ReservationController::class, 'cancel']);
    Route::get('/edit/{id}', [ReservationController::class, 'edit']);
    Route::put('/update/{id}', [ReservationController::class, 'update']);
    // マイページ(表示、お気に入り)
    Route::get('/my_page', [HomeController::class, 'myPage']);
    Route::post('/favorite/{id}', [FavoriteController::class, 'favorite']);
    Route::delete('/fav_delete_shop/{id}', [FavoriteController::class, 'deleteShopAll']);
    Route::delete('/fav_delete_mypage/{id}', [FavoriteController::class, 'deleteMyPage']);
    Route::post('/favorite_add/{id}', [FavoriteController::class, 'addFavorite']);
    Route::delete('/favorite_delete/{id}', [FavoriteController::class, 'deleteFavorite']);

    // 口コミ機能
    Route::prefix('/rate')->group(function () {
        Route::get('/{id}', [RatingController::class, 'rate']);
        Route::post('/{id}', [RatingController::class, 'review']);
        Route::get('/all/{id}', [RatingController::class, 'ratingAll']);
        Route::get('/edit/{id}', [RatingController::class, 'editRating']);
        Route::put('/edit/{id}', [RatingController::class, 'updateRating']);
        Route::delete('/delete/{id}', [RatingController::class, 'deleteRating']);
    });
    // 決済
    Route::prefix('/payment')->name('payment.')->group(function () {
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
    });
    // QRコード表示
    Route::get('/qrcode/{id}', [ReservationController::class, 'qr']);
});

// ユーザー作成、ログイン機能・サンクスページ
Route::get('/register/user', [AuthController::class,'userRegister']);
Route::post('/register/user', [AuthController::class,'postUserRegister']);
Route::get('/login/user', [AuthController::class,'userLogin'])->name('login');
Route::post('/login/user', [AuthController::class,'postUserLogin']);
Route::post('/logout/user', [AuthController::class,'userLogout']);
Route::get('/thanks', [HomeController::class, 'thanks']);

// 店舗代表者ログイン機能
Route::get('/login/manager', [AuthController::class, 'managerLogin'])->name('login.manager');
Route::post('/login/manager', [AuthController::class, 'postManagerLogin']);

// 要店舗代表者認証
Route::middleware('auth.managers:managers')->group(function (){
    Route::post('/logout/manager', [AuthController::class,'managerLogout']);
    Route::get('/menu/manager', [HomeController::class, 'managerMenu']);
    // 店舗表示、新規作成、編集
    Route::get('/create_shop', [ShopController::class, 'newShop']);
    Route::post('/create_shop/{id}', [ShopController::class, 'createShop']);
    Route::get('/check_shop', [ShopController::class, 'checkShop']);
    Route::get('/update_shop/{id}', [ShopController::class, 'editShop']);
    Route::put('/update_shop/{id}', [ShopController::class, 'updateShop']);
    // 予約確認
    Route::get('/booking_confirmation', [ReservationController::class, 'bookingConfirm']);
    Route::get('/booking_detail/{id}', [ReservationController::class, 'bookingDetail']);
});

// 管理者作成・ログイン機能
Route::get('/register/admin', [AuthController::class, 'adminRegister']);
Route::post('/register/admin', [AuthController::class, 'postAdminRegister']);
Route::get('/login/admin', [AuthController::class, 'adminLogin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'postAdminLogin']);

// 要管理者認証
Route::middleware('auth.admins:admins')->group(function (){
    Route::get('/menu/admin', [HomeController::class, 'adminMenu']);
    Route::post('/logout/admin', [AuthController::class,'adminLogout']);
    //店舗代表者作成
    Route::get('/register/manager', [AuthController::class, 'managerRegister']);
    Route::post('/register/manager', [AuthController::class, 'postManagerRegister']);
    // お知らせメール送信
    Route::get('/send_email', [MailController::class, 'email']);
    Route::post('/send_email', [MailController::class, 'sendEmail']);
    // 口コミ管理
    Route::get('/management/rate', [RatingController::class, 'managementRating']);
    Route::delete('/management/rate/{id}', [RatingController::class, 'managementDeleteRating']);
    // CSV登録（動作確認後ここへ）
    
});
Route::get('/csv_upload', [CsvController::class, 'csvUpload']);
    Route::post('/csv_upload', [CsvController::class, 'importCsv']);
    Route::post('/csv_export', [CsvController::class, 'downloadCsv']);
