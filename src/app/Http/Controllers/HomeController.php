<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;

class HomeController extends Controller
{
    // 店舗一覧＋お気に入り（ハートマーク）表示
    public function index()
    {
        $areas = Area::all();
        $genres = Genre::all();
        $shops = Shop::all();
        $favorites = [];
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $favorites =  Favorite::where('user_id',$userId)->get();
            $shops->each(function ($shop) use ($userId) {
                $shop->isFavorite = Favorite::isFavorite($shop->id, $userId)->exists();
            });
        return view('shop_all', compact('shops','favorites','areas','genres'));
        }
        else{
            return view('shop_all', compact('shops','areas','genres'));
        }
    }

    // 店舗詳細情報表示
    public function detail($id)
    {
        $shop = Shop::find($id);
        return view('shop_detail',compact('shop'));
    }

    // サンクスページ
    public function thanks()
    {
        return view('thanks');
    }

    // マイページ表示
    public function myPage()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id',$user->id)
        ->orderBy('rsv_date', 'asc')
        ->orderBy('rsv_time', 'asc')
        ->get();
        $favorites =  Favorite::where('user_id',$user->id)->get();
        return view('my_page',compact('user','reservations','favorites'));
    }



    // 店舗代表者メニュー
    public function managerMenu()
    {
        return view('manager_menu');
    }

    // 管理者メニュー
    public function adminMenu()
    {
        return view('admin_menu');
    }
}
