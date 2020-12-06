<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ユーザ登録ページ</title>
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
    
    <div class="content">
        <div class="register">
            <form method="post" action="/ec/register">
                <div>ユーザー名：<input type="text" name="user_name" placeholder="ユーザー名"></div>
                <div>パスワード：<input type="password" name="password" placeholder="パスワード">
                <div><input type="submit" value="ユーザーを新規作成する">
                @csrf
            </form>
            <div class="login-link"><a href="/ec/login">ログインページへ戻る</a></div>

            @foreach ($errors->all() as $error)
                <p class="error_message">{{ $error }}</p>
            @endforeach
            @if (session('error_message'))
            <p class="error_message">
                {{ session('error_message') }}
            </p>
            @endif
        </div>
    </div>
</body>
</html>