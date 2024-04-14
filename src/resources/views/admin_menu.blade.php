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
        <h2>ようこそ、{{ Auth::guard('admins')->user()->name }}さん</h2>
        <ul class="menu__list--wrapper">
            <li class="menu__info"><a class="menu__list" href="/register/manager">店舗代表者新規作成</a></li>
            <li class="menu__info"><a class="menu__list" href="/send_email">メール送信</a></li>
        </ul>
    </div>
@endsection

