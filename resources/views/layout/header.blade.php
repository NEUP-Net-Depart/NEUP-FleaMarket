</head>
<body>
<div class="top-bar">
  <div id="responsive-menu">
    <div class="top-bar-back">
        <div class="top-bar-bg"></div>
        <div class="top-bar-filter"></div>
    </div>
    <div class="row">
    <div class="medium-10 medium-offset-1 columns">
    <div class="top-bar-left">
      <ul class="dropdown menu" data-dropdown-menu>
        <li><a class="top-bar-list" href="/">首页</a></li>
        <li><a class="top-bar-list" href="/good">市场</a></li>
      </ul>
    </div>
    <div class="top-bar-right">
      <ul class="dropdown menu" data-dropdown-menu>
        @if(Session::has('user_id'))
        <li><a class="top-bar-list" href="/user/{{Session::get('user_id')}}">{{Session::get('nickname')}}@if(Session::get('nickname')=="") {{Session::get('username')}} @endif</a></li>
        <li><a class="top-bar-list" href="/message">消息</a></li>
        <li><a class="top-bar-list" href="/user/get_favlist">收藏夹</a></li>
        <li><a href="/good/add" class="button">出售</a></li>
        @else
        <li><a class="top-bar-list" href="/register">注册</a></li>
        <li><a class="top-bar-list" href="/login">登录</a></li>
        @endif
      </ul>
    </div>
    </div>
    </div>
  </div>
</div>
<div class="banner">
</div>
<div class="row">
<div class="medium-10 medium-centered columns">
@include('layout.search')
</div>
</div>
<div class="page-content row">
<div class="medium-10 medium-centered columns">
