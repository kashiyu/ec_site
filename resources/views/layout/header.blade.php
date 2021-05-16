<!DOCTYPE html>
<htmL>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
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
    
    @yield('main_content')

</body>
</html>