@extends('layout.master')

@section('title', "登录")

@section('content')
    <div class="row">
    <div class="hidden-sm-down col-md-6 card">
        <div class="card-block">
            <img src="/img/loginpic.jpg" style="width:100%">
        </div>
    </div>
    <div class="col-10 offset-1 col-md-4 offset-md-1 card">
        <div class="card-block">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <form action="/login" method="POST">
                <div class="form-group">
                    <label for="username">用户名/邮箱</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="用户名/邮箱">
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="密码">
                </div>
                {!! csrf_field() !!}
                <div class="float-left">
                    <input type="submit" class="btn btn-primary" value="登录">
                </div>
                <div class="float-right">
                    <input type="button" class="btn btn-success" value="校卡平台快捷登录" onclick="window.location.href='/sso'">
                </div>
            </form>
        </div>
    </div>
    </div><br/>
    <div class="row">
    <div class="hidden-md-up col-10 offset-1 card">
        <div class="card-block">
            <img src="/img/loginpic.jpg" style="width:100%">
        </div>
    </div>
    </div>

@endsection