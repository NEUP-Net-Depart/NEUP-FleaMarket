@extends('layout.master')

@section('title', "登录")

@section('asset')
    <style>
        @media (min-width: 992px) {
            .login-card {
                width:400px;
            }
            .row-first {
                margin-top:90px;
                margin-bottom:50px;
            }
        }
    </style>
    <script>
        match_media = "(min-width:992px)";

        function WidthChange(mq) {
            if (mq.matches) {
                $('.row-first').attr('class','row row-first');
                $('.row-second').attr('class','mx-auto row row-second');
            } else {
                $('.row-first').attr('class','row-first');
                $('.row-second').attr('class','mx-auto row-second');
            }
        }
    </script>
@endsection

@section('content')
    <div class="row-first">
        <div class="mx-auto row-second">
            <div class="d-sm-none d-md-block my-auto" style="width:380px;margin-right:20px:height:100%">
                <h2 style="text-align:center"><b>旧很靠谱</b></h2>
                <p></p>
                <h4 style="text-align:center">自主研发 | 校卡绑定 | 安全便捷</h4>
            </div>
            <div class="card login-card">
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
                            <input type="text" name="username" id="username" class="form-control" placeholder="可以使用校卡平台登录" tabindex="1">
                        </div>
                        <div class="form-group">
                            <label for="password">密码（<a href="/iforgotit">忘记密码？</a>）</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="密码" tabindex="2">
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
@endsection