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
                <li><a class="top-bar-list" href="/">这可是只有手机才能看得到的</a></li>
            </ul>
          <ul class="dropdown menu hide-for-small-only" data-dropdown-menu>
            <li><a class="top-bar-list" href="/">首页</a></li>
            <li><a class="top-bar-list" href="/good">市场</a></li>
          </ul>
        </div>
        <div class="top-bar-right hide-for-small-only">
          <ul class="dropdown menu hide-for-small-only top-bar-menu" data-dropdown-menu>
            @if(Session::has('user_id'))
              <li><a class="top-bar-avatar" href="/user/{{Session::get('user_id')}}"><img src="/avatar/{{ Session::get('user_id') }}/54/54"/></a></li>
              <li><a class="top-bar-list" href="/message">消息</a></li>
              <li><a class="top-bar-list" href="/good/my">我的商品</a></li>
              <li><a href="/good/add" class="top-bar-button">出售</a></li>
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
<div class="banner-back">
    <div class="banner">
    </div>
</div>
<div class="row search-bar">
  <div class="medium-10 medium-centered columns">
    @include('layout.search')
  </div>
</div>