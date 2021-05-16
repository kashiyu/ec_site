@extends('layout.login_header')
@section('title','ログインページ')
@section('main_content')

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

        @include('layout.message')
        @parent
    </div>

@endsection