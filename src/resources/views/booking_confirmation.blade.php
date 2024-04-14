@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/booking_confirmation.css') }}">
@endsection

@section('content')
    <div class="booking__wrapper">
        <h2 class="rsv__ttl">予約一覧</h2>
        <div class="booking__list">
            @foreach($shops as $shop)
            <div class="booking__content">
                <h3 class="rsv__name">店舗名:{{$shop->shop_name}}</h3>

                @php
                    $shopReservations = $reservations->where('shop_id', $shop->id);
                @endphp

                @if($shopReservations->isNotEmpty())
                    @foreach($shopReservations as $reservation)
                    <div class="booking__card">
                        <div class="booking__date">
                            <p class="rsv__detail">{{$reservation->rsv_date}}</p>
                            <p class="rsv__detail">{{$reservation->rsv_time}}</p>
                        </div>
                        <div class="rsv__btn">
                            <form class="form" action="/booking_detail/{{$reservation->id}}" method="get">
                            @csrf
                                <button class="rsv__edit--btn">予約詳細</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                @else
                <p>予約はありません</p>
                @endif
            </div>
        @endforeach
        </div>
    </div>
@endsection