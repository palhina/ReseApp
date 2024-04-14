@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('content')
    <div class="container">
        @if (session('flash_alert'))
            <div class="flash_message">{{ session('flash_alert') }}</div>
        @elseif(session('status'))
            <div class="flash_message">
                {{ session('status') }}
            </div>
        @endif
        <div class="p-5">
            <div class="card-wrapper">
                <div class="card-header">Stripe決済</div>
                <div class="card-body">
                    <form id="card-form" action="{{ route('payment.store') }}" method="POST">
                        @csrf
                        <div class="card-information">
                            <label for="card_number">カード番号</label>
                            <div id="card-number" class="form-control"></div>
                        </div>
                        <div class="card-information">
                            <label for="card_expiry">有効期限</label>
                            <div id="card-expiry" class="form-control"></div>
                        </div>
                        <div class="card-information">
                            <label for="card-cvc">セキュリティコード</label>
                            <div id="card-cvc" class="form-control"></div>
                        </div>
                        <div id="card-errors" class="flash_message"></div>
                        <button class="form__button-payment">支払い</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection