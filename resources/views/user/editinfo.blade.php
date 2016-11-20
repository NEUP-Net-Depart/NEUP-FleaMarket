@include('includes.head')
<title>修改个人信息</title>
<style>
    label {
        text-align: right;
        font-size: medium;
        color: #ffffff;
        min-width: 80px;
        max-width: 100px;
        float: right;
    }
</style>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <form action="/user/{{$user->id}}/edit/middle" method="POST">
        <div class="large-8 large-offset-2 small-10 small-offset-1 columns">
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">性别:</label>
                </div>
                <div class="small-10 columns">
                    <select name="gender">
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">真实姓名：</label>
                </div>
                <div class="small-10 columns">
                    <input type="text" name="realname">
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">手机号：</label>
                </div>
                <div class="small-10 columns">
                    <input type="text" name='tel_num'>
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">地址：</label>
                </div>
                <div class="small-10 columns">
                    <input type="text" name="address">
                </div>
            </div>
            {!! csrf_field() !!}
            <div>
                <input class="button" type="submit" name="submit" value="修改">
            </div>
        </div>
    </form>
</div>
@include('layout.footer')
@include('includes.foot')
