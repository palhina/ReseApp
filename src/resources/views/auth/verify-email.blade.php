@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class='twoFA__wrapper'>
    @if(session('message'))
        <div class="flash_message">
            {{ session('message') }}
        </div>
    @endif

    <div class='twoFA__content'>
        <h2 class='twoFA__ttl'>確認メールの送信</h2>
        <p class='twoFA__txt'>登録したアドレスにメールを送信しました。</p>
        <p class='twoFA__txt'>ログインを進めるには、メールの案内に従って二段階認証を行ってください。</p>
        <p><a class='twoFA__btn--back' href="/">TOPに戻る</a></p>
        <form action="{{route('verification.send')}}" method="POST">
            @csrf
            <button class='twoFA__btn--submit' type="submit">メール再送信</button>
        </form>
    </div>
</div>
@endsection