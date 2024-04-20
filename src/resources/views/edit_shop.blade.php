@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit_shop.css') }}">
@endsection

@section('content')
<div class="shop__create">
    <a class="shop-all__create-shop" href="/create_shop">+ 店舗の新規作成</a>
</div>
<div class="shop-all__wrapper">
    <p class="shop-all__ttl">作成した店舗一覧</p>
    <div class="shop-all">
        @foreach ($shops as $shop)
        <div class="shop-all__card">
            <div class="shop-all__card-img">
                @if (strpos($shop->shop_photo, '/images/') === 0)
                    <img class="card__img" src="{{ $shop->shop_photo }}">
                @elseif(Str::startsWith($shop->shop_photo, 'http'))
                    <img class="card__img" src="{{ $shop->shop_photo}}">
                @elseif ($shop->shop_photo)
                    <img class="card__img" src="{{ Storage::disk('s3')->url($shop->shop_photo) }}">
                @endif
            </div>
            <div class="shop-all__card-desc">
                <div class="shop-all__card-name">
                    <p class="card-name">{{ $shop->shop_name }}</p>
                </div>
                <div class="shop-all__card-tag">
                    <p class="card-tag">#{{ $shop->area->shop_area}}</p>
                    <p class="card-tag">#{{ $shop->genre->shop_genre }}</p>
                </div>
                <div class="shop-all__card-detail">
                    <form class="form" action="/update_shop/{{$shop->id}}" method="get">
                    @csrf
                        <button class="edit__shop">店舗情報更新</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection