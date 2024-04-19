@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fav.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('content')
    <h2 class="my-page__ttl">{{ $user->name }}さん</h2>
    <div class="my-page__wrapper">
        <div class="my-page__rsv">
            <div class="my-page__rsv-ttl">
                <h3>予約状況</h3>
            </div>
            <div class="my-page_rsv">
                @foreach($reservations as $key => $reservation)
                <div class="my-page__rsv-detail">
                    <form class="rsv__delete" method="post" action="/cancel/{{ $reservation->id }}">
                    @method('DELETE')
                    @csrf
                        <div class="form__icon">
                            <i class="material-icons">schedule</i>
                            <p class="rsv__ttl">予約{{$key + 1}}</p>
                        </div>
                        <button class="rsv__delete--btn" type="submit">×</button>
                        <table>
                            <tr>
                                <th>Shop</th>
                                <td>{{ $reservation->shop->shop_name}}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{$reservation->rsv_date}}</td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td>{{$reservation->rsv_time}}</td>
                            </tr>
                            <tr>
                                <th>Number</th>
                                <td>{{$reservation->rsv_guests}}</td>
                            </tr>
                        </table>
                    </form>
                    <div class="rsv__btn">
                        <form class="form" action="/edit/{{$reservation->id}}" method="get">
                        @csrf
                            <button class="rsv__edit--btn">予約変更</button>
                        </form>
                        <form class="form" action="/qrcode/{{$reservation->id}}" method="get">
                        @csrf
                            <button class="rsv__edit--btn">QRコード表示</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="shop__fav">
            <h3>お気に入り店舗</h3>
            <div class="my-page__fav">
                @foreach($favorites as $favorite)
                <div class="my-page__fav-card">
                    <div class="my-page__fav-img">
                        @if (strpos($favorite->shop->shop_photo, '/images/') === 0)
                            <img class="card__img" src="{{ $favorite->shop->shop_photo }}">
                        @elseif ($favorite->shop->shop_photo)
                            <img class="card__img" src="{{ Storage::disk('s3')->url($favorite->shop->shop_photo) }}">
                        @endif
                    </div>
                    <div class="my-page__fav-desc">
                        <div class="my-page__fav-name">
                            <p class="fav-name">{{$favorite->shop->shop_name}}</p>
                        </div>
                        <div class="my-page__fav-tag">
                            <p class="fav-tag">#{{$favorite->shop->area->shop_area}}</p>
                            <p class="fav-tag">#{{$favorite->shop->genre->shop_genre}}</p>
                        </div>
                        <div class="my-page__shop-detail">
                            <form class="form" action="/detail/{{$favorite->shop->id}}" method="get">
                            @csrf
                                <button class="to-shop-detail">詳しく見る</button>
                            </form>
                        </div>
                        <form class="fav__delete" method="post" action="/fav_delete_mypage/{{ $favorite->id }}">
                        @method('DELETE')
                        @csrf
                        <button class="fav-btn__favorite" type="submit"></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection