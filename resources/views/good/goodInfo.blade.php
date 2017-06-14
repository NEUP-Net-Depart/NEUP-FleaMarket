@extends('layout.master')

@section('title', "商品详情")

@section('asset')
    <link rel="stylesheet" href="/css/lrtk.css"/>
    <style>
        .input-group:not(.search-group) {
            max-width: 200px;
        }
    </style>
@endsection

@section('content')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <div class="row">
    <div class="col-12 col-md-5">
        <a id="pic" href="/good/{{ sha1($good->id) }}/titlepic"><img class="card" src="/good/{{ sha1($good->id) }}/titlepic" style="width:100%"/></a><br/>
    </div>
    <div class="col-12 col-md-7">
        <div>
            <span class="hidden-sm-down" style="position:relative;top:-8px">
                @if(isset($inFvlst))
                    @if(count($inFvlst) == 0)
                        <button class="fa fa-star-o btn btn-primary" onclick="add_favlist()" data-toggle="tooltip" data-placement="top" title="收藏OvO"></button>
                    @endif
                    @if(count($inFvlst) != 0)
                        <button class="fa fa-star btn btn-primary" onclick="del_favlist()" data-toggle="tooltip" data-placement="top" title="取消收藏QAQ"></button>
                    @endif
                @else
                    <button class="fa fa-star-o btn btn-primary" onclick="window.location.href='/login'" data-toggle="tooltip" data-placement="top" title="收藏OvO"></button>
                @endif
            </span>
            <h2 style="margin-left:10px;display:inline-block;word-break:break-all">{{ $good->good_name }}@if($good->baned)【已封禁】@endif</h2>
        </div>
		卖家：<a href="/user/{{ $user->id }}">{{ $user->nickname }}@if($user->baned)【已封禁】@endif</a> &nbsp; <a href="/message/startConversation/{{ $user->id }}">和我联系</a>
        <div><!-- 放tag 和更多图片缩略图 --></div>
        <div>售价：<h3 style="display:inline-block"><b class="text-warning">￥{{ $good->price }}</b></h3></div>
        <div @if($good->count==0) class="text-danger" @endif>@if($good->count>0) 库存：{{ $good->count }}件 @else 没库存了QAQ @endif</div><br/>
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
        @if(($good->user_id) != Session::get('user_id') && !$good->baned)
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
            <form action="/good/{{ $good->id }}/edit" style="display:inline-block;" class="hidden-sm-down">
                <input type="submit" class="btn btn-primary" value="修改">
            </form>
            <form action="/good/{{ $good->id }}/delete" method="POST" style="display:inline-block;" onsubmit="return confirm('确定删除吗？');" class="hidden-sm-down">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <input type="submit" class="btn btn-primary" value="删除">
            </form>
        @endif
        @if(Session::get('is_admin') >= 1 && !$good->baned)
            <form action="/good/{{ $good->id }}/ban" method="POST" style="display:inline-block;">
                {!! csrf_field() !!}
                <input type="submit" class="btn btn-primary" value="封禁">
            </form>
        @endif
    </div>
    </div>
    <br/>
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
                    $('.fa-star-o').attr('title','取消收藏QAQ');
                    $('.fa-star-o').attr('onclick', 'del_favlist()');
                    $('.fa-star-o').attr('class','fa fa-star btn btn-primary');
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
                    $('.fa-star').attr('title','收藏OvO');
                    $('.fa-star').attr('onclick', 'add_favlist()');
                    $('.fa-star').attr('class','fa fa-star-o btn btn-primary');
                }
            });
        }
    </script>
    <form id="fav">
        {!! csrf_field() !!}
    </form>
@endsection

@section('navbm')
    <div class="hidden-md-up col-12" style="position:sticky;bottom:37px">
        <div class="float-left">
            @if(isset($inFvlst))
                @if(count($inFvlst) == 0)
                    <button class="fa fa-star-o btn btn-primary" onclick="add_favlist()" href="#" title="收藏OvO" style="position:relative;top:4px"></button>
                @endif
                @if(count($inFvlst) != 0)
                    <button class="fa fa-star btn btn-primary" onclick="del_favlist()" href="#" title="取消收藏QAQ"></button>
                 @endif
            @else
                <button class="fa fa-star-o btn btn-primary" onclick="window.location.href='/login'" title="收藏OvO"></button>
            @endif
        </div>
        <div class="float-right">
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