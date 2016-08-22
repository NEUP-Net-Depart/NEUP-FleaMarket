@include('includes.head')
    <title>登陆</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <label>
                <span class="form-error is-visible">{{ $error }}</span>
            </label>
        @endforeach
    @endif
        <form action="/login" method="POST">
            <div>
                用户名:<input type="text" name="username">
            </div>
            <div>
                密码:<input type="password" name="password">
            </div>
            {!! csrf_field() !!}
            <div>
                <input type="submit" name="submit" value="登陆">
            </div>
        </form>
        <a href='/iforgotit'>忘记密码</a><br/>
</div>
@include('layout.footer')
@include('includes.foot')