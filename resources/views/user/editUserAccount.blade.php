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
        @if($user->username=='')
        <form action="/user/edit/username" method="POST" class="password-form">
            {{ csrf_field() }}
            <div class="input-group">
                <input placeholder="用户名" type="text" name="username" id="username" class="form-control" required>
                <span class="input-group-btn"><input type="submit" class="btn btn-primary" value="设置"></span>
            </div>
        </form>
        @else
            <div class="input-group">
                <input placeholder="用户名" type="text" name="username" id="username" class="form-control" value="{{$user->username}}" disabled>
                <span class="input-group-btn"><input type="submit" class="btn btn-secondary disabled" value="设置"></span>
            </div>
        @endif
    </p>
    <p>
        @if($user->stuid=='')
        <form action="/user/edit/stuid" method="POST" class="password-form">
            {{ csrf_field() }}
            <div class="input-group">
                <input placeholder="学号" type="text" name="stuid" id="stuid" class="form-control" value="{{$user->stuid}}" required>
                <span class="input-group-btn"><input type="submit" class="btn btn-primary" name="stuid_submit" value="绑定"></span>
            </div>
        </form>
        @else
            <div class="input-group">
                <input placeholder="学号" type="text" name="stuid" id="stuid" class="form-control" value="{{$user->stuid}}" disabled>
                <span class="input-group-btn"><input type="submit" class="btn btn-secondary disabled" name="stuid_submit" value="绑定"></span>
            </div>
        @endif
    </p>
    <p>
        @if($user->email=='')
        <form action="/user/edit/email" method="POST" class="password-form">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="邮箱" required>
                <span class="input-group-btn"><input type="submit" class="btn btn-primary" name="email_submit" value="绑定"></span>
            </div>
        </form>
        @else
        <form action="/user/edit/email" method="POST" class="password-form">
            <div class="input-group">
                <input type="email" id="email" class="form-control" value="@if(!$user->havecheckedemail)[未验证]@endif{{$user->email}}" disabled>
                <input type="hidden" name="email" id="email" class="form-control" value="{{$user->email}}">
                <span class="input-group-btn"><input type="submit" class="btn btn-warning" name="email_submit" value="解绑"></span>
            </div>
        </form>
        @endif
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