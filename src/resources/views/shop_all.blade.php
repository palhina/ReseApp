@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop_all.css') }}">
@endsection

@section('content')
    @include('search')
    <div class="shop-all">
        @foreach ($shops as $shop)
        <div class="shop-all__card">
            <div class="shop-all__card-img">
                @if (strpos($shop->shop_photo, '/images/') === 0)
                    <img class="card__img" src="{{ $shop->shop_photo }}">
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
                    <form class="form" action="/detail/{{$shop->id}}" method="get">
                    @csrf
                        <button class="to-shop-detail">詳しく見る</button>
                    </form>
                </div>
                <div class="shop-all__fav-btn">
                    @if ($shop->isFavorite)
                        <form class="fav__delete" method="post" action="/fav_delete_shop/{{ $favorites->firstWhere('shop_id', $shop->id)->id }}">
                            @method('DELETE')
                            @csrf
                            <button class="fav-btn__favorite" type="submit"></button>
                        </form>
                    @else
                        <form  class="fav__add" method="post" action="/favorite/{{ $shop->id }}">
                            @csrf
                            <button class="fav-button__not" type="submit"></button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection