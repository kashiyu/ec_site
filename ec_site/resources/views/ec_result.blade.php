<!DOCTYPE html>
<htmL>
<head>
    <meta charset="utf-8">
    <title>購入完了ページ</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/ec.css')}}">
</head>
<body>
    <header>
        <div class="header-box">
            <a href="/ec/store">
                <img class="logo" src="/img/logo.png" alt="EC_logo">
            </a>
            <a class="cart" href="/ec/store/cart"></a>
            <a class="nemu" href="/ec/logout">ログアウト</a>
            @if($adm_flag === "1")
                <a class="nemu" href="/ec/tool">管理ページ</a>
            @endif
            <p class="nemu">ユーザー名：{{$user_name}}</p>
        </div>
    </header>
    
    <div class="content">
        @if (session('success_message'))
                <p class="success_message">
                    {{ session('success_message') }}
                </p>
        @endif
        <div class="finish-msg">ご購入ありがとうございました。</div>
        
            <div class="cart-list-title">
                <span class="cart-list-price">価格</span>
                <span class="cart-list-num">数量</span>
            </div>
            
            <ul class="cart-list">
                @foreach($carts as $value)
                <li>
                    <div class="cart-item">
                
                        <img class="item_img" src="/img/{{$value->img}}">
                        <span class="cart-item-name">{{$value->name}}</span>
                        <span class="cart-item-price">{{$value->price}}円</span>
                        <span class="finish-item-price">{{$value->amount}}</span>
        
                    </div>
                </li>
                @endforeach
            </ul>
            
            <div class="buy-sum-box">
                <span class="buy-sum-title">合計</span>
                <span class="buy-sum-price">¥ {{$total_fee}}</span>
            </div>
        </div>
    </div>
</body>
</html>
