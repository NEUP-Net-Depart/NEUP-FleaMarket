<div class="navbar-back">
    <div class="navbar-bg"></div>
    <div class="navbar-filter"></div>
</div>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="dropdown">
        <button class="navbar-toggler" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            @if(Session::has('user_id'))
                <a href="/user" class="dropdown-item">
                    <center><img src="/avatar/{{ Session::get('user_id') }}/110/110" class="avatar"/></center>
                    <center><label class="dropdown-header">{{ Session::get('nickname') }}</label></center>
                </a>
                <a href="/logout" class="dropdown-item bg-danger text-light"><center>登出</center></a>
                <div class="dropdown-divider"></div>
                <a href="/user/fav" class="dropdown-item">收藏夹</a>
                <a href="/user/trans" class="dropdown-item">我的购买</a>
                <a href="/user/sell" class="dropdown-item">我的出售</a>
                @if(Session::get('is_admin') >= 1) <a href="/admin" class="dropdown-item">管理中心</a> @endif
                <div class="dropdown-divider"></div>
                <a href="/message" class="dropdown-item">消息 <span style="display:none" class="badge badge-warning message-num-tip">0</span></a>
                <a href="/good/add" class="dropdown-item">出售</a>
            @else
                <a href="/wx" class="dropdown-item bg-success text-light">微信快捷登录</a>
                <a href="/login" class="dropdown-item">普通登录</a>
                <a href="/sso" class="dropdown-item">校卡平台快捷登录</a>
                <div class="dropdown-divider"></div>
                <a href="/register" class="dropdown-item">注册</a>
            @endif
        </div>
    </div>
    <a class="navbar-brand" href="/">先锋市场</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            @if(Session::has('user_id'))
                <li class="nav-item dropdown">
                    <a class="nav-link navbar-avatar nav-btn" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="/avatar/{{ Session::get('user_id') }}/40/40" class="avatar" style="height:40px;width:40px"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <center><label class="dropdown-header">{{ Session::get('nickname') }}</label></center>
                        <a href="/user" class="dropdown-item">个人中心</a>
                        <a href="/user/fav" class="dropdown-item">收藏夹</a>
                        <a href="/user/trans" class="dropdown-item">我的购买</a>
                        <a href="/user/sell" class="dropdown-item">我的出售</a>
                        @if(Session::get('is_admin') >= 1)
                            <a href="/admin" class="dropdown-item">管理中心</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item bg-danger text-light"><center>登出</center></a>
                    </div>
                </li>
                <li class="nav-item"><a href="/message" class="nav-link nav-btn">消息 <span style="display: none" class="badge badge-warning message-num-tip">0</span></a></li>
                <li class="nav-item"><a href="/good/add" class="nav-link nav-btn">出售</a></li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link nav-btn" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">登录</a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a href="/login" class="dropdown-item">普通登录</a>
                    <a href="/sso" class="dropdown-item">校卡平台快捷登录</a>
                    </div>
                </li>
                <li class="nav-item"><a href="/register" class="nav-link nav-btn">注册</a></li>
            @endif
        </ul>
  </div>
</nav>
</div>

<div class="banner-back"><div class="banner"></div></div>

  <p>
  <div class="container d-none d-md-block">
      <form action="/good" method="GET">
        <div class="input-group float-right search-group" style="width:250px">
            <input type="text" class="form-control" name="query" id="searchq" placeholder="开始交易吧( '﹃'⑉)" value="@if(isset($_GET['query'])){{urldecode($_GET['query'])}}@endif">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="G♂">
            </span>
        </div>
      </form>
  </div>
  <div class="d-block d-md-none container">
      <form action="/good" method="GET">
        <div class="input-group float-right search-group">
            <input type="text" class="form-control" name="query" id="searchq" placeholder="开始交易吧( '﹃'⑉)" value="@if(isset($_GET['query'])){{urldecode($_GET['query'])}}@endif">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="G♂">
            </span>
        </div>
      </form>
  </div>
  </p>
@if(Session::has('user_id'))
  <script>
    $(document).ready(function() {
      @if(Request::path() != 'message')
        getMsgNum();
        window.setInterval(function(){getMsgNum()}, 5000)
      @endif
    });
    function getMsgNum()
    {
      $.ajax({
        type: "GET",
        url: "/message/num",
        success: function (msg) {
          msg = parseInt(msg);
          if(msg) {
            $(".navbar-toggler").html("<span class='badge badge-warning message-num-tip'>0</span>");
            $(".navbar-toggler").attr("style", "padding-top:8.5px;padding-bottom:8.5px");
            $(".message-num-tip").removeAttr("style");
            if(msg > 99)
              $(".message-num-tip").html("99+");
            else
              $(".message-num-tip").html(msg);
          } else {
            $(".message-num-tip").attr("style", "display: none;");
          }
        }
      })
    }
  </script>
 @endif
<div class="navbar-back2">
    <div class="navbar-bg2"></div>
    <div class="navbar-filter2"></div>
</div>
<div class="col" style="top:16.5px;overflow:hidden;height:40px">
  <div class="container">
    <ul class="nav nav-pills" style="overflow-x: scroll;overflow-y: hidden;white-space: nowrap;height:58px;display:-webkit-box;display:-moz-box;">
        <li class="nav-item" style="float: none"><a href="/good" class="nav-link @if(isset($cat_id)&&$cat_id == 0) active @endif" style="color:rgba(255,255,255,.75)">所有商品</a></li>
        @foreach($cats as $cat)
            <li class="nav-item" style="float: none"><a href="/good?cat_id={{ $cat->id }}" class="nav-link @if(isset($cat_id)&&$cat_id == $cat->id) active @endif" style="color:rgba(255,255,255,.75)">{{ $cat->cat_name }}</a></li>
        @endforeach
    </ul>
  </div>
</div>