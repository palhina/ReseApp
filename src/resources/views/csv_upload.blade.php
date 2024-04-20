@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/csv_upload.css') }}">
@endsection

@section('content')
    @if (session('result'))
        <div class="flash_message">
            {{ session('result') }}
        </div>
    @endif

    <div class="csv__contents">
        <div  class="csvimport__contents">
            <p>CSVファイルによる店舗情報の追加</p>
            <form class="csv__import" method="post" action="/csv_upload" enctype="multipart/form-data">
                @csrf
                <label class="csv__ttl" name="csvFile">csvファイル：</label>
                <input type="file" name="csv_file"/>
                <button class="csvimport__btn">読み込み</button>
            </form>
        </div>
        <div class="form__error">
            @if (count($errors)>0)
            <ul class="error__message">
                @foreach($errors->all() as $error)
                <li class="error__list">{{$error}}</li>
                @endforeach
            </ul>
            @endif
        </div>
        <div class ="csv__information">
            <p class="csv__information--ttl">csvファイル記入上の注意</p>
            <dl class="csv__information--txt">
                <dt>1行目:ヘッダー</dt>
                <dd>『地域,ジャンル,店舗名,画像URL,店舗概要』と記入</dd>
                <dd>（項目は必ずこの順序で）</dd>
                <dt>2行目以降:店舗情報</dt>
                <dd>ヘッダーの項目の順に「,」で区切って入力</dd>
                <dt>画像URL</dt>
                <dd>http:// またはhttps:// で始まり.pngまたは.jpg（.jpeg）で終わるものを入力</dd>
            </dl>
        </div>
    </div>
@endsection