<div class="row">
    <form action="/user/edit/username" method="POST">
        {{ csrf_field() }}
        @if($user->username=='')
            <label>用户名<input placeholder="设置后不可修改" type="text"
                             name="username" value="{{$user->username}}" required></label>
            <input type="submit" class="hollow button" value="设置">
        @else
            <label>用户名：{{$user->username}}</label>
        @endif
    </form>
    <form action="/user/edit/stuid" method="POST">
        {{ csrf_field() }}
        @if($user->stuid=='')
            <label>学号<input placeholder="绑定后不可修改" type="text" name="stuid"
                            value="{{$user->stuid}}" required></label>
            <input type="submit" class="hollow button" name="stuid_submit" value="绑定">
        @else
            <label>学号：{{$user->stuid}}</label>
        @endif
    </form>
    <form action="/user/edit/email" method="POST">
        {{ csrf_field() }}
        @if($user->email=='')
            <label>邮箱<input type="email" name="email" value="{{$user->email}}" required></label>
            <input type="submit" class="hollow button" name="email_submit" value="绑定">
        @else
            <label>邮箱：{{$user->email}}（@if($user->havecheckedemail) 已验证 @else 未验证 @endif）</label>
            <input type="hidden" name="email" value="{{$user->email}}">
            <input type="submit" class="hollow button" value="解绑">
        @endif
    </form>
    <form>
        @if($user->wechat_open_id)
            <label>微信：已关联 {{$user->wechat->nick_name}}</label>
            <img class="head-img" src="{{$user->wechat->head_img_url}}" width="64px" height="64px">
        @else
            <label>微信：请在东大小秘书中点击“闲置市场”链接来关联微信。</label>
        @endif
    </form>
    <form action="/user/edit/password" method="POST">
        {{ csrf_field() }}
        @if($user->password!='')
            <label>当前密码<input type="password" name="password" placeholder="必填" required></label>
        @endif
        <label>新密码<input type="password" name="newPassword" placeholder="必填" required></label>
        <label>确认新密码<input type="password" name="newPassword_confirmation" placeholder="必填" required></label>
        <input type="submit" class="hollow button" name="password_submit" value="保存">
    </form>
</div>

<link rel="stylesheet" href="/css/wechat.css"/>