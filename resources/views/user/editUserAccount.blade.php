<div class="row">
<div class="col mx-auto">
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
            {!! $errors->first() !!}
        </div>
    @endif
</div>
</div>
<div class="row">
<div class="col mx-auto">
    @if($user->email=='' && $user->wechat_open_id=='' && $user->tel == '')
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                你没有绑定邮箱、微信、手机，这将导致你无法及时收到消息！
            </div>
    @elseif($user->wechat_open_id=='' && $user->tel == '')
                <div class="alert alert-warning" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    你既没有绑定微信也没有绑定手机，这可能导致你无法及时收到消息！
                </div>
    @elseif($user->email=='')
                <div class="alert alert-info" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    通过绑定邮箱，你可以通过邮箱登录和接收相关通知消息！
                </div>
    @endif
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
            {{ csrf_field() }}
            <div class="input-group">
                <input type="email" id="email" class="form-control" value="@if(!$user->havecheckedemail)[未验证]@endif{{$user->email}}" disabled>
                <input type="hidden" name="email" id="email" class="form-control" value="{{$user->email}}">
                <span class="input-group-btn"><input type="submit" class="btn btn-warning" name="email_submit" value="解绑"></span>
            </div>
        </form>
        @endif
    </p>
    <p>
        @if($user->wechat_open_id=='')
                    <label>微信：扫描二维码或在东大小秘书中点击“更多/先锋市场”链接来关联微信。
                        </label>
                    <img src="/img/wxqr.png" height="72px" width="72px">
        @else
                    <label>微信：已关联 <span class="nickname">{{$user->wechat->nick_name}}</span></label>
                    <img class="head-img col-centered" src="{{$user->wechat->head_img_url}}" width="64px" height="64px">
        @endif
    </p>
    <p>
        <div id="tel-region" style=""
             class="@if($user->tel != '') hide @endif">
            <form id="tel-form" action="" class="password-form"
                  onkeydown="if(event.keyCode==13){return false;}">
                {{ csrf_field() }}
                <div id="tel-geetest-captcha">
                    <p style="margin-bottom: 0.3em">若要绑定手机，请先完成人机验证...</p>
                    {!! Geetest::render() !!}
                </div>
                <div id="tel-form-input" class="input-group hide">
                    <span class="input-group-addon" id="tel-addon">(+86)</span>
                    <input type="tel" name="tel" id="tel" class="form-control"
                           value="" placeholder="手机"
                           aria-describedby="tel-addon">
                    <span class="input-group-btn">
                    <input id="tel-text-send-btn" type="button" class="btn btn-primary"
                           value="发送" onclick="sendMsg();">
                    </span>
                </div>
                <div id="tel-captcha-input" class="input-group hide" style="margin-top: 0.3em;">
                    <span class="input-group-addon" id="captcha-addon">验证码</span>
                    <input type="text" name="captcha" id="captcha" class="form-control"
                           value="" aria-describedby="captcha-addon">
                    <span class="input-group-btn">
                    <input id="tel-submit-btn" type="button" class="btn btn-primary"
                           value="绑定" onclick="bindTel();">
                    </span>
                </div>
            </form>
            <div id="tel-form-toast" class="alert hide" role="alert"
                 style="margin-top: 0.3em;"></div>
        </div>
        <div id="tel-dis" class="input-group @if($user->tel == '') hide @endif">
            <input type="tel" name="tel-dis" id="tel-dis" class="form-control"
                   value="{{ $user->tel }}" placeholder="手机" disabled>
            <span class="input-group-btn">
                <input id="tel-change-btn" type="button" class="btn btn-primary"
                       value="更改" onclick="changeTel();">
            </span>
        </div>
    </p>
</div>
</div>
<hr>
<div class="row">
    <div class="col-8 mx-auto">
        @if($user->username=='' || $user->stuid=='')
            <div class="alert alert-info" role="alert">
                <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                为你的账户设置其他登录方式
            </div>
        @endif
        <p>
        @if($user->username=='')
            <form action="/user/edit/username" method="POST" class="password-form">
                {!! csrf_field() !!}
                <div class="input-group">
                    <input placeholder="用户名" type="text" name="username" id="username" class="form-control" required>
                    <span class="input-group-btn"><input type="submit" class="btn btn-primary" value="设置"></span>
                </div>
            </form>
        @else
            <div class="input-group">
                <input placeholder="用户名" type="text" name="username" id="username" class="form-control" value="{{$user->username}}" disabled>
                <span class="input-group-btn"><input type="submit" class="btn btn-secondary" value="设置" disabled></span>
            </div>
        @endif
        </p>
        <p>
            @if($user->stuid=='')
                <form action="/user/edit/stuid" method="POST" class="password-form">
                    {!! csrf_field() !!}
                    <div class="input-group">
                        <input placeholder="学号" type="text" name="stuid" id="stuid" class="form-control" value="{{$user->stuid}}" required>
                        <span class="input-group-btn"><input type="submit" class="btn btn-primary" name="stuid_submit" value="绑定"></span>
                    </div>
                </form>
            @else
                <div class="input-group">
                    <input placeholder="学号" type="text" name="stuid" id="stuid" class="form-control" value="{{$user->stuid}}" disabled>
                    <span class="input-group-btn"><input type="submit" class="btn btn-secondary" name="stuid_submit" value="绑定" disabled></span>
                </div>
            @endif
        </p>
    </div>
