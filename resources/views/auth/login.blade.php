@extends('layout.master')

@section('title', "登录")

@section('content')
<p></p>

<div class="d-none d-md-block"><br/></div>

<div class="row">
    <div class="d-none d-lg-block col-1"></div>
    <div class="d-none d-md-block col-6 col-lg-5">
        <div class="row h-100">
            <div class="col mx-auto my-auto">
                <h2><center><b>旧很靠谱</b></center></h2>
                <p></p>
                <h4><center>自主研发 | 校卡绑定 | 安全便捷 </center></h4>
            </div>
        </div>
    </div>
    <div class="col col-md-6 col-lg-5">
        <div class="row h-100">
            <div class="col col-md-11 mx-auto my-auto">
                <div class="card">
                    <div class="card-header">登录</div>
                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                                <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                                {!! $errors->first() !!}
                            </div>
                        @endif
                        <form action="/login" method="POST">
                            <div class="form-group">
                                <label for="username">用户名/邮箱</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="可以使用校卡平台登录" tabindex='1'>
                            </div>
                            <div class="form-group">
                                <label for="password">密码（<a href="/iforgotit">忘记密码？</a>）</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="密码" tabindex='2'>
                            </div>
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-auto mr-auto">
                                    <input type="submit" class="btn btn-primary" value="登录">
                                </div>
                                <div class="col-auto ml-auto">
                                    <input type="button" class="btn btn-success" value="校卡平台快捷登录" onclick="window.location.href='/sso'">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection