@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/rating_management.css') }}">
@endsection

@section('content')
    <div class="ratings__wrapper">
        @if (session('result'))
            <div class="flash_message">
                {{ session('result') }}
            </div>
        @endif
        <h2 class="rating__ttl">口コミ一覧</h2>
        <div class="rating__list">
            @foreach($shops as $shop)
            
                @php
                    $shopRatings = $ratings->where('shop_id', $shop->id);
                @endphp

                @if($shopRatings->isNotEmpty())
                    <div class="rating__content">
                        <h3 class="shop__name">店舗名:{{$shop->shop_name}}</h3>
                        @foreach($shopRatings as $rating)
                        <div class="rating__card">
                            <p class="rating">{{$rating->rating}}</p>
                            <p class="rating__comment">{{$rating->comment}}</p>
                            <div class="rating__image">
                                @if (strpos($rating->rating_img, '/images/') === 0)
                                    <img class="rating__img" src="{{ $rating->rating_img }}">
                                @elseif ($rating->rating_img)
                                    <img class="rating__img" src="{{ Storage::disk('s3')->url($rating->rating_img) }}">
                                @endif
                            </div>
                            <form class="form" action="/management/rate/{{$rating->id}}" method="post">
                            @csrf
                            @method('DELETE')
                                <button class="rating__delete--btn">削除</button>
                            </form>
                        </div>    
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection