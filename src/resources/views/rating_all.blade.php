@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">
@endsection

@section('content')
    <div class="shop-detail__wrapper">
        <div class="shop__contents">
            <div class="shop__contents-info">
                <div class="shop__contents-ttl">
                    <a class="back" href="/">&lt;</a>
                    <h2>{{ $shop->shop_name }}</h2>
                </div>
                <div class="shop__contents-img">
                    @if (strpos($shop->shop_photo, '/images/') === 0)
                        <img class="shop__img" src="{{ $shop->shop_photo }}">
                    @elseif ($shop->shop_photo)
                        <img class="shop__img" src="{{ Storage::disk('s3')->url($shop->shop_photo) }}">
                    @endif
                </div>
                <div class="shop__contents-tag">
                    <p>#{{ $shop->area->shop_area }}</p>
                    <p>#{{ $shop->genre->shop_genre }}</p>
                </div>
                <div class="shop__contents-desc">
                    <p>{{ $shop->shop_comment }}</p>
                </div>
            </div>
        </div>
        <div class="shop__rating-all">
            <h3 class="rating__ttl">全ての口コミ情報</h3>
            @foreach ($ratings as $rating)
            <div>
                <div>{{$rating->rating}}</div>
                <p>{{$rating->comment}}</p>
            </div>
            @endforeach
        </div>
    </div>

@endsection