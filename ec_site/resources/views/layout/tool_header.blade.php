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
            <a class="nemu" href="/ec/logout">ログアウト</a>
            <a class="nemu" href="@yield('href')">@yield('href_title')</a>
            <p class="nemu">ユーザー名：{{$user_name}}</p>
        </div>
    </header>

    <h1>@yield('sub_title')</h1>

    @yield('main_content')

    </body>
</html>