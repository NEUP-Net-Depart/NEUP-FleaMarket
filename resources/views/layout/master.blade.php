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
    <link rel="stylesheet" href="/css/froala_editor.min.css">
    <link rel="stylesheet" href="/css/froala_editor.pkgd.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/tether.min.js"></script>
    <script src="/js/cropper.min.js"></script>
    <script src="/js/jquery.slides.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/froala_editor.pkgd.min.js"></script>
    <script>
        var match_media;
        function WidthChange(mq) {
        }
    </script>
    @yield('asset')
    <script>
        $(document).ready(function() {
            if (match_media === undefined) match_media = "(min-width:768px)";
            if (matchMedia) {
                var mq = window.matchMedia(match_media);
                mq.addListener(WidthChange);
                WidthChange(mq);
            }
            $('.load-part').attr('style','display:block');
        });
    </script>
    <title>@yield('title') - 先锋市场 Powered by NEUPioneer</title>
</head>
<body>
@include('layout.header')
<div class="load-part" style="display:none">
<div class="page-content container">
    @yield('content')
</div>
@yield('navbm')
@include('layout.footer')
</div>
</body>
</html>
