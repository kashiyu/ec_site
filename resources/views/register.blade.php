@extends('layout.login_header')
@section('title','ユーザ登録ページ')
@section('main_content')

    <div class="content">
        <div class="register">
            <form method="post" action="/ec/register">
                <div>ユーザー名：<input type="text" name="user_name" placeholder="ユーザー名"></div>
                <div>パスワード：<input type="password" name="password" placeholder="パスワード">
                <div><input type="submit" value="ユーザーを新規作成する">
                @csrf
            </form>
            <div class="login-link"><a href="/ec/login">ログインページへ戻る</a></div>

            @include('layout.message')
            @parent

        </div>
    </div>

@endsection