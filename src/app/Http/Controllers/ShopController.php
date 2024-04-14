<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Http\Requests\ShopRequest;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    // 検索機能
    public function search(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $shop_area = $request->input('shop_area');
        $shop_genre = $request->input('shop_genre');
        $keyword = $request->input('keyword');
        $query = Shop::query();

        if (!empty($shop_area)) {
            $query->where('area_id', $shop_area);
        }
        if (!empty($shop_genre)) {
            $query->where('genre_id', $shop_genre);
        }
        if (!empty($keyword)) {
            $query->where('shop_name', 'LIKE', '%' . $keyword . '%');
        }
        $results = $query->get();

        // 検索後お気に入り表示
        $favorites = [];
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $favorites =  Favorite::where('user_id',$userId)->get();
            $results->each(function ($shop) use ($userId) {
                $shop->isFavorite = Favorite::isFavorite($shop->id, $userId)->exists();
            });
        return view('results', compact('results','areas','genres','favorites'));
        }
        else{
            return view('results', compact('results','areas','genres'));
        }
    }

    // 店舗新規作成ページ表示
    public function newShop()
    {
        $areas = Area::all();
        $genres = Genre::all();
        return view('create_shop',compact('areas','genres'));
    }

    // 店舗新規作成処理
    public function createShop(ShopRequest $request,$id)
    {
        $manager = Auth::guard('managers')->user();
        $shops = Shop::where('manager_id',$manager->id)->get();
        $areas = Area::all();
        $genres = Genre::all();
        $filename=$request->shop_photo->getClientOriginalName();
        $img = Storage::disk('s3')->putFileAs('images', $request->file('shop_photo'), $filename, 'public');
        Shop::create([
            'area_id' => $request->input('shop_area'),
            'genre_id' => $request->input('shop_genre'),
            'manager_id' => $manager->id,
            'shop_name' => $request->input('shop_name'),
            'shop_comment' => $request->input('shop_comment'),
            'shop_photo' => $img,
        ]);
        $shops = Shop::where('manager_id',$manager->id)->get();
        return view('edit_shop',compact('shops','areas','genres'));
    }

    // 作成した店舗一覧表示
    public function checkShop()
    {
        $manager = Auth::guard('managers')->user();
        $shops = Shop::where('manager_id',$manager->id)->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('edit_shop', compact('shops','areas','genres'));
    }

    // 店舗更新情報入力画面
    public function editShop($id)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $shop = Shop::find($id);
        return view('update_shop',compact('shop','areas','genres'));
    }

    // 店舗情報更新
    public function updateShop(ShopRequest $request,$id)
    {
        $manager = Auth::guard('managers')->user();
        $shop = Shop::find($id);

        $filename=$request->shop_photo->getClientOriginalName();
        $img = Storage::disk('s3')->putFileAs('images', $request->file('shop_photo'), $filename, 'public');

        $shop->shop_name = $request->input('shop_name');
        $shop->area_id = $request->input('shop_area');
        $shop->genre_id = $request->input('shop_genre');
        $shop->shop_comment = $request->input('shop_comment');
        $shop->shop_photo = $img;
        $shop->save();

        $shops = Shop::where('manager_id',$manager->id)->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('edit_shop',compact('shops','areas','genres'));
    }

}
