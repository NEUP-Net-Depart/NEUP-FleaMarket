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
    <div class="top-bar-left show-for-medium-only show-for-small-only">
    </div>
    <div class="top-bar-left">
      <ul class="dropdown menu hide-for-medium-only hide-for-small-only" data-dropdown-menu>
        <li><a class="top-bar-list" href="/">首页</a></li>
        <li><a class="top-bar-list" href="/good">市场</a></li>
      </ul>
    </div>
    <div class="top-bar-right">
      <ul class="dropdown menu hide-for-small-only" data-dropdown-menu>
        @if(Session::has('user_id'))
        @if(Session::has('is_admin'))
        <li><a class="top-bar-list" href="/admin">管理员页面</a></li>
        @endif
        <li><a class="top-bar-list" id="top-bar-avatar" href="/user/{{Session::get('user_id')}}"><img src="/avatar/{{ Session::get('user_id') }}/54/54"></img></a></li>
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
