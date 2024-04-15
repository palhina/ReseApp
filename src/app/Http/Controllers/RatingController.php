<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Rating;
use App\Http\Requests\RatingRequest;

class RatingController extends Controller
{
    // 評価ページ表示
    public function rate($id)
    {
        $user = Auth::user();
        $shop = Shop::find($id);
        return view('rating',compact('shop','user'));
    }

    // 評価機能送信
    public function review(RatingRequest $request,$id)
    {
        $user = Auth::user();
        $shop = Shop::find($id);
        Rating::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            // 画像処理追加
        ]);
        return view('thanks_rate');
    }

    // 口コミ編集ページ表示
    public function editRating()
    {

    }

    // 口コミ編集処理
    public function updateRating()
    {
        
        return view('rating',compact('shop','user'));
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

    // 全ての口コミを表示
    public function ratingAll($id)
    {
        $shop = Shop::find($id);
        $ratings = Rating::where('shop_id',$shop->id)->get();
        return view('rating_all',compact('shop','ratings'));
    }
}
