<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/cropper.min.css">
        <link rel="stylesheet" href="/css/froala_editor.min.css">
        <link rel="stylesheet" href="/css/froala_editor.pkgd.min.css">
        <link rel="stylesheet" href="/css/main-20170928.css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/popper.min.js"></script>
        <script src="/js/tether.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/cropper.min.js"></script>
        <script src="/js/jquery.slides.min.js"></script>
        <script src="/js/froala_editor.pkgd.min.js"></script>
        <script src="/js/main.js"></script>
        @yield('asset')
        <title>@yield('title') ／ 先锋市场 ／ {{ "爱生活，爱先锋！" }}</title>
    </head>
    <body>
        @include('layout.header')
        <div class="container">
            @yield('content')
        </div>
        @include('layout.footer')
    </body>
</html>
