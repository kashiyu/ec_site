<!DOCTYPE html>
<htmL>
<head>
    <meta charset="utf-8">
    <title>買い物カゴ</title>
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
        <h1 class="title">ショッピングカート</h1>
            
        @if (session('success_message'))
            <p class="success_message">
                {{ session('success_message') }}
            </p>
        @endif
        @if (session('error_message'))
            <p class="error_message">
                {{ session('error_message') }}
            </p>
        @endif

        @if (!empty($error_array))
            @foreach($error_array as $error)
            <p class="error_message">
                {{$error}}
            </p>
            @endforeach
        @endif

        @foreach ($errors->all() as $error)
            <p class="error_message">{{ $error }}</p>
        @endforeach
        
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
                            
                            <form class="cart-item-del" action="/ec/store/cart/delete" method="post">
                                <input type="hidden" name="item_id" value="{{$value->id}}">
                                <input type="submit" value="削除">
                                @csrf
                            </form>

                            <span class="cart-item-price">{{$value->price}}円</span>
                            <form class="form_select_amount" id="form_select_amount406" action="/ec/store/cart/chz_amount" method="post">
                                <input type="text" class="cart-item-num2" min="0" name="amount" 
                                    value="{{$value->amount}}">個&nbsp;
                                <input type="hidden" name="item_id" value="{{$value->id}}">
                                <input type="submit" value="変更する">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="buy-sum-box">
                <span class="buy-sum-title">合計</span>
                <span class="buy-sum-price">¥ {{$total_fee}}</span>
            </div>

            <form action="/ec/store/cart/buy" method="post">
                <input class="buy-btn" type="submit" value="購入する">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>