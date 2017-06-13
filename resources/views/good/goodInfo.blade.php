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
        <h2 style="word-break:break-all">
            <span class="hidden-xs">
                @if(isset($inFvlst))
                    @if(count($inFvlst) == 0)
                        <button class="glyphicon glyphicon-star-empty btn btn-primary" onclick="add_favlist()" title="收藏OvO"></button>
                    @endif
                    @if(count($inFvlst) != 0)
                        <button class="glyphicon glyphicon-star btn btn-primary" onclick="del_favlist()" title="取消收藏QAQ"></button>
                    @endif
                @else
                    <button class="glyphicon glyphicon-star-empty btn btn-primary" onclick="window.location.href='/login'" title="收藏OvO"></button>
                @endif
            </span>{{ $good->good_name }}
        </h2>
		卖家：<a href="/user/{{ $user->id }}">{{ $user->nickname }}</a>
        <div><!-- 放tag 和更多图片缩略图 --></div>
        <div>售价：<h3 style="display:inline-block"><b class="text-warning">￥{{ $good->price }}</b></h3></div>
        <div @if($good->count==0) class="text-danger" @endif>@if($good->count>0) 库存：{{ $good->count }}件 @else 没库存了QAQ @endif</div><br/>
        @if (count($errors) > 0)
            <label>
                <span class="form-error is-visible">{!! $errors->first() !!}</span>
            </label>
        @endif
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
            <form action="/good/{{ $good->id }}/edit" style="display:inline-block;" class="hidden-xs">
                <input type="submit" class="btn btn-primary" value="修改">
            </form>
            <form action="/good/{{ $good->id }}/delete" method="POST" style="display:inline-block;" onsubmit="return confirm('确定删除吗？');" class="hidden-xs">
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
    <div class="col-xs-12">
        <h3>商品介绍</h3>
        <div style="word-break:break-all">{{ $good->description }}</div>
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
                    $jQuery_NEW('.glyphicon-star-empty').attr('class','glyphicon glyphicon-star btn btn-primary');
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
                    $jQuery_NEW('.glyphicon-star').attr('class','glyphicon glyphicon-star-empty btn btn-primary');
                }
            });
        }
    </script>
    <form id="fav">
        {!! csrf_field() !!}
    </form>
@endsection

@section('navbm')
    <div class="visible-xs-block col-xs-12" style="position:sticky;bottom:0">
        <div class="pull-left">
            <form style="display:inline-block">
            @if(isset($inFvlst))
                @if(count($inFvlst) == 0)
                    <button class="glyphicon glyphicon-star-empty btn btn-primary" onclick="add_favlist()" href="#" title="收藏OvO"></button>
                @endif
                @if(count($inFvlst) != 0)
                    <button class="glyphicon glyphicon-star btn btn-primary" onclick="del_favlist()" href="#" title="取消收藏QAQ"></button>
                 @endif
            @else
                <button class="glyphicon glyphicon-star-empty btn btn-primary" onclick="window.location.href='/login'" title="收藏OvO"></button>
            @endif
            </form>
        </div>
        <div class="pull-right">
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
        </div>
    </div>
@endsection