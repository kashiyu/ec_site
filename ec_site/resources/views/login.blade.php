<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ログインページ</title>
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
        <div class="login">
            <form action="/ec/login" method="post">
                <div><input type="text" name="user_name" placeholder="ユーザー名"></div>
                <div><input type="password" name="password" placeholder="パスワード">
                <div><input type="submit" value="ログイン">
                @csrf
            </form>
            <div class="account-create">
                <a href="/ec/register">ユーザーの新規作成</a>
            </div>
        </div>

        @if (session('error_message'))
            <p class="error_message">
                {{ session('error_message') }}
            </p>
        @endif
        @foreach ($errors->all() as $error)
                <p class="error_message">{{ $error }}</p>
        @endforeach
        @if (session('success_message'))
            <p class="success_message">
                {{ session('success_message') }}
            </p>
        @endif
    </div>


</body>
</html>