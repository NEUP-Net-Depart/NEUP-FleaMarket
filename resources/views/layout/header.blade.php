<div class="top-bar">
  <div id="responsive-menu">
    <div class="top-bar-back">
      <div class="top-bar-bg"></div>
      <div class="top-bar-filter"></div>
    </div>
    <div class="row">
      <div class="medium-10 medium-offset-1 columns">
        <div class="top-bar-left">
            <ul class="dropdown menu hide-for-medium" data-dropdown-menu>
              @if(Session::has('user_id'))
                <li><a class="top-bar-list" data-toggle="offCanvas">≡</a></li>
                <li><a class="top-bar-list" href="/">主页</a></li>
                <li><a class="top-bar-list" href="/message">消息</a></li>
              @else
              <li class="is-dropdown-submenu-parent">
                <a class="top-bar-list top-bar-dropdown" href="/login">登录&nbsp;</a>
                <ul class="menu vertical top-bar-dropdown-menu">
                  <li><a href="/login">普通登录</a></li>
                  <li><a href="/register">校卡认证登录(SSO)</a></li>
                </ul>
              </li>
              @endif
            </ul>
          <ul class="dropdown menu hide-for-small-only" data-dropdown-menu>
            <li><a class="top-bar-list" href="/">跳蚤市场</a></li>
          </ul>
        </div>
        <div class="top-bar-right hide-for-small-only">
          <ul class="dropdown menu top-bar-menu" data-dropdown-menu>
            @if(Session::has('user_id'))
              <li>
                <a class="top-bar-avatar" href="/user/{{Session::get('user_id')}}">
                  <img src="/avatar/{{ Session::get('user_id') }}/54/54"/>
                </a>
                <ul class="menu vertical top-bar-dropdown-menu">
                  <li><a href="/user">个人中心</a></li>
                  <li><a href="/user/fav">收藏夹</a></li>
                  <hr>
                  <li><a href="/logout">登出</a></li>
                </ul>
              </li>
              <li><a class="top-bar-list" href="/message">消息</a></li>
              <li><a href="/good/add" class="top-bar-button">出售</a></li>
            @else
              <li class="is-dropdown-submenu-parent">
                <a class="top-bar-list top-bar-dropdown" href="/login">登录&nbsp;</a>
                <ul class="menu vertical top-bar-dropdown-menu">
                  <li><a href="/login">普通登录</a></li>
                  <li><a href="/register">校卡认证登录(SSO)</a></li>
                </ul>
              </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="banner-back">
    <div class="banner">
    </div>
</div>
<div class="row search-bar hide-for-small-only">
  <div class="medium-10 medium-centered columns">
    <div class="medium-12 columns">
      <form action="/good" method="GET">
        <div class="input-group float-right" id="top-bar-quick-access">
            <input class="input-group-field" type="search" name="query" id="searchq" placeholder="开始交易吧( '﹃'⑉)" value="<?php if(isset($_GET['query'])){echo $_GET['query']; } ?>"/>
            <div class="input-group-button">
                <input type="submit" class="button" value="G♂"/>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row search-bar hide-for-medium">
  <div class="medium-10 medium-centered columns">
      <form action="/good" method="GET">
        <div class="input-group float-right" id="top-bar-quick-access-small">
            <input class="input-group-field" type="search" name="query" id="searchq" placeholder="开始交易吧( '﹃'⑉)" value="<?php if(isset($_GET['query'])){echo $_GET['query']; } ?>"/>
            <div class="input-group-button">
                <input type="submit" class="button" value="G♂"/>
            </div>
        </div>
      </form>
  </div>
</div>
<div class="off-canvas position-left" id="offCanvas" data-off-canvas>
    <ul class="vertical menu">
        @if(Session::has('user_id'))
          <li><a href="/user/{{Session::get('user_id')}}"><img src="/avatar/{{ Session::get('user_id') }}/220/220"/><br/><br/>个人中心</a></li>
          <li><a href="/logout">登出</a></li>
          <hr>
          <li><a href="/user/fav">收藏夹</a></li>
          <li><a href="/good/add" class="top-bar-button">出售</a></li>
        @else
            <li><a href="/register">注册</a></li>
            <li><a href="/login">登录</a></li>
        @endif
    </ul>

</div>