<!DOCTYPE HTML>
<html class="no-js" lang="zh">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Compressed CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css"
        integrity="sha256-itWEYdFWzZPBG78bJOOiQIn06QCgN/F0wMDcC4nOhxY=" crossorigin="anonymous" />

  <link rel="stylesheet" href="/css/font-awesome.min.css">
  <link rel="stylesheet" href="/css/wechat.css" />
  <!-- Compressed JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js"
          integrity="sha256-Nd2xznOkrE9HkrAMi4xWy/hXkQraXioBg9iYsBrcFrs=" crossorigin="anonymous"></script>
  <title>微信登录 - 先锋市场</title>
</head>
<body>
<div class="content-wrapper row align-middle">
  <div class="small-10 small-push-1 columns card">
    <div class="card-section">
      <form action="/login" method="POST" data-abide novalidate>
        <center>
          <img class="head-img" src="{{ $wechat->headImgUrl }}" width="64" height="64" />
        </center>
        <p>您正在使用微信账号 <span class="nickname">{{ $wechat->nickName }}</span> 登录先锋市场，要绑定此账号，点击下面的按钮继续。</p>
        <div class="row">
          <a type="submit" class="expanded hollow button" href="/login">我已有账号</a>
        </div>
        <div class="row">
          <a href="/sso" style="float: right" class="expanded button small-centered" href="/sso">校园卡认证注册</a>
        </div>
      </form>
    </div>
  </div>
</div>

<footer class="row hide-for-small-only">
  <div class="medium-9 medium-centered columns">
    <div class="float-left">
      <span>© {{date("Y")}} 东北大学先锋网</span>
      <span><a href="/pp">隐私政策</a></span>
      <span><a href="/tos">服务条款</a></span>
    </div>
    <div class="float-right">
      <span><a href="/faq">帮助文档</a></span>
      <span><a href="/">申诉通道</a></span>
      <span><a href="/">意见反馈</a></span>
      <span><a href="/">关于我们</a></span>
    </div>
  </div>
</footer>
<footer class="row hide-for-medium">
  <div class="small-11 small-centered columns">
    <span><center>© {{date("Y")}} 东北大学先锋网</center></span>
  </div>
</footer>
@if( env('SHOW_VER') || env('APP_DEBUG') )
  <footer class="row">
    <div class="small-11 small-centered columns">
		<span>
			<center>
				@if(env('APP_DEBUG'))当前处于调试模式<br>@endif
        @if(env('SHOW_VER'))程序版本：{{ config('app.version')       }}&nbsp;&nbsp; 文件版本：<a
          href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket/commit/{{ explode(' ', exec('git log --pretty=oneline -1'))[0]   }}">{{ exec('git log --abbrev-commit --pretty=oneline -1')  }}</a>
        @endif
            </center>
		</span>
    </div>
  </footer>
@endif
</body>
</html>