@extends('layout.master')

@section('title', "注册")

@section('content')

    <div class="row card">
        <div class="medium-8 medium-centered small-11 small-centered columns" style="padding-top: 80px; padding-bottom: 80px">
            　　先锋市场当前仅面向校内人员使用。若你是初次使用本网站服务，请点击下面的按钮，前往校园统一身份认证服务平台使用学号登录。该平台登录密码为你在未修改时的校园卡密码。初次登录后，你可以为自己设置一个用户名，或者绑定你的邮箱，以使用它们进行登录。你也可以再次使用校卡平台进行快捷登录。
                <center><a href="/sso" class="button small-centered">校园统一身份认证服务平台</a></center>
            </div>
        </div>
    </div>

@endsection