@extends('layout.master')

@section('title', "登录")

@section('asset')
    <style>
        @media (min-width: 992px) {
            .login-card {
                width:400px;
            }
        }
    </style>
    <script>
        if (matchMedia) {
            var mq = window.matchMedia("(min-width: 992px)");
            mq.addListener(WidthChange);
            WidthChange(mq);
        }

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
    <div class="row row-first" style="margin-top:130px;margin-bottom:50px">
        <div class="mx-auto row row-second">
            <div class="hidden-md-down" style="width:380px;margin-right:20px">
                <br/><br/>
                <h2 style="text-align:right"><b>旧很靠谱</b></h2>
                <br/><br/><br/>
                <h4 style="text-align:right">自主研发 | 校卡绑定 | 安全便捷</h4>
            </div>
            <div class="card login-card">
                <div class="card-header">登录</div>
                <div class="card-block">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                            {!! $errors->first() !!}
                        </div>
                    @endif
                    <form action="/login" method="POST">
                        <div class="form-group">
                            <label for="username">用户名/邮箱</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="如果都没有的话，就用校卡登录吧" tabindex="1">
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