@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/send_email.css') }}">
@endsection

@section('content')
    @if (session('result'))
        <div class="flash_message">
            {{ session('result') }}
        </div>
    @endif
    <div class="information-email__wrapper">
        <p class="information-email__detail">ユーザーにメールを送信</p>
        <form method="post" action="/send_email">
        @csrf
            <div class="information-email__content">
                <div class="information-email__ttl">
                    <input class="information-email__subject" type="text" name="subject" placeholder="タイトル">
                </div>
                <div class="information-email__text">
                    <textarea class="information-email__message" name="message" placeholder="メール本文"></textarea>
                </div>
                <div class="information-email__btn">
                    <button class="send-email__btn" type="submit">送信する</button>
                </div>
            </div>
        </form>
    </div>
@endsection