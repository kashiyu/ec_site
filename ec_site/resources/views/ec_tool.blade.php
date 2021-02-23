@extends('layout.tool_header')
@section('title','商品管理ページ')
@section('sub_title','EC 管理ページ')
@section('href','/ec/tool/admin')
@section('href_title','ユーザ管理ページ')
@section('main_content')
@include('layout.message')
@parent


    <section>
    <h2>商品の登録</h2>
        <form action="/ec/tool/add" method="post" enctype="multipart/form-data">
            <label>商品名<input type="text" name="name"></label>
            <label>値段<input type="text" name="price" maxlength="8"></label>
            <label>個数<input type="text" name="stock" maxlength="8"></label>
            <label>商品画像<input type="file" name="img"></label>
            <label>ステータス<select name="status">
                <option value="1">公開</option>
                <option value="0">非公開</option>
            </select></label>

            <input type="submit" value="商品を登録する">
            @csrf 
        </form>
    </section>

    <section>
        <h2>商品情報の一覧・変更</h2>
        <table>
        <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>ステータス</th>
            <th>操作</th>
        </tr>
        @foreach($item as $value)
        <tr 
        @if($value->status === '0')
            class="false_sts"
        @endif >
        
            <td><img class="item_img" src="/img/{{$value->img}}"></td>
            <td>{{$value->name}}</td>
            <td>{{$value->price}}円</td>

            <td>
                <form action="/ec/tool/chz_stock" method="post">
                    <input type="text" name="stock" class="stock_text" maxlength="7" value="{{$value->stock}}">個
                    <input type="hidden" name='item_id' value={{$value->id}}>
                    <input type="submit" value="変更する"></td>
                    @csrf
                </form>
            <td>
                <form action="/ec/tool/chz_sts" method="post">
                    @if($value->status === '1')
                    <input type="submit" value="公開→非公開にする">
                    <input type="hidden" name='status' value='0'>
                    @elseif($value->status === '0')
                    <input type="submit" value="非公開→公開にする">
                    <input type="hidden" name='status' value='1'>
                    @endif
                    <input type="hidden" name='item_id' value={{$value->id}}>
                    @csrf
                </form>
            </td>

            <td>
                <form action="/ec/tool/delete" method="post">
                    <input type="submit" value="削除する">
                    <input type="hidden" name='drink_id' value= {{$value->id}}>
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
        @endforeach
        </table>
    </section>
@endsection