</div>
<hr>
<div class="row">
<div class="col-8 mx-auto">
    @if($user->password=='')
        <div class="alert alert-warning" role="alert">
            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
            你要先设置密码才能使用普通登录
        </div>
    @endif
    <p>
    <form action="/user/edit/password" method="POST" class="password-form">
        {!! csrf_field() !!}
        @if($user->password!='')
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="当前密码" required>
            </div>
            <p></p>
        @endif
        <div class="input-group">
            <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="新密码" required>
        </div>
        <p></p>
        <div class="input-group">
            <input type="password" name="newPassword_confirmation" id="newPassword_confirmation" class="form-control" placeholder="确认新密码" required>
        </div>
        <p></p>
        <div class="row">
            <div class="mx-auto">
                <input type="submit" class="btn btn-success" name="password_submit" value="保存">
            </div>
        </div>
    </form>
    </p>
</div>
</div>
<script>
    function changeTel() {
        $('#tel-dis').addClass('hide');
        $('#tel-region').removeClass('hide');
    }

    function removeAlertClass(sel) {
        sel.removeClass('alert-success');
        sel.removeClass('alert-info');
        sel.removeClass('alert-warning');
        sel.removeClass('alert-danger');
    }

    function toast(type, msg) {
        var toastArea = $("#tel-form-toast");
        toastArea.html(msg);
        removeAlertClass(toastArea);
        switch (type) {
            case 'success':
                toastArea.removeClass('hide');
                toastArea.addClass('alert-success');
                break;
            case 'error':
                toastArea.removeClass('hide');
                toastArea.addClass('alert-danger');
                break;
            case 'hide':
                toastArea.addClass('hide');
                break;
        }
    }

    function runCount(t) {
        var btn = $("#tel-text-send-btn");
        if (t > 0) {
            btn.attr('disabled', '');
            btn.removeClass('btn-primary');
            btn.addClass('btn-disable');
            btn.attr('value', t.toString());
            t--;
            setTimeout(function () {
                runCount(t);
            }, 1000);
        } else {
            btn.removeAttr('disabled');
            btn.addClass('btn-primary');
            btn.removeClass('btn-disable');
            btn.attr('value', "重新发送");
        }
    }

    function sendMsg() {
        if ($('#tel').val() == '') {
            toast('error', '请填写手机');
            return;
        }
        var str_data = $("#tel-form input").map(function () {
            return ($(this).attr("name") + '=' + $(this).val());
        }).get().join("&");
        $.ajax({
            type: "POST",
            url: "/captcha/sendChangeText",
            data: str_data,
            success: function (msg) {
                var dataObj = eval("(" + msg + ")");
                if (dataObj.rst === "true") {
                    $('#tel-captcha-input').removeClass('hide');
                    toast('success', dataObj.msg);
                    runCount({{ intval(env('MSG_COOLDOWN')) }});
                }
                else if (dataObj.rst === "false")
                    toast('error', dataObj.msg);
                else
                    toast('error', "未知错误，请刷新重试");
            },
            error: function (xhr) {
                toast('error', "服务器错误，请刷新重试");
            }
        });
    }

    function bindTel() {
        if ($('#captcha').val() == '') {
            toast('error', '请填写验证码');
            return;
        }
        var str_data = $("#tel-form input").map(function () {
            return ($(this).attr("name") + '=' + $(this).val());
        }).get().join("&");
        $.ajax({
            type: "POST",
            url: "/register/saveTel",
            data: str_data,
            success: function (msg) {
                var dataObj = eval("(" + msg + ")");
                if (dataObj.rst === "true") {
                    $('#tel-captcha-input').addClass('hide');
                    $('#tel-text-send-btn').addClass('hide');
                    $('#tel').attr('disabled', '');
                    toast('success', dataObj.msg);
                }
                else if (dataObj.rst === "false")
                    toast('error', dataObj.msg);
                else
                    toast('error', "未知错误，请刷新重试");
            },
            error: function (xhr) {
                toast('error', "服务器错误，请刷新重试");
            }
        });
    }
</script>
<link rel="stylesheet" href="/css/wechat.css"/>
