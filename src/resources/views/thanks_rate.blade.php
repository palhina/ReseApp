@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="done__content">
        <div class="done__group-title">
            <h2>評価が送信されました。</h2>
            <h2>ありがとうございました。</h2>
        </div>
        <div class="form__button">
            <a class="back-link" href="/">戻る</a>
        </div>
    </div>
@endsection