@include('includes.head')
    <title>修改个人信息</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
<form action="/user/{{$user->id}}/edit/middle" method="POST">
    <div>
        性别:<select name="gender">
            <option value="男">男</option>
            <option value="女">女</option>
        </select>
    </div>
    </br>
    <div>
        真实姓名：<input type="text" name="realname">
    </div>
    </br>
    <div>
        手机号：<input type="text" name='tel_num'>
    </div>
    </br>
    <div>
        地址:<input type="text" name="address">
    </div>
    </br>
    {!! csrf_field() !!}
    <div>
        <input type="submit" name="submit" value="修改">
    </div>
</form>
</div>
@include('layout.footer')
@include('includes.foot')
