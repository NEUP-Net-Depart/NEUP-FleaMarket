@include('includes.head')
<title>修改个人信息</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <form action="/user/{{$user->id}}/edit/middle" method="POST">
        <ul class="tabs" data-tabs id="editinfo">
            <li class="tabs-title is-active"><a href="#avatar" aria-selected="true">头像</a></li>
            <li class="tabs-title"><a href="#studentid">学号审核</a></li>
            <li class="tabs-title"><a href="#userinfo">个人信息</a></li>
        </ul>
        <div class="tabs-content" data-tabs-content="editinfo">
        <div class="tabs-panel" id="avatar">
        </div>
        <div class="tabs-panel" id="studentid">
        </div>
        <div class="tabs-panel" id="userinfo">
            性别:
            <select name="gender">
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
            真实姓名：
            <input type="text" name="realname">
            手机号：
            <input type="text" name='tel_num'>
            地址：
            <input type="text" name="address">
            {!! csrf_field() !!}
            <input class="button" type="submit" name="submit" value="修改">
        </div>
        </div>
        </div>
    </form>
</div>
@include('layout.footer')
@include('includes.foot')
