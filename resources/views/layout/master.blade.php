<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/cropper.min.css">
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/tether.min.js"></script>
    <script src="/js/cropper.min.js"></script>
    <script src="/js/jquery.slides.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    @yield('asset')
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