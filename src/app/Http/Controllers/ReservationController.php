<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\Favorite;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    // 飲食店予約
    public function reserve(ReservationRequest $request,$id)
    {
        $user = Auth::user();
        $shop = Shop::find($id);
        Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'rsv_date' => $request->input('date'),
            'rsv_time' => $request->input('time'),
            'rsv_guests' => $request->input('number'),
        ]);
        return view('done');
    }

    // 予約削除
    public function cancel($id)
    {
        $reservation = Reservation::find($id)->delete();
        $user = Auth::user();
        $reservations = Reservation::where('user_id',$user->id)
        ->orderBy('rsv_date', 'asc')
        ->orderBy('rsv_time', 'asc')
        ->get();
        $favorites = Favorite::where('user_id',$user->id)
        ->get();
        return view('my_page',compact('user','reservations','favorites'));
    }

    // 予約変更ページ表示
    public function edit($id)
    {
        $reservation = Reservation::with('shop')->find($id);
        return view('edit',compact('reservation'));
    }

    // 予約変更処理
    public function update(ReservationRequest $request, $id)
    {
        $user = Auth::user();
        $reservation = Reservation::find($id);
        $reservation->rsv_date = $request->input('date');
        $reservation->rsv_time = $request->input('time');
        $reservation->rsv_guests = $request->input('number');
        $reservation->save();
        $reservation = Reservation::where('id', $id)
        ->where('user_id', $user->id)
        ->first();

        $reservations = Reservation::where('user_id',$user->id)
        ->orderBy('rsv_date', 'asc')
        ->orderBy('rsv_time', 'asc')
        ->get();
        $favorites = Favorite::where('user_id',$user->id)
        ->get();
        return view('my_page',compact('user','reservations','favorites'));
    }

    // 予約一覧（店舗代表者）
    public function bookingConfirm()
    {
        $manager = Auth::guard('managers')->user();
        $shops = Shop::where('manager_id',$manager->id)->get();
        $reservations = collect();
        foreach ($shops as $shop) {
            $shopReservations = Reservation::where('shop_id', $shop->id)
                ->orderBy('rsv_date', 'asc')
                ->orderBy('rsv_time', 'asc')
                ->get();
            $reservations = $reservations->merge($shopReservations);
        }
        return view('booking_confirmation',compact('shops','reservations'));
    }

    // 予約詳細確認（店舗代表者）
    public function bookingDetail($id)
    {
        $reservation = Reservation::find($id);
        return view('booking_detail',compact('reservation'));
    }

    // QRコード表示
    public function qr($id)
    {
        $reservation = Reservation::with('shop')->find($id);
        return view('qr_code',compact('reservation'));
    }
}
