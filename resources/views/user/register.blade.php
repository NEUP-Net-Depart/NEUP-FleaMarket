@include('includes.head')
    <title>注册 - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <form action="/adduser" method="POST" data-abide novalidate>
        <label>
            <input type="text" name="username" placeholder="用户名" required pattern="alpha_numeric">
            <span class="form-error">用户名不能为空！只允许包含字母和数字！</span>
        </label>
        <label>
            <input type="password" id="password" name="password" placeholder="密码" required>
            <span class="form-error">密码不能为空！</span>
        </label>
        <label>
            <input type="password" placeholder="确认密码" required pattern="alpha_numeric" data-equalto="password">
            <span class="form-error">两次输入的密码不一致！</span>
        </label>
        <input type="text" name="nickname" placeholder="昵称">
        <label>
            <input type="email" name="email" placeholder="邮箱" required>
            <span class="form-error">邮箱未填写或格式不正确！</span>
        </label>
        {!! csrf_field() !!}
        <input type="submit" class="button" value="注册">
    </form>
</div>
@include('layout.footer')
@include('includes.foot')
