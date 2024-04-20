@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fav.css') }}">
@endsection

@section('content')
    <div class="shop-detail__wrapper">
        <div class="shop__contents">
            <p class="contents__ttl">今回のご利用はいかがでしたか？</p>
            <div class="shop__contents--card">
                <div class="shop__contents-img">
                    @if (strpos($shop->shop_photo, '/images/') === 0)
                        <img class="shop__img" src="{{ $shop->shop_photo }}">
                    @elseif(Str::startsWith($shop->shop_photo, 'http'))
                        <img class="shop__img" src="{{ $shop->shop_photo}}">
                    @elseif ($shop->shop_photo)
                        <img class="shop__img" src="{{ Storage::disk('s3')->url($shop->shop_photo) }}">
                    @endif
                </div>
                <div class="shop__contents--desc">
                    <p class="card-name">{{ $shop->shop_name }}</p>
                    <div class="card-tag">
                        <p>#{{ $shop->area->shop_area }}</p>
                        <p>#{{ $shop->genre->shop_genre }}</p>
                    </div>
                    <form class="form" action="/detail/{{$shop->id}}" method="get" id="detail">
                    @csrf
                        <button class="to-shop-detail" form="detail">詳しく見る</button>
                    </form>
                    <div class="shop-all__fav-btn">
                        @if ($shop->isFavorite)
                            <form class="fav__delete" method="post" action="/favorite_delete/{{ $shop->id }}">
                                @method('DELETE')
                                @csrf
                                <button class="fav-btn__favorite" type="submit"></button>
                            </form>
                        @else
                            <form  class="fav__add" method="post" action="/favorite_add/{{ $shop->id }}">
                                @csrf
                                <button class="fav-button__not" type="submit"></button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="shop__rate">
            <form class="shop__rate-form" action="/rate/{{$shop->id}}" method="post" enctype="multipart/form-data" id="rate">
            @csrf
                <div class="form-group">
                    <p class="form__rating">体験を評価してください</p>
                    <div class="form__fiveStar">
                        <input class="star-input" id="star1" type="radio"  name="rating" value="5" form="rate">
                        <label for="star1" class="star">★</label>
                        <input class="star-input" id="star2" type="radio" name="rating" value="4" form="rate">
                        <label for="star2" class="star">★</label>
                        <input class="star-input" id="star3" type="radio" name="rating" value="3" form="rate">
                        <label for="star3" class="star">★</label>
                        <input class="star-input" id="star4" type="radio" name="rating" value="2" form="rate">
                        <label for="star4" class="star">★</label>
                        <input class="star-input" id="star5" type="radio" name="rating" value="1" form="rate">
                        <label for="star5" class="star">★</label>
                    </div>
                    <div class="form__error">
                        @if ($errors->has('rating'))
                            {{$errors->first('rating')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <p class="form__rating">口コミを投稿</p>
                    <textarea class="form__rate-comment" maxlength="400" name="comment" placeholder="カジュアルな夜のお出かけにお勧めのスポット" form="rate" oninput="updateCharacterCount(this)"></textarea>
                    <p class="count">
                        <span id="length">0</span>/400（最高文字数）
                    </p>
                    <div class="form__error">
                        @if ($errors->has('comment'))
                            {{$errors->first('comment')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <p class="form__rating">画像の追加</p>
                    <label class="img__upload">
                        <p>クリックして画像を追加</p>
                        <p>またはドラッグアンドドロップ</p>
                        <input class="img__upload-btn" type="file" name="rating_img" accept=".jpg, .jpeg, .png" form="rate" onchange="displayFileName(this)">
                    </label>
                    <p id="file-name"></p>
                    <div class="form__error">
                        @if ($errors->has('rating_img'))
                            {{$errors->first('rating_img')}}
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form class="shop__rate-form" action="/rate/{{$shop->id}}" method="post" enctype="multipart/form-data" id="rate">
    @csrf
        <div class="form__button">
            <button class="form__button-rate" type="submit" form="rate">口コミを投稿</button>
        </div>
    </form>
@endsection
<script src="{{ asset('js/commentcount.js') }}"></script>
<script src="{{ asset('js/inputfile.js') }}"></script>