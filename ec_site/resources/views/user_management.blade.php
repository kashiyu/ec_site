<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ユーザ管理ページ</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/ec.css')}}">
</head>
<body>
    <header>
        <div class="header-box">
            <a href="/ec/store">
                <img class="logo" src="/img/logo.png" alt="EC_logo">
            </a>
            <a class="nemu" href="/ec/logout">ログアウト</a>
            <a class="nemu" href="/ec/tool">商品管理ページ</a>
            <p class="nemu">ユーザー名：{{$user_name}}</p>
        </div>
    </header>

    <h1>ユーザー管理ページ</h1>
    @if (session('success_message'))
        <p class="success_message">
            {{ session('success_message') }}
        </p>
    @endif
    @foreach ($errors->all() as $error)
        <p class="error_message">{{ $error }}</p>
    @endforeach

    <section>
        <h2>ユーザ情報一覧</h2>

        <table>
            <tr>
                <th>ユーザID</th>
                <th>管理者権限</th>
                <th>登録日</th>
                <th>操作</th>
            </tr>
            @foreach($users as $value)
                <tr>
                    <td class="name_width">{{$value->user_name}}</td>
                    <td>              
                        <form action="/ec/tool/admin/chz_adm" method="post">
                            @if($value-> adm_flag === '1')
                                <input type="hidden" name="adm_flag" value="0">
                                <input type="checkbox" name="adm_flag" value="1" checked="checked">
                                
                            @elseif($value-> adm_flag === '0')
                                <input type="hidden" name="adm_flag" value="0">
                                <input type="checkbox" name="adm_flag" value="1">
                            @endif
                            <input type="hidden" name='user_id' value={{$value->id}}>
                            <input type="submit" value="変更">
                            @csrf
                        </form>
                    </td>
                    <td>{{$value->create_at}}</td>
                    <td>                
                        <form action="/ec/tool/admin/delete" method="post">
                            <input type="submit" value="削除する">
                            <input type="hidden" name='user_id' value= {{$value->id}}>
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </table>
    </section>
</body>
</html>