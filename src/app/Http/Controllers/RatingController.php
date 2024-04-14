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
        ]);
        return view('thanks_rate');
    }
}
