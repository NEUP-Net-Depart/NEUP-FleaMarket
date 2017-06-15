@extends('layout.master')

@section('title', "登录")

@section('content')
    <div class="row hidden-sm-down">
    <div class="col-6">
    <div class="card float-right">
        <div class="card-block">
            <img src="/img/loginpic.jpg" style="height:210px">
        </div>
    </div>
    </div>
    <div class="col-6">
    <div class="card float-left">
        <div class="card-block">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert" style="width:373.63px">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <form action="/login" method="POST">
                <div class="form-group">
                    <label for="username">用户名/邮箱</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="如果都没有的话，就用校卡登录吧" style="width:373.63px">
                </div>
                <div class="form-group">
                    <label for="password">密码（<a href="/iforgotit">忘记密码？</a>）</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="密码" style="width:373.63px">
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
    </div>
    </div>
    <div class="hidden-md-up">
        <div class="container">
        <div class="card">
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
        <div class="container">
        <div class="card">
            <div class="card-block">
                <img src="/img/loginpic.jpg" style="width:100%">
            </div>
        </div>
    </div>
@endsection