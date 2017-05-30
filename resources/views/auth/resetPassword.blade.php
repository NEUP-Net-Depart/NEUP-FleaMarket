@extends('layout.master')

@section('title', "重置密码")

@section('content')

    <h2>重置密码</h2>
    @if($method=="GET")
        <form action="/passwordReset/{{$token}}" method="POST">
            新密码: <input type="password" name="password">
            确认密码: <input type="password" name="password_confirmation">
            {!! csrf_field() !!}
            <input type="submit" class="button" value="确定">
        </form>
    @else
        {{$sentence}}
    @endif

@endsection