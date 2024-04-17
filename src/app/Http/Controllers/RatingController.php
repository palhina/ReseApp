<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Rating;
use App\Models\Favorite;
use App\Http\Requests\RatingRequest;
use Illuminate\Support\Facades\Storage;

class RatingController extends Controller
{
    // 評価ページ表示
    public function rate($id)
    {
        $user = Auth::user();
        $shop = Shop::find($id);
        $shop->isFavorite = Favorite::isFavorite($shop->id, $user->id)->exists();
        return view('rating',compact('shop','user'));
    }

    // 評価機能送信
    public function review(RatingRequest $request,$id)
    {
        $user = Auth::user();
        $shop = Shop::find($id);
        $img = null;
        if ($request->hasFile('rating_img'))
        {
            $filename=$request->rating_img->getClientOriginalName();
            $img = Storage::disk('s3')->putFileAs('image', $request->file('rating_img'), $filename, 'public');
        }
        Rating::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'rating_img' => $img,
        ]);
        return view('thanks_rate');
    }

    // 口コミ編集ページ表示
    public function editRating($id)
    {
        $rating = Rating::find($id);
        $shopId = $rating->shop_id;
        $shop = Shop::find($shopId);
        return view('edit_rating',compact('rating','shop'));
    }

    // 口コミ編集処理
    public function updateRating(RatingRequest $request,$id)
    {
        $rating = Rating::find($id);
        $shopId = $rating->shop_id;
        $shop = Shop::find($shopId);
        $form = $request->all();
        $rating->update($form);
        return redirect()->route('shop.detail',['id' => $shop->id])->with('result', '口コミを編集しました');
    }

    // 口コミ削除
    public function deleteRating($id)
    {
        $rating = Rating::find($id);
        $shopId = $rating->shop_id;
        $rating->delete();
        $shop = Shop::find($shopId);
        return redirect()->route('shop.detail',['id' => $shop->id])->with('result', '口コミを削除しました');
    }

    // 店舗内全ての口コミを表示(ユーザー)
    public function ratingAll($id)
    {
        $shop = Shop::find($id);
        $ratings = Rating::where('shop_id',$shop->id)->get();
        return view('rating_all',compact('shop','ratings'));
    }

    // 全ての口コミを表示（管理者）
    public function managementRating()
    {
        $shops = Shop::all();
        $ratings = collect();
        foreach ($shops as $shop) {
            $shopRatings = Rating::where('shop_id', $shop->id)->get();
            $ratings = $ratings->merge($shopRatings);
        }
        return view('rating_management',compact('shops','ratings'));
    }

    // 口コミ削除(管理者)
    public function managementDeleteRating($id)
    {
        Rating::find($id)->delete();    
        return redirect("/management/rate")->with('result', '口コミを削除しました');
    }
}
