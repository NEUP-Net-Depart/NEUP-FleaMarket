<div class="top-bar">
  <div id="responsive-menu">
    <div class="top-bar-back">
        <div class="top-bar-bg"></div>
        <div class="top-bar-filter"></div>
    </div>
    <div class="top-bar-left">
      <ul class="dropdown menu" data-dropdown-menu>
        <li><a href="/good">商品</a></li>
      </ul>
    </div>
    <div class="top-bar-right">
      <ul class="dropdown menu" data-dropdown-menu>
        @if(Session::has('user_id'))
        <li><a href="/user/{{Session::get('user_id')}}">{{Session::get('nickname')}}@if(Session::get('nickname')=="") {{Session::get('username')}} @endif</a></li>
        <li><a href="#">消息</a></li>
        <li><a href="#">收藏夹</a></li>
        <li><a href="/good/add" class="button">出售</a></li>
        @else
        <li><a href="/register">注册</a></li>
        <li><a href="/login">登录</a></li>
        @endif
      </ul>
    </div>
  </div>
</div>
<div class="row banner">
    <div class="banner-content">
        <div class="row">
            <div class="small-2 columns">　</div>
            <div class="small-1 columns"><a href="/"><img src="/img/logo.png" class="banner-logo"></img></a></div>
            @include('layout.search')
            <div class="small-3 columns">　</div>
        </div>
    </div>
</div>