@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manager_menu.css') }}">
@endsection

@section('content')
    @if (session('result'))
        <div class="flash_message">
            {{ session('result') }}
        </div>
    @endif
    <div class="menu__content">
        <h2>ようこそ、{{ Auth::guard('managers')->user()->name }}さん</h2>
        <ul class="menu__list--wrapper">
            <li class="menu__info"><a class="menu__list" href="/check_shop">店舗情報の新規作成・更新</a></li>
            <li class="menu__info"><a class="menu__list" href="/booking_confirmation">予約確認</a></li>
        </ul>
    </div>
@endsection

