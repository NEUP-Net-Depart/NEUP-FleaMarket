<!DOCTYPE HTML>
<html class="no-js" lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/css/foundation.css"/>
    <link rel="stylesheet" href="/css/app.css"/>
    <link rel="stylesheet" href="/css/cropper.min.css"/>
    <link rel="stylesheet" href="/css/froala_editor.min.css">
    <link rel="stylesheet" href="/css/froala_editor.pkgd.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link type="text/css" media="screen" rel="stylesheet" href="/css/responsive-tables.css" />
    @yield('asset')
    <script src="/js/jquery.min.js"></script>
    <script src="/js/vendor/jquery.min.js"></script>
    <script src="/js/vendor/what-input.min.js"></script>
    <script src="/js/vendor/foundation.min.js"></script>
    <script src="/js/cropper.min.js"></script>
    <!--Pop foundation and cropper's old version jQuery-->
    <script type="text/javascript">
        var $jQuery_FOUNDATION = $.noConflict(true);
    </script>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/jquery.slides.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/froala_editor.pkgd.min.js"></script>
    <title>微信登录 - 先锋市场</title>
</head>
<body>
    <div class="content-wrapper row align-middle">
        <div class="small-10 small-push-1 columns card">
            <div class="card-section">
                <form action="/login" method="POST" data-abide novalidate>
                    <center>
                        <img class="head-img" src="{{ $wechat->headImgUrl }}" width="64" height="64"/>
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

    <link rel="stylesheet" href="/css/wechat.css"/>
    @include('layout.footer')
</body>
</html>