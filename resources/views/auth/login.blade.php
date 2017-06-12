@extends('layout.master')

@section('title', "登录")

@section('content')
    <div class="hidden-xs col-sm-6 thumbnail">
        <img src="/img/loginpic.jpg"/>
    </div>
    <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-1 panel panel-default">
        <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
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
                <input type="submit" class="btn btn-primary" value="登录">
               <input type="button" class="btn btn-success" value="注册" onclick="window.location.href='/register'">
            </form>
        </div>
    </div>

@endsection