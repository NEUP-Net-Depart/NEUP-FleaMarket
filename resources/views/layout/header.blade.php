<nav class="navbar navbar-inverse">
  <div class="navbar-back">
    <div class="navbar-bg"></div>
    <div class="navbar-filter"></div>
  </div>
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand navbar-li" href="/">首页</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        @if(Session::has('user_id'))
          <li class="dropdown">
            <a class="navbar-avatar dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="/avatar/{{ Session::get('user_id') }}/50/50" class="avatar"/>
            </a>
            <ul class="dropdown-menu">
              <li><a href="/user">个人中心</a></li>
              <li><a href="/user/fav">收藏夹</a></li>
              <li><a href="/user/trans">我的购买</a></li>
              <li><a href="/user/sell">我的出售</a></li>
              @if(Session::get('is_admin') >= 1)
                <li><a href="/admin">管理中心</a></li>
              @endif
              <li role="separator" class="divider"></li>
              <li><a href="/logout">登出</a></li>
            </ul>
          </li>
          <li><a href="/message" class="navbar-li">消息</a></li>
          <li><a href="/good/add" class="navbar-li">出售</a></li>
        @else
          <li class="dropdown">
            <a class="dropdown-toggle navbar-li" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">登录 <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/login">普通登录</a></li>
              <li><a href="/sso">校卡平台快捷登录</a></li>
            </ul>
          </li>
          <li><a href="/register" class="navbar-li">注册</a></li>
        @endif
  </div>
</nav>

<div class="banner-back"><div class="banner"></div></div>

<div class="container">
  <div class="col-md-12 navbar-search pull-right">
      <form action="/good" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" name="query" id="searchq" placeholder="开始交易吧( '﹃'⑉)" value="@if(isset($_GET['query'])){{ $_GET['query'] }}@endif"/>
            <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="G♂"/>
            </span>
        </div>
      </form>
  </div>
</div>
