<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;


class FavoriteController extends Controller
{
    // お気に入り追加機能(店舗一覧ページから)
    public function favorite(Request $request,$id)
    {
        $user = Auth::user();
        $shop = Shop::find($id);
        $shops = Shop::all();
        $areas = Area::all();
        $genres = Genre::all();
        Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
        $userId = Auth::user()->id;
        $favorites =  Favorite::where('user_id',$userId)->get();
        $shops->each(function ($shop) use ($userId) {
            $shop->isFavorite = Favorite::isFavorite($shop->id, $userId)->exists();
        });
        return view('shop_all', compact('shops','favorites','areas','genres'));
    }

    // お気に入り削除機能(店舗一覧ページから)
    public function deleteShopAll($id)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $favorite = Favorite::find($id)->delete();
        $user = Auth::user();
        $shop = Shop::find($id);
        $shops = Shop::all();
        $userId = Auth::user()->id;
        $favorites = Favorite::where('user_id',$user->id)
        ->get();
        $shops->each(function ($shop) use ($userId) {
            $shop->isFavorite = Favorite::isFavorite($shop->id, $userId)->exists();
        });
        return view('shop_all',compact('user','favorites','shops','areas','genres'));
    }

    // お気に入り削除機能(マイページから)
    public function deleteMyPage($id)
    {
        $favorite = Favorite::find($id)->delete();
        $user = Auth::user();
        $favorites = Favorite::where('user_id',$user->id)
        ->get();
        $reservations = Reservation::where('user_id',$user->id)
        ->orderBy('rsv_date', 'asc')
        ->orderBy('rsv_time', 'asc')
        ->get();
        return view('my_page',compact('user','favorites','reservations'));
    }

    // お気に入り追加機能(口コミ追加・編集ページから)
    public function addFavorite(Request $request,$id)
    {
        $shop = Shop::find($id);
        $user = Auth::user();
        Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
        $shop->isFavorite = Favorite::isFavorite($shop->id, $user->id)->exists();

        return redirect()->route('shop.detail',['id' => $shop->id])->with('result', 'お気に入りに追加しました');
    }

    // お気に入り削除機能(口コミ追加・編集ページから)
    public function deleteFavorite($id)
    {
        $shop = Shop::find($id);
        $user = Auth::user();
        $favorite = Favorite::where('shop_id', $id)
            ->where('user_id', $user->id)
            ->delete();
        $shop->isFavorite = Favorite::isFavorite($shop->id, $user->id)->exists();

        return redirect()->route('shop.detail',['id' => $shop->id])->with('result','お気に入りから削除しました');
    }
}
