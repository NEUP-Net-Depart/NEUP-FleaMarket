@extends('layout.master')

@section('title', "注册")

@section('content')

    <div class="row card">
        <div class="medium-8 medium-centered small-11 small-centered columns" style="padding-top: 80px; padding-bottom: 80px">
            <p>先锋市场当前仅允许校内人员注册使用。如果这是你第一次使用本网站，请点击下面的按钮，前往校园统一身份认证服务平台进行认证注册。</p>
            <center><a href="/sso" class="button small-centered">校园统一身份认证服务平台</a></center>
            <p>友情提示：校园统一身份认证服务平台的初始密码为校园卡查询密码。注意：此密码与校园卡是否修改过卡片的消费密码无关。这个密码可能是以下几种之一：校园卡身份证号后六位（“X”用“0”代替），学号后六位，「000000」。为了您的账号安全，强烈建议您修改校园统一身份认证服务平台（SSO）的密码。</p>
            <p>初次登录后，你可以为自己设置一个用户名，或者绑定你的邮箱，以使用它们进行登录。你也可以继续使用校卡平台进行快捷登录。</p>

            </div>
        </div>
    </div>

@endsection