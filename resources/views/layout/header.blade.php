<nav class="navbar navbar-toggleable-sm navbar-inverse">
  <div class="navbar-back">
    <div class="navbar-bg"></div>
    <div class="navbar-filter"></div>
  </div>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <a class="navbar-brand" href="/">先锋市场</a>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav ml-auto">
        @if(Session::has('user_id'))
          <li class="nav-item dropdown">
            <a class="nav-link navbar-avatar dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="/avatar/{{ Session::get('user_id') }}/40/40" class="avatar"/>
            </a>
            <div class="dropdown-menu">
              <a href="/user" class="dropdown-item">个人中心</a>
              <a href="/user/fav" class="dropdown-item">收藏夹</a>
              <a href="/user/trans" class="dropdown-item">我的购买</a>
              <a href="/user/sell" class="dropdown-item">我的出售</a>
              @if(Session::get('is_admin') >= 1)
                <a href="/admin" class="dropdown-item">管理中心</a>
              @endif
              <div class="dropdown-divider"></div>
              <a href="/logout" class="dropdown-item">登出</a>
            </div>
          </li>
          <li class="nav-item"><a href="/message" class="nav-link">消息</a></li>
          <li class="nav-item"><a href="/good/add" class="nav-link">出售</a></li>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle navbar-li" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">登录 <span class="caret"></span></a>
            <div class="dropdown-menu">
              <a href="/login" class="dropdown-item">普通登录</a>
              <a href="/sso" class="dropdown-item">校卡平台快捷登录</a>
            </div>
          </li>
          <li class="nav-item"><a href="/register" class="nav-link">注册</a></li>
        @endif
      </ul>
  </div>
</nav>

<div class="banner-back"><div class="banner"></div></div>

<br/>

  <div class="container hidden-sm-down">
      <form action="/good" method="GET">
        <div class="input-group float-right search-group" style="width:250px">
            <input type="text" class="form-control" name="query" id="searchq" placeholder="开始交易吧( '﹃'⑉)" value="@if(isset($_GET['query'])){{urldecode($_GET['query'])}}@endif">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="G♂">
            </span>
        </div>
      </form>
  </div>
  <div class="hidden-md-up container">
      <form action="/good" method="GET">
        <div class="input-group float-right search-group">
            <input type="text" class="form-control" name="query" id="searchq" placeholder="开始交易吧( '﹃'⑉)" value="@if(isset($_GET['query'])){{urldecode($_GET['query'])}}@endif">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="G♂">
            </span>
        </div>
      </form>
  </div>