<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body class="body">
    <header class="header">
        <input class="hamburger-menu" type="checkbox" id="overlay-input" />
        <label for="overlay-input" id="overlay-button"><span class="hamburger-btn"></span></label>
        <div id="overlay">
            <ul class="hamburger-menu__list-wrapper">
                @if (Auth::guard('web')->check())
                    <li class="hamburger-menu__list"><a class="menu__link" href="/">Home</a></li>
                    <li class="hamburger-menu__list">
                        <form class="form" action="/logout/user" method="post">
                        @csrf
                            <button class="header-nav__button">Logout</button>
                        </form>
                    </li>
                    <li class="hamburger-menu__list">
                        <form class="form" action="/my_page" method="get">
                        @csrf
                            <button class="header-nav__button">Mypage</button>
                        </form>
                    </li class="hamburger-menu__list">
                    <li class="hamburger-menu__list"><a class="menu__link" href="/payment/create">Payment</a></li>
                @elseif(Auth::guard('managers')->check())
                    <h2 class="hamburger-ttl">ようこそ、{{ Auth::guard('managers')->user()->name }}さん</h2>
                    <p>店舗代表者権限でログイン中</p>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/check_shop">店舗情報作成・更新</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/booking_confirmation">予約確認</a></li>
                    <li class="hamburger-menu__list">
                        <form class="form" action="/logout/manager" method="post">
                        @csrf
                            <button class="header-nav__button">Logout</button>
                        </form>
                    </li>
                @elseif(Auth::guard('admins')->check())
                    <h2 class="hamburger-ttl">ようこそ、{{ Auth::guard('admins')->user()->name }}さん</h2>
                    <p>管理者権限でログイン中</p>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/register/manager">店舗代表者新規作成</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/send_email">メール送信</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/management/rate">口コミ管理</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/csv_upload">CSVインポート</a></li>
                    <li class="hamburger-menu__list">
                        <form class="form" action="/logout/admin" method="post">
                        @csrf
                            <button class="header-nav__button">Logout</button>
                        </form>
                    </li>
                @else
                    <h2 class="hamburger-ttl">現在ログインしていません</h2>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/">Home</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/register/user">Registration</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/login/user">Login</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/login/manager">店舗代表の方</a></li>
                    <li class="hamburger-menu__list"><a class="menu__link" href="/login/admin">管理メニュー</a></li>
                @endif
            </ul>
        </div>
        <div class="header-ttl">
            <h1 class="ttl">Rese</h1>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>

</html>