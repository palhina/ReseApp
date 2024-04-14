@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
@endsection

@section('content')
    <div class="shop-detail__wrapper">
        <div class="shop__contents">
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
        <div class="shop__rate">
            <div class="shop__rate-txt">
                <h3>{{ $user->name}}様</h3>
                <p>{{ $shop->shop_name }}にご来店ありがとうございました。</p>
                <p>よろしければ、お店の評価をお願いします</p>
            </div>
            <form class="shop__rate-form" action="/rate/{{$shop->id}}" method="post">
            @csrf
                <div class="form-group">
                    <h4>評価</h4>
                    <div class="form__fiveStar">
                        <input class="star-input" id="star1" type="radio"  name="rating" value="5">
                        <label for="star1" class="star">★</label>
                        <input class="star-input" id="star2" type="radio" name="rating" value="4">
                        <label for="star2" class="star">★</label>
                        <input class="star-input" id="star3" type="radio" name="rating" value="3">
                        <label for="star3" class="star">★</label>
                        <input class="star-input" id="star4" type="radio" name="rating" value="2">
                        <label for="star4" class="star">★</label>
                        <input class="star-input" id="star5" type="radio" name="rating" value="1">
                        <label for="star5" class="star">★</label>
                    </div>
                    <div class="form__error">
                        @if ($errors->has('rating'))
                            {{$errors->first('rating')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <h4>コメント(任意)</h4>
                    <textarea class="form__rate-comment" col="50" name="comment"></textarea>
                    <div class="form__error">
                        @if ($errors->has('comment'))
                            {{$errors->first('comment')}}
                        @endif
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-rate" type="submit">評価を送信</button>
                </div>
            </form>
        </div>
    </div>
@endsection