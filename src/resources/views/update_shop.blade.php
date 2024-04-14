@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/update_shop.css') }}">
@endsection

@section('content')
    <div class="shop-detail__wrapper">
            <div class="shop__contents">
                <p class="shop__contents-info">現在の情報</p>
                <div class="shop__contents-ttl">
                    <a class="back" href="/check_shop">&lt;</a>
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
            <div class="shop__contents-update">
                <h3 class="shop-update__ttl">店舗情報変更</h3>
                <form action="/update_shop/{{$shop->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form__group">
                        <input class="form__shop-name" type="text" name="shop_name" placeholder="店名入力"></input>
                        <div class="form__error">
                            @if ($errors->has('shop_name'))
                                {{$errors->first('shop_name')}}
                            @endif
                        </div>
                    </div>
                    <div class="form__group">
                        <select class="form__shop-area" name="shop_area">
                            <option value="">地域を選択</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->shop_area }}</option>
                            @endforeach
                        </select>
                        <div class="form__error">
                            @if ($errors->has('shop_area'))
                                {{$errors->first('shop_area')}}
                            @endif
                        </div>
                    </div>
                    <div class="form__group">
                        <select class="form__shop-genre" name="shop_genre">
                            <option value="">ジャンルを選択</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->shop_genre }}</option>
                            @endforeach
                        </select>
                        <div class="form__error">
                            @if ($errors->has('shop_genre'))
                                {{$errors->first('shop_genre')}}
                            @endif
                        </div>
                    </div>
                    <div class="form__group">
                        <textarea class="form__shop-comment" col="50" name="shop_comment" placeholder="店舗概要を入力"></textarea>
                        <div class="form__error">
                            @if ($errors->has('shop_comment'))
                                {{$errors->first('shop_comment')}}
                            @endif
                        </div>
                    </div>
                    <div class="form__group">
                        <p class="form__shop-photo--ttl">店舗画像を選択</p>
                        <label class="shop-photo__img">
                            <input class="shop__img"  type="file" name="shop_photo" accept="image/jpeg, image/svg">
                        </label>
                        <div class="form__error">
                            @if ($errors->has('shop_photo'))
                                {{$errors->first('shop_photo')}}
                            @endif
                        </div>
                    </div>
                    <div class="form__button">
                        <button class="rsv__edit--btn">店舗情報更新</button>
                    </div>
                </form>
            </div>
        </div>
@endsection