@extends('layout.header')
@section('title','購入完了ページ')
@section('main_content')
    
    <div class="content">
    @include('layout.message')
    @parent
        <div class="finish-msg">ご購入ありがとうございました。</div>
        
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
                        <span class="cart-item-price">{{$value->price}}円</span>
                        <span class="finish-item-price">{{$value->amount}}</span>
        
                    </div>
                </li>
                @endforeach
            </ul>
            
            <div class="buy-sum-box">
                <span class="buy-sum-title">合計</span>
                <span class="buy-sum-price">¥ {{$total_fee}}</span>
            </div>
        </div>
    </div>
@endsection
