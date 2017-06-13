@extends('layout.master')

@section('title', "商品详情")

@section('asset')
    <link rel="stylesheet" href="/css/lrtk.css"/>
    <style>
        .input-group {
            max-width: 200px;
        }
    </style>
@endsection

@section('content')
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        var $jQuery_NEW = $.noConflict(true);
    </script>
    <!--Pop new version of jQuery and 向黑恶势力低头-->
    <script src="https://cdn.bootcss.com/jquery/1.3.1/jquery.min.js"></script>
    <script src="/js/good/imgbox/jquery.imgbox.pack.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($(document.body).width() > 640) {
                $("#pic").imgbox({
                    'speedIn': 0,
                    'speedOut': 0,
                    'alignment': 'center',
                    'overlayShow': true,
                    'allowMultiple': false
                });
            }
        });
    </script>
    <div class="col-xs-12 col-sm-5">
        <a id="pic" href="/good/{{ sha1($good->id) }}/titlepic"><img class="thumbnail" src="/good/{{ sha1($good->id) }}/titlepic" style="width:100%"/></a>
    </div>
    <div class="col-xs-12 col-sm-6 col-sm-offset-1">
        <h2>{{ $good->good_name }}
            <span>
                @if(isset($inFvlst))
                    @if(count($inFvlst) == 0)
                        <a class="glyphicon glyphicon-star-empty" onclick="add_favlist()" href="#" title="收藏OvO"></a>
                    @endif
                    @if(count($inFvlst) != 0)
                        <a class="glyphicon glyphicon-star" onclick="del_favlist()" href="#" title="取消收藏QAQ"></a>
                    @endif
                    @else
                        <a class="glyphicon glyphicon-star-empty" onclick="window.location.href='/login'" title="收藏OvO">☆</a>
                    @endif
            </span>
        </h2>
		卖家：<a href="/user/{{ $user->id }}">{{ $user->nickname }}</a>
        <div><!-- 放tag 和更多图片缩略图 --></div>
        <div>售价：<h3 style="display:inline-block"><b class="text-warning">￥{{ $good->price }}</b></h3></div>
        <div @if($good->count==0) class="text-danger" @endif>@if($good->count>0) 库存：{{ $good->count }}件 @else 没库存了QAQ @endif</div><br/>
        @if(($good->user_id) != Session::get('user_id'))
            <form action="/good/{{ $good->id }}/buy" method="post">
                <div class="input-group">
                    <input type="number" name="count" value="1" class="form-control"/>
                    {!! csrf_field() !!}
                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-primary" value="购买"/>
                    </span>
                </div>
            </form>
        @endif
        @if($good->user_id == Session::get('user_id') || Session::get('is_admin') == 2)
            <form action="/good/{{ $good->id }}/edit" style="display:inline-block;">
                <input type="submit" class="btn btn-primary" value="修改">
            </form>
            <form action="/good/{{ $good->id }}/delete" method="POST" style="display:inline-block;" onsubmit="return confirm('确定删除吗？');">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <input type="submit" class="btn btn-primary" value="删除">
            </form>
        @endif
		@if(Session::has('user_id') && $good->user_id!=Session::get('user_id'))
			<br/><form action="/report/{{ $good->user_id }}" method="GET">
				<input type="submit" class="btn btn-primary" value="举报该卖家">
			</form>
		@endif
    </div>
    <div class="col-xs-12 row">
        <h3>商品介绍</h3>
        <div>{{ $good->description }}</div>
    </div>
    <script>
        function add_favlist() {
            var str_data = $("#fav input").map(function () {
                return ($(this).attr("name") + '=' + $(this).val());
            }).get().join("&");
            $.ajax({
                type: "POST",
                url: "/good/{{ $good->id }}/add_favlist",
                data: str_data,
                success: function (msg) {
                    $jQuery_NEW('.glyphicon-star-empty').attr('title','取消收藏QAQ');
                    $jQuery_NEW('.glyphicon-star-empty').attr('onclick', 'del_favlist()');
                    $jQuery_NEW('.glyphicon-star-empty').attr('class','glyphicon glyphicon-star');
                }
            });
        }
        function del_favlist() {
            var str_data1 = $("#fav input").map(function () {
                return ($(this).attr("name") + '=' + $(this).val());
            }).get().join("&");
            var str_data = str_data1 + '&_method=DELETE';
            $.ajax({
                type: "POST",
                url: "/good/{{ $good->id }}/del_favlist",
                data: str_data,
                success: function (msg) {
                    $jQuery_NEW('.glyphicon-star').attr('title','收藏OvO');
                    $jQuery_NEW('.glyphicon-star').attr('onclick', 'add_favlist()');
                    $jQuery_NEW('.glyphicon-star').attr('class','glyphicon glyphicon-star-empty');
                }
            });
        }
    </script>

