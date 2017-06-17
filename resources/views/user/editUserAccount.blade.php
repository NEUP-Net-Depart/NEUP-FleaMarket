<div class="row">
<div class="mx-auto">
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
            {!! $errors->first() !!}
        </div>
    @endif
</div>
</div>
<div class="row">
<div class="mx-auto">
    <p>
    <form action="/user/edit/username" method="POST">
        {{ csrf_field() }}
        @if($user->username=='')
            <div class="form-group">
                <label for="username">用户名</label>
                <input placeholder="设置后不可修改" type="text" name="username" id="username" class="form-control" value="{{$user->username}}" required>
                <input type="submit" class="btn btn-primary" value="设置">
            </div>
        @else
            <label style="font-size:13px;line-height:38px">用户名：{{$user->username}}</label>
        @endif
    </form>
    </p>
    <p>
    <form action="/user/edit/stuid" method="POST">
        {{ csrf_field() }}
        @if($user->stuid=='')
            <div class="form-group">
                <label for="stuid">学号</label>
                <input placeholder="绑定后不可修改" type="text" name="stuid" id="stuid" class="form-control" value="{{$user->stuid}}" required>
            </div>
            <input type="submit" class="btn btn-primary" name="stuid_submit" value="绑定">
        @else
            <label style="font-size:13px;line-height:38px">学号：　{{$user->stuid}}</label>
        @endif
    </p>
    </form>
    <p>
    <form action="/user/edit/email" method="POST">
        {{ csrf_field() }}
        @if($user->email=='')
            <p><input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="邮箱" required></p>
            <div class="row">
            <div class="mx-auto">
                <input type="submit" class="btn btn-primary" name="email_submit" value="绑定">
            </div>
            </div>
        @else
            <div class="form-group">
                <label style="font-size:13px">邮箱：　{{$user->email}}（@if($user->havecheckedemail)已验证@else未验证@endif）</label>
                <input type="hidden" name="email" id="email" class="form-control" value="{{$user->email}}">
                <input type="submit" class="btn btn-warning" value="解绑">
            </div>
        @endif
    </form>
    </p>
</div>
</div>
<hr>
<div class="row row-password">
<div class="mx-auto">
    <form action="/user/edit/password" method="POST" class="password-form">
        {{ csrf_field() }}
        @if($user->password!='')
            <p><input type="password" name="password" id="password" class="form-control" placeholder="当前密码" required></p>
        @endif
        <p><input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="新密码" required></p>
        <p><input type="password" name="newPassword_confirmation" id="newPassword_confirmation" class="form-control" placeholder="确认新密码" required></p>
        <div class="row">
        <div class="mx-auto">
            <input type="submit" class="btn btn-success" name="password_submit" value="保存">
        </div>
        </div>
    </form>
</div>
</div>