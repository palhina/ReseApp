@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div class="shop-detail__wrapper">
        <div class="shop__contents">
            <div class="shop__contents-ttl">
                <a class="back" href="/">&lt;</a>
                <h2>{{ $reservation->shop->shop_name }}</h2>
            </div>
            <div class="shop__contents-img">
                @if (strpos($reservation->shop->shop_photo, '/images/') === 0)
                    <img class="shop__img" src="{{ $reservation->shop->shop_photo }}">
                @elseif(Str::startsWith($shop->shop_photo, 'http'))
                    <img class="shop__img" src="{{ $shop->shop_photo}}">
                @elseif ($reservation->shop->shop_photo)
                    <img class="shop__img" src="{{ Storage::disk('s3')->url($reservation->shop->shop_photo) }}">
                @endif
            </div>
            <div class="shop__contents-tag">
                <p>#{{ $reservation->shop->area->shop_area }}</p>
                <p>#{{ $reservation->shop->genre->shop_genre }}</p>
            </div>
            <div class="shop__contents-desc">
                <p>{{ $reservation->shop->shop_comment }}</p>
            </div>
        </div>
        <div class="shop__rsv">
            <h3 class="rsv__ttl">予約変更</h3>
            <form action="/update/{{$reservation->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form__group">
                    <input class="rsv-date" type="date" name="date" id="dateInput">
                </div>
                <div class="form__error">
                    @if ($errors->has('date'))
                        {{$errors->first('date')}}
                    @endif
                </div>
                <div class="form__group">
                    <select class="rsv-time" name="time" id="timeInput">
                        <option value="" selected="selected">予約時間を選択</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                    </select>
                </div>
                <div class="form__error">
                    @if ($errors->has('time'))
                        {{$errors->first('time')}}
                    @endif
                </div>
                <div class="form__group">
                    <select class="rsv-number" name="number" id="numberInput">
                        <option value="" selected="selected">予約人数を選択</option>
                        <option value="1">1人</option>
                        <option value="2">2人</option>
                        <option value="3">3人</option>
                        <option value="4">4人</option>
                        <option value="5">5人</option>
                        <option value="6">6人</option>
                        <option value="7">7人</option>
                        <option value="8">8人</option>
                        <option value="9">9人</option>
                        <option value="10">10人</option>
                    </select>
                </div>
                <div class="form__error">
                    @if ($errors->has('number'))
                        {{$errors->first('number')}}
                    @endif
                </div>
                <div class="rsv-confirm">
                    <table>
                        <tr>
                            <th class="rsv__contents">Shop</th>
                            <td>{{ $reservation->shop->shop_name }}</td>
                        </tr>
                        <tr>
                            <th class="rsv__contents">Date</th>
                            <td id="displayDate"></td>
                        </tr>
                            <tr>
                            <th class="rsv__contents">Time</th>
                            <td id="displayTime"></td>
                        </tr>
                        <tr>
                            <th class="rsv__contents">Number</th>
                            <td id="displayNumber"></td>
                        </tr>
                    </table>
                </div>
                <div class="form__button">
                    <button class="rsv__edit--btn">予約変更</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/reservation.js') }}"></script>
@endsection