@endsection

@section('navbm')
    <div class="row hidden">
        <div class="row show-for-small-only" style="max-width: 100%;background-color: transparent;"
             data-sticky-container>
            <div class="sticky" data-sticky data-stick-to="bottom" data-sticky-on="small" data-top-anchor="pic"
                 data-btm-anchor="desc:bottom" {{-- malfunction --}}
                 data-options="marginBottom:0;">
                <div class="top-bar" style="background-color: transparent;padding:0">
                    <ul class="menu" style="position:relative;height:100%;background-color: transparent;left:+10px;">
                        @if(($good->user_id) != Session::get('user_id'))
                            <li style="width:25%">
                                <button class="button warning"
                                        style="color:white;font-size: 15px;width:100%;height:40px;padding-left:0;padding-right:0;">
                                    联系货主
                                </button>
                            </li>
                            <li style="width:50%">
                                <form action="/good/{{ $good->id }}/buy" method="post" style="width: 100%">
                                    <div class="input-group" style="margin-bottom:0px;width: 100%">
                                        <input type="number" name="count" value="1" class="input-group-field"/>
                                        {!! csrf_field() !!}
                                        <div class="input-group-button">
                                            <input type="submit" style="width: 100%;" class="button" value="购买"/>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        @endif
                        @if($good->user_id == Session::get('user_id'))
                            <li style="width:20%;height:100%">
                                <button class="button"
                                        style="color:white;font-size: 15px;width:100%;height:40px;padding-left:0;padding-right:0">
                                    宣传商品
                                </button>
                            </li>
                            <li style="width:10%;">
                                <form action="/good/{{ $good->id }}/edit">
                                    <input type="submit" class="button warning"
                                           style="width:100%;float:right;margin-right:0;color:white;height:100%"
                                           class="button" value="修改">
                                </form>
                            </li>
                        @endif
                        @if($good->user_id == Session::get('user_id') ||  Session::get('is_admin') > 1)
                            <li style="width:10%;">
                                <form action="/good/{{ $good->id }}/delete" method="POST" id="del"
                                      onsubmit="return confirm('确定删除吗？');">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <input type="submit" style="width:100%;height:100%" class="button" value="删除">
                                </form>
                            </li>
                        @endif
                        <li style="width:25%;"> @if(isset($inFvlst))
                                <form id="fav" style="color:white">
                                    {!! csrf_field() !!}
                                    @if(count($inFvlst) == 0)
                                        <input class="button fav_smt fav_smt-small warning" type="button" name="submit1"
                                               onclick="add_favlist()"
                                               value="收藏OvO"
                                               style="width:100%;color:white;height:40px;padding:0;margin-right:0"/>
                                    @endif
                                    @if(count($inFvlst) != 0)
                                        <input class="button fav_smt fav_smt-small warning" type="button" name="submit1"
                                               onclick="del_favlist()"
                                               value="取消收藏QAQ"
                                               style="width:100%;color:white;height:40px;padding:0;margin-right:0"/>
                                    @endif
                                </form>
                            @else
                                <input class="button warning" type="button" name="submit1"
                                       onclick="window.location.href='/login'"
                                       value="收藏OvO"
                                       style="width:100%;color:white;height:40px;padding:0;margin-right:0"/>
                            @endif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
