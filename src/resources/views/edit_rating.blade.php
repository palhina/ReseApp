@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
@endsection

@section('content')
    <div class="shop-detail__wrapper">
        <div class="shop__contents">
            <p class="contents__ttl">口コミを編集</p>
            <div class="shop__contents--card">
                <div class="shop__contents-img">
                    @if (strpos($shop->shop_photo, '/images/') === 0)
                        <img class="shop__img" src="{{ $shop->shop_photo }}">
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
                    <!-- お気に入りハート実装 -->
                    </div>
                </div>
            </div>
        </div>
        <div class="shop__rate">
            <form class="shop__rate-form" action="/rate/edit/{{$rating->id}}" method="post" enctype="multipart/form-data" id="rate">
            @csrf
            @method('PUT')
                <div class="form-group">
                    <p class="form__rating">体験を評価してください</p>
                    <div class="form__fiveStar">
                        @for ($i = 5; $i >= 1; $i--)
                            <input class="star-input" id="star{{$i}}" type="radio" name="rating" value="{{$i}}" form="rate" {{ $i == $rating->rating ? 'checked' : '' }}>
                            <label for="star{{$i}}" class="star">★</label>
                        @endfor
                    </div>
                    <div class="form__error">
                        @if ($errors->has('rating'))
                            {{$errors->first('rating')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <p class="form__rating">口コミを投稿</p>
                    <textarea class="form__rate-comment" col="50" name="comment" placeholder="カジュアルな夜のお出かけにお勧めのスポット" form="rate" oninput="updateCharacterCount(this)">{{$rating->comment}}</textarea>
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
                        <input class="img__upload-btn" type="file" name="rating_img" accept=".jpg, .jpeg, .png" form="rate"  onchange="displayFileName(this)">
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
    <form class="shop__rate-form" action="/rate/{{$rating->id}}" method="post" enctype="multipart/form-data" id="rate">
    @csrf
    @method('PUT')
        <div class="form__button">
            <button class="form__button-rate" type="submit" form="rate">口コミを投稿</button>
        </div>
    </form>

    <script src="{{ asset('js/commentcount.js') }}"></script>
    <script src="{{ asset('js/inputfile.js') }}"></script>
@endsection