@include('includes.head')
    <title>注册 - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    @if (count($errors) > 0)
        <label>
            <span class="form-error is-visible">{{ $errors->first() }}</span>
        </label>
    @endif
    <form action="/register" method="POST" data-abide novalidate>
        <input type="text" name="username" placeholder="用户名（必填，3-64）">
        <input type="password" id="password" name="password" placeholder="密码（必填，6-128）">
        <input type="password" name="password_confirmation" placeholder="确认密码（必填）">
        <input type="text" name="email" placeholder="邮箱（必填）">
        <input type="text" name="nickname" placeholder="昵称（<=128）">
        {!! csrf_field() !!}
        <input type="submit" class="button" value="注册">
    </form>
</div>
@include('layout.footer')
@include('includes.foot')
