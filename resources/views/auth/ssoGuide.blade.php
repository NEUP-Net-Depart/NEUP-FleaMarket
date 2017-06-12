@extends('layout.master')

@section('title', "注册")

@section('content')
    <div class="jumbotron">
        <p>先锋市场当前仅允许校内人员注册使用。如果这是你第一次使用本网站，请点击下面的按钮，前往校园统一身份认证服务平台进行认证注册。</p>
        <center><a href="/sso" class="btn btn-primary">校园统一身份认证服务平台</a></center><br/>
        <p>友情提示：校园统一身份认证服务平台的初始密码为身份证号后六位，“X”用“0”代替。此密码与校园卡是否修改过密码无关。为了您的账号安全，强烈建议您修改校园统一身份认证服务平台（SSO）的密码。</p>
        <p>初次登录后，你可以为自己设置一个用户名，或者绑定你的邮箱，以使用它们进行登录。你也可以继续使用校卡平台进行快捷登录。</p>
    </div>
@endsection