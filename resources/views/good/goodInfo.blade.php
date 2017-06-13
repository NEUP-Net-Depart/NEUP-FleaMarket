@extends('layout.master')

@section('title', "商品详情")

@section('asset')
    <link rel="stylesheet" href="/css/lrtk.css"/>
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

	<div class="row">
        <div class="small-12 medium-5 columns block" style="">
            <a id="pic" href="/good/{{ sha1($good->id) }}/titlepic"><img alt="" class="thumbnail" src="/good/{{ sha1($good->id) }}/titlepic"/></a>
        </div>
        <div class="small-12 medium-6 medium-offset-1 columns block"
             style="background-color: white;margin-bottom: 10px;margin-top:10px">
            <h2>
                {{ $good->good_name }}
            <span class="hide-for-small-only">
            @if(isset($inFvlst))
                @if(count($inFvlst) == 0)
                    <a class="fav_smt fav_smt-medium" onclick="add_favlist()">☆</a>
                @endif
                @if(count($inFvlst) != 0)
                    <a class="fav_smt fav_smt-medium" onclick="del_favlist()">★</a>
                @endif
            @else
                <a class="fav_smt fav_smt-medium" onclick="window.location.href='/login'">☆</a>
            @endif
            </span>
            </h2>
            <div><!-- 放tag 和更多图片缩略图 --></div>
            货主：<a href="/user/{{ $user->id }}">{{ $user->nickname }}</a> &nbsp; <a href="/message/startConversation/{{ $user->id }}">和我联系</a>
            <h4 style="color: #cc4b37"><b>￥{{ $good->price }}</b></h4>
            @if (count($errors) > 0)
                <label>
                    <span class="form-error is-visible">{!! $errors->first() !!}</span>
                </label>
            @endif
            <div class="row">
                <div class="columns hide-for-small-only" style="width:180px;">
                    @if(($good->user_id) != Session::get('user_id'))
                        <form action="/good/{{ $good->id }}/buy" method="post">
                            <div class="input-group gb_right">
                                <input type="number" name="count" value="1" class="input-group-field"/>
                                {!! csrf_field() !!}
                                <div class="input-group-button">
                                    <input type="submit" class="button" value="购买"/>
                                </div>
                            </div>
                        </form>
                    @endif
                    <p id="ach" class="gb_right">(库存:{{ $good->count }}件)</p>
                    @if($good->user_id == Session::get('user_id') || Session::get('is_admin') == 2)
                        <form class="hide-for-small-only" action="/good/{{ $good->id }}/edit"
                              style="margin:0px;display:inline;">
                            <input type="submit" class="button gb_right" value="修改">
                        </form>
                        <form class="hide-for-small-only" action="/good/{{ $good->id }}/delete" method="POST"
                              style="margin:0px;display:inline;" id="del" onsubmit="return confirm('确定删除吗？');">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="submit" class="button gb_right" value="删除">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row hide-for-small-only">
        <div class="small-12 medium-6 medium-offset-6 columns block">
        </div>
    </div>
    <div class="row">
        <div id="asd" class="small-12 medium-12 columns" style="background-color: white">
            <h3>商品介绍: </h3>
            <p>{{ $good->description }}</p>
        </div>

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
                    $('.fav_smt.fav_smt-small').val('取消收藏QAQ');
                    $jQuery_NEW('.fav_smt.fav_smt-small').attr('onclick', 'del_favlist()');
                    //what's this? interesting
                    $jQuery_NEW('.fav_smt.fav_smt-small').attr('style', 'width:100%;color:white;padding-left:0;padding-right:0');
                    $('.fav_smt.fav_smt-medium').text('★');
                    $jQuery_NEW('.fav_smt.fav_smt-medium').attr('onclick', 'del_favlist()');
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
                    $('.fav_smt.fav_smt-small').val('收藏OvO');
                    $jQuery_NEW('.fav_smt.fav_smt-small').attr('onclick', 'add_favlist()');
                    $('.fav_smt.fav_smt-medium').text('☆');
                    $jQuery_NEW('.fav_smt.fav_smt-medium').attr('onclick', 'add_favlist()');
                }
            });
        }
    </script>

@endsection

@section('navbm')
    <div class="row">
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
                                        style="color:white;font-size: 15px;width:100%;height:40px;padding-left:0;padding-right:0;" onclick="window.location.href='/message/startConversation/{{ $user->id }}'">
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
