<div class="row">
    {{ csrf_field() }}
    <label>用户名<input @if($user->username=='') placeholder="绑定后不可修改" @else disabled @endif type="text" name="username" value="{{$user->username}}"></label>
    <label>学号<input @if($user->stuid=='') placeholder="绑定后不可修改" @else disabled @endif type="text" name="stuid" value="{{$user->stuid}}"></label>
    <label>邮箱<input type="email" name="email" value="{{$user->email}}"></label>
    <label>当前密码<input type="password" name="password" placeholder="必填"></label>
    <label>新密码<input type="password" name="newPassword"></label>
    <label>确认新密码<input type="password" name="newPassword_confirmation"></label>
    <input type="submit" class="hollow button" value="保存">
</div>