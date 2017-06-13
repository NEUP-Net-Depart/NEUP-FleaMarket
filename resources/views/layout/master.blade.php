<!DOCTYPE HTML>
<html class="no-js" lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/css/foundation.css"/>
    <link rel="stylesheet" href="/css/app.css"/>
    <link rel="stylesheet" href="/css/cropper.min.css"/>
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
    <title>@yield('title') - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content row">
    <div class="columns">
        @yield('content')
    </div>
</div>
@yield('navbm')
@include('layout.footer')
</body>
</html>