@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop_all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fav.css') }}">
@endsection

@section('content')
    <div class="shop-all">
        <div class="shop-all__wrapper">
            <form class="search-bar" action="/search" method="post">
            @csrf
                <select class="sort" name="sort">
                    <option value="">並び替え：評価高/低</option>
                    <option value="random">ランダム</option>
                    <option value="ratingDesc">評価が高い順</option>
                    <option value="ratingAsc">評価が低い順</option>
                </select>

                <div class="search-form">
                    <div class="search-form__area">
                        <select class="search__area" name="shop_area">
                            <option value="">All area</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->shop_area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-form__genre">
                        <select class="search__genre" name="shop_genre">
                            <option value="">All genre</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->shop_genre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-form__keyword">
                        <input class="search__key" type="text" name="keyword" placeholder="Search..." id="keyword">
                    </div>
                </div>
                <div class="search__btn-wrapper">
                    <button class="search__btn" type="submit">Search</button>
                </div>
            </form>
        </div>
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