@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="done__content">
        <div class="done__group-title">
            <h2 class="done__message">ご予約ありがとうございます</h2>
        </div>
        <div class="form__button">
            <a class="back-link" href="/">戻る</a>
        </div>
    </div>
@endsection