{!! csrf_field() !!}
<html>
    <head>
        <title>注册</title>
    </head>
    <body>
        <form action="/adduser" method="POST">
            <div>
                昵称:<input type="text" name="nickname">
            </div>
            <div>
                用户名：<input type="text" name="username">
            </div>
            <div>
                密码：<input type="text" name='password'>
            </div>
            <div>
                邮箱:<input type="email" name="email">
            </div>
            <div>
                学号:<input type="text" name="stuid">
            </div>
            <div>
                <input type="submit" name="submit" value="注册">
                </div>
        </form>
    </body>
</html>
