@extends('layout.tool_header')
@section('title','ユーザー管理ページ')
@section('sub_title','ユーザー管理ページ')
@section('href','/ec/tool')
@section('href_title','商品管理ページ')
@section('main_content')
@include('layout.message')
@parent

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
@endsection