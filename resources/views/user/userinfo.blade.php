@extends('layout.master')

@section('title', "用户信息")

@section('content')

    <div class="page-content">
        @if(isset($user->nickname))
            <div>昵称:{{ $user->nickname }}</div>
        @else
            <div>昵称:未设置</div>
        @endif
        <a class="button" href='/user/{{$user->id}}/edit'>编辑</a><br/>
        <a class="button" href='/good/my'>MyGood</a><br/>
        <a class="button" href='/good/check'>Check</a><br/>
        <a class="button" href='/logout'>登出</a><br/>
    </div>

@endsection