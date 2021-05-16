@extends('layout.header')
@section('title','ECトップページ')
@section('main_content')


    <div class="content">
    @include('layout.message')
    @parent

        <ul class="item-list">
            @foreach($items as $value)
                <li>
                    <div class="item">
                        <form action="/ec/store/cart_in" method="post">
                            <span class="item-img"><img class="item_img" src="/img/{{$value->img}}"></span>
                            <div class="item-info">
                                <span class="item-name">{{$value->name}}</span>
                                <span class="item-price">{{$value->price}}円</span>
                            </div>
                            @if($value->stock > 0)
                                <input class="cart-btn" type="submit" value="カートに入れる">
                            @elseif($value->stock <= 0)
                                <p class="sold-out" >売り切れ</p>
                            @endif
                                <input type="hidden" name="id" value={{$value->id}}>
                            @csrf
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

@endsection
