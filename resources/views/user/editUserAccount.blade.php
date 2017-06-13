<div class="col-xs-12 col-sm-4">
    <form action="/user/edit/username" method="POST">
        {{ csrf_field() }}
        @if($user->username=='')
            <div class="form-group">
                <label for="username">用户名</label>
                <input placeholder="设置后不可修改" type="text" name="username" id="username" class="form-control" value="{{$user->username}}" required>
                <input type="submit" class="btn btn-primary" value="设置">
            </div>
        @else
            <label>用户名：{{$user->username}}</label>
        @endif
    </form>
    <form action="/user/edit/stuid" method="POST">
        {{ csrf_field() }}
        @if($user->stuid=='')
            <div class="form-group">
                <label for="stuid">学号</label>
                <input placeholder="绑定后不可修改" type="text" name="stuid" id="stuid" class="form-control" value="{{$user->stuid}}" required>
            </div>
            <input type="submit" class="btn btn-primary" name="stuid_submit" value="绑定">
        @else
            <label>学号：{{$user->stuid}}</label>
        @endif
    </form>
    <form action="/user/edit/email" method="POST">
        {{ csrf_field() }}
        @if($user->email=='')
            <div class="form-group">
                <label for="email">邮箱</label>
                <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" required>
                <input type="submit" class="btn btn-primary" name="email_submit" value="绑定">
            </div>
        @else
            <div class="form-group">
                <label>邮箱：{{$user->email}}（@if($user->havecheckedemail) 已验证 @else 未验证 @endif）</label>
                <input type="hidden" name="email" id="email" class="form-control" value="{{$user->email}}">
                <input type="submit" class="btn btn-primary" value="解绑">
            </div>
        @endif
    </form>
    <form action="/user/edit/password" method="POST">
        {{ csrf_field() }}
        @if($user->password!='')
            <div class="form-group">
                <label for="password">当前密码</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="必填" required>
            </div>
        @endif
        <div class="form-group">
            <label for="newPassword">新密码</label>
            <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="必填" required>
        </div>
        <div class="form-group">
            <label for="newPassword_confirmation">确认新密码</label>
            <input type="password" name="newPassword_confirmation" id="newPassword_confirmation" class="form-control" placeholder="必填" required>
        </div>
        <input type="submit" class="btn btn-primary" name="password_submit" value="保存">
    </form>
</div>