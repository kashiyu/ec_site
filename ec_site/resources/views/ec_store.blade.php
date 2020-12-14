<!DOCTYPE html>
<htmL>
<head>
    <meta charset="utf-8">
    <title>ECトップページ</title>
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
        @foreach ($errors->all() as $error)
            <p class="error_message">{{ $error }}</p>
        @endforeach


        <ul class="item-list">
            @foreach($items as $value)
                <li>
                    <div class="item">
                        <form action="/ec/store/cart_in" method="post">
                            <span class="item-img"><img class="item_img" src="/img/{{$value->img}}"></span>
                            <div class="item-info">
                                <span class="item-name">{{$value->name}}</span>
                                <span class="item-price">{{$value->price}}円</span>
                            </div>
                            @if($value->stock > 0)
                                <input class="cart-btn" type="submit" value="カートに入れる">
                            @elseif($value->stock <= 0)
                                <p class="sold-out" >売り切れ</p>
                            @endif
                                <input type="hidden" name="id" value={{$value->id}}>
                            @csrf
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
