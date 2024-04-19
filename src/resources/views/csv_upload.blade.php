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
            <p>ここではCSVファイルによる、店舗情報の追加ができます。</p>
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

        <div class="csvexport__contents">
            <p>csvファイルには、「地域、ジャンル、店舗名、画像URL、店舗概要」の順に、2行目以降から「,」で区切って入力してください。</p>
            <p>以下のリンクから、テンプレートのダウンロードが可能です。</p>
            <form class="csv-template__export" method="post" action="/csv_export">
                @csrf
                <button class="csvexport__btn">テンプレートのダウンロード</button>
            </form>
        </div>
    </div>
@endsection