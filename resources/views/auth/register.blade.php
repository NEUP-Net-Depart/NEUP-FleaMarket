@extends('layout.master')

@section('title', "注册")

@section('asset')
    <style>
        @media (min-width: 992px) {
            .login-card {
                width:400px;
            }
            .row-first {
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
            <div class="hidden-md-down my-auto" style="width:380px;margin-right:20px:height:100%">
                <h2 style="text-align:center"><b>旧很靠谱</b></h2>
                <p></p>
                <h4 style="text-align:center">自主研发 | 校卡绑定 | 安全便捷</h4>
            </div>
            <div class="card login-card">
                <div class="card-header">注册</div>
                <div class="card-block">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                            {!! $errors->first() !!}
                        </div>
                    @endif
                    <form action="/register" method="POST">
                        <div class="form-group">
                            <input type="text" name="email" id="username" class="form-control" placeholder="邮箱" tabindex="1">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="密码" tabindex="2">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="确认密码" tabindex="3">
                        </div>
                        {!! csrf_field() !!}
                        <div class="float-left">
                            <input type="submit" class="btn btn-primary" value="注册">
                        </div>
                        <div class="float-right">
                            <input type="button" class="btn btn-success" value="校园统一身份认证" onclick="window.location.href='/sso'">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection