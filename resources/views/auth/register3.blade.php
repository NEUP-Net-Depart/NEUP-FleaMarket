@extends('layout.master')

@section('title', "即将打开新的大门")

@section('asset')
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
@endsection

@section('content')
<div class="row">
    <div class="col col-lg-10 col-xl-9 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    绑定邮箱、微信或手机，系统将会在买家或卖家发来消息时利用它们来通知你！
                </div>
                <form action="/user/edit/email" method="POST" class="password-form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="input-group col col-sm-7 col-md-6 col-lg-5 mx-auto">
                            @if($user->email=='')
                                <input type="email" name="email" class="form-control" value="{{$user->email}}" placeholder="邮箱" aria-describedby="email-addon" required>
                                <span class="input-group-btn"><input type="submit" class="btn btn-primary" name="email_submit" value="绑定"></span>
                            @else
                                <input type="email" class="form-control" value="@if(!$user->havecheckedemail)[未验证]@endif{{$user->email}}" aria-describedby="email-addon" disabled>
                                <input type="hidden" name="email" class="form-control" value="{{$user->email}}">
                                <span class="input-group-btn"><input type="submit" class="btn btn-warning" name="email_submit" value="解绑"></span>
                            @endif
                        </div>
                    </div>
                </form>
                <br/>
                <div class="row">
                    <div class="col-md-auto mx-auto">
                        @if($user->wechat_open_id=='')
                            <label>微信：扫描二维码或在东大小秘书中点击“更多/先锋市场”链接来关联微信。</label>
                            <img src="/img/wxqr.png" style="height:72px;width:72px">
                        @else
                            <label>微信：已关联 <span class="nickname">{{$user->wechat->nick_name}}</span></label>
                            <img class="head-img mx-auto" src="{{$user->wechat->head_img_url}}" style="height:64px;width:64px">
                        @endif
                    </div>
                </div>
                <br/>
                @if($user->tel=='')
                    <div id="tel-region">
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
                @else
                    <div id="tel-form-input" class="input-group" style="padding-top: 1em;">
                        <span class="input-group-addon" id="tel-addon">(+86)</span>
                        <input type="tel" name="tel" id="tel" class="form-control"
                                value="{{ $user->tel }}" placeholder="手机"
                                aria-describedby="tel-addon" disabled>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-auto ml-auto">
                        <button onclick="window.location.href='/register/4'" class="btn btn-success">下一步</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
            url: "/captcha/sendText",
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
@endsection