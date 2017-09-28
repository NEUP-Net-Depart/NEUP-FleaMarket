@extends('layout.master')

@section('title', "注册")

@section('content')
<!--2017/09/27 23:23 程序员因修改完login.blade.php后不肯修改未投入使用的register.blade.php而被祭天-->
<br/>

<div class="row">
    <div class="d-none d-md-block col-6 row">
        <div class="row h-100">
            <div class="col-auto ml-auto my-auto">
                <h2><center><b>旧很靠谱</b></center></h2>
                <p></p>
                <h4><center>自主研发 | 校卡绑定 | 安全便捷 </center></h4>
            </div>
        </div>
    </div>
    <div class="col col-md-6 col-lg-5">
        <div class="card">
            <div class="card-header">注册</div>
            <div class="card-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                        {!! $errors->first() !!}
                    </div>
                @endif
                <form action="/register" method="POST">
                    <div class="form-group">
                        <input type="text" name="email" id="username" class="form-control" placeholder="邮箱">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="确认密码">
                    </div>
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <input type="submit" class="btn btn-primary" value="注册">
                        </div>
                        <div class="col-auto ml-auto">
                            <input type="button" class="btn btn-success" value="校园统一身份认证" onclick="window.location.href='/sso'">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection