@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/qr_code.css') }}">
@endsection

@section('content')
    <div class="qr__content">
        <h2 class="qr__ttl">QRコード</h2>
        <p>このQRコードをお店で提示してください</p>
        <div class="qr-code">
        {!! QrCode::size(200)->generate(url("/booking_detail/{$reservation->id}")) !!}
        </div>
    </div>
@endsection