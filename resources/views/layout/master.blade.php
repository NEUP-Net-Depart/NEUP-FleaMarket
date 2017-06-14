<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/cropper.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/cropper.min.js"></script>
    @yield('asset')
    <!--Pop foundation and cropper's old version jQuery-->
    <script type="text/javascript">
        var $jQuery_CROPPER = $.noConflict(true);
    </script>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/jquery.slides.min.js"></script>
    <script src="/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <title>@yield('title') - 先锋市场 Powered by NEUPioneer</title>
</head>
<body>
@include('layout.header')
<div class="page-content container">
    @yield('content')
</div>
@yield('navbm')
@include('layout.footer')
</body>
</html>