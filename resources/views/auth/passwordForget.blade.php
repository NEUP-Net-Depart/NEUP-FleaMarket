@extends('layout.master')

@section('title', "重置密码")

@section('content')

    <h2>重置密码</h2>
    @if($method=="GET")
        <form action="/iforgotit" method="POST">
            邮箱: <input type="email" name="email">
            {!! csrf_field() !!}
            <input type="submit" class="button" value="确定">
        </form>
    @else
        {{$sentence}}
        <a href="/iforgotit">返回</a>
    @endif

@endsection