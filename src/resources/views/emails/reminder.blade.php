<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ご予約のご案内</title>
</head>
<body>
    <h1>Reservation Reminder</h1>
    <p>こんにちは、 {{ $reservation->user->name }}様</p>
    <p>本日のご予約のご案内です。</p>
    <ul>
        <li>店舗名：{{ $reservation->shop->shop_name }} </li>
        <li>予約日：{{ $reservation->rsv_date }} </li>
        <li> 予約時間：{{ $reservation->rsv_time }}</li>
        <li>予約人数：{{ $reservation->rsv_guests }}名様</li>
    </ul>
    <p>ご来店お待ちしております。</p>
    
</body>
</html>