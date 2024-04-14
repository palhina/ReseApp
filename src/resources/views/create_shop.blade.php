@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create_shop.css') }}">
@endsection

@section('content')
    <div class="shop-create__wrapper">
        <div class="shop__contents--ttl">
            <h2>新しく店舗情報を作成</h2>
        </div>
        <form class="form" action="/create_shop/{$manager->id}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="shop__form--content">
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
                </form>
                <div class="form__group">
                    <p class="form__shop-photo--ttl">店舗画像を入力</p>
                    <label class="shop__img">
                        <input class="form__img"  type="file" name="shop_photo" accept="image/jpeg, image/svg">
                    </label>
                    <div class="form__error">
                        @if ($errors->has('shop_photo'))
                            {{$errors->first('shop_photo')}}
                        @endif
                    </div>
                </div>
                <div class="form__button">
                    <button class="rsv__create--btn">店舗情報新規作成</button>
                </div>
            </div>
        </form>
    </div>
@endsection
