<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/ec.css')}}">
</head>
<body>
    <header>
        <div class="header-box">
            <a href="/ec/login">
                <img class="logo" img src="/img/logo.png" alt="EC_logo">
            </a>
        </div>
    </header>

    @yield('main_content')
</body>
</html>
