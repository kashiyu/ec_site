<htmL>
<head>
  <title>商品管理ページ</title>
  <link rel="stylesheet" type="text/css" href="{{asset('css/ec.css')}}">
</head>
<body>
    <header>
        <div class="header-box">
            <a href="/ec/store.php">
                <img class="logo" src="/img/logo.png" alt="EC_logo">
            </a>
            <a class="nemu" href="/ec/logout">ログアウト</a>
            <a href="" class="cart"></a>
            <p class="nemu">ユーザー名：{{$user_name}}</p>
        </div>
    </header>

    <h1>EC STOREページ</h1>
    @if (session('success_message'))
        <p class="success_message">
            {{ session('success_message') }}
        </p>
    @endif
    @foreach ($errors->all() as $error)
        <p class="error_message">{{ $error }}</p>
    @endforeach

</body>
</html>

