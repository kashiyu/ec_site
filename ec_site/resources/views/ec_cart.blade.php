@extends('layout.header')
@section('title','買い物カゴ')
@section('main_content')

    <div class="content">
    @include('layout.message')
    @parent

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
                            
                            <form class="cart-item-del" action="/ec/store/cart/delete" method="post">
                                <input type="hidden" name="item_id" value="{{$value->id}}">
                                <input type="submit" value="削除">
                                @csrf
                            </form>

                            <span class="cart-item-price">{{$value->price}}円</span>
                            <form class="form_select_amount" id="form_select_amount406" action="/ec/store/cart/chz_amount" method="post">
                                <input type="text" class="cart-item-num2" min="0" name="amount" 
                                    value="{{$value->amount}}">個&nbsp;
                                <input type="hidden" name="item_id" value="{{$value->id}}">
                                <input type="submit" value="変更する">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="buy-sum-box">
                <span class="buy-sum-title">合計</span>
                <span class="buy-sum-price">¥ {{$total_fee}}</span>
            </div>

            <form action="/ec/store/cart/buy" method="post">
                <input class="buy-btn" type="submit" value="購入する">
                @csrf
            </form>
        </div>
    </div>
@endsection