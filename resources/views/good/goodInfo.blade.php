@extends('layout.master')

@section('title', "商品详情")

@section('asset')
    <link rel="stylesheet" href="/css/lrtk.css" />
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
            if($(document.body).width()>640) {
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
        <div class="small-12 medium-5 columns block" style="background-color: white;">
            <a id="pic" href="/good/{{ sha1($good->id) }}/titlepic"><img alt="" class="thumbnail" src="/good/{{ sha1($good->id) }}/titlepic" /></a>
        </div>
        <div class="small-12 medium-6 medium-offset-1 columns block" style="background-color: white;margin-bottom: 10px;margin-top:10px">
            <h2>{{ $good->good_name }}</h2>
            <div><!-- 放tag 和更多图片缩略图 --></div>
            <h4 style="color: #cc4b37"><b>￥{{ $good->price }}</b></h4>
            <div class="row">
                <div class="small-5 columns">
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
                            <br>
                            <br>
                            @if($good->user_id == Session::get('user_id') || Session::get('is_admin') == 2)
                                <form class="hide-for-small-only" action="/good/{{ $good->id }}/edit" style="margin:0px;display:inline;">
                                    <input type="submit" class="button gb_right" value="修改">
                                </form>
                                <form class="hide-for-small-only" action="/good/{{ $good->id }}/delete" method="POST" style="margin:0px;display:inline;" id="del" onsubmit="return confirm('确定删除吗？');">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <input type="submit" class="button gb_right" value="删除">
                                </form>
                    @endif
                        <p id="ach" class="gb_right">(库存:{{ $good->count }}件)</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row hide-for-small-only">
        <div class="small-12 medium-6 medium-offset-6 columns block">
            @if(isset($inFvlst))
                <form id="fav">
                    {!! csrf_field() !!}
                    @if(count($inFvlst) == 0)
                        <input id="fav_smt" class="button" type="button" name="submit1" onclick="add_favlist()"
                               value="收藏OvO"/>
                    @endif
                    @if(count($inFvlst) != 0)
                        <input id="fav_smt" class="button" type="button" name="submit1" onclick="del_favlist()"
                               value="取消收藏QAQ"/>
                    @endif
                </form>
            @else
                <input class="button" type="button" name="submit1" onclick="window.location.href='/login'"
                       value="收藏OvO"/>
            @endif
        </div>
    </div>

    <div class="row">
        <div id="" class="small-12 medium-12 columns" style="background-color: white">
            <h3>商品介绍: </h3>
            <p>{{ $good->description }}</p>
        </div>

    </div>
<div id="das"></div>
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
                    $('.fav_smt').val('取消收藏QAQ');
                    $jQuery_NEW('.fav_smt').attr('onclick', 'del_favlist()');
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
                    $('.fav_smt').val('收藏OvO');
                    $jQuery_NEW('.fav_smt').attr('onclick', 'add_favlist()');
                }
            });
        }
    </script>

@endsection

@section('navbm')
    <div class="row show-for-small-only" style="max-width: 100%;" data-sticky-container>
        <div class="sticky" data-sticky data-stick-to="bottom" data-sticky-on="small" data-top-anchor="ach" data-btm-anchor="desc:top" data-options="marginBottom:0;" >
            <div class="top-bar">
                    <ul class="menu"  style="position:relative; bottom: -5px;height:100%;">
                        <li><button class="button warning" style="color:white;font-size: 13px;width:90px;height:40px">联系货主</button></li>
                        <li><button class="button warning" style="color:white;font-size: 13px;width:90px;height:40px">功能占位</button></li>
                        @if(($good->user_id) != Session::get('user_id'))
                            <li> <form action="/good/{{ $good->id }}/buy" method="post"  style="width:70%;float:right" >
                                    <div class="input-group" style="margin-bottom:0px;">
                                        <input type="number" name="count" value="1" class="input-group-field"/>
                                        {!! csrf_field() !!}
                                        <div class="input-group-button">
                                            <input type="submit" class="button" value="购买"/>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        @endif
                        @if($good->user_id == Session::get('user_id') || Session::get('is_admin') == 2)
                            <li><button class="button warning" style="color:white;font-size: 13px;width:90px;height:40px">功能占位</button></li>
                            <li>
                                <form action="/good/{{ $good->id }}/edit">
                                    <input type="submit" style="margin-right:0;" class="button" value="修改">
                                </form>
                            </li>
                            <li>
                                <form action="/good/{{ $good->id }}/delete" method="POST" id="del" onsubmit="return confirm('确定删除吗？');">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <input type="submit" style="margin-right:0" class="button" value="删除">
                                </form>
                            </li>
                        @endif
                        <li> @if(isset($inFvlst))
                                <form id="fav" style="">
                                    {!! csrf_field() !!}
                                    @if(count($inFvlst) == 0)
                                        <input id="fav_smt" class="button fav_smt" type="button" name="submit1" onclick="add_favlist()"
                                               value="收藏OvO" style="width:122px;"/>
                                    @endif
                                    @if(count($inFvlst) != 0)
                                        <input id="fav_smt" class="button fav_smt" type="button" name="submit1" onclick="del_favlist()"
                                               value="取消收藏QAQ"  style="width:122px;"/>
                                    @endif
                                </form>
                            @else
                                <input class="button" type="button" name="submit1" onclick="window.location.href='/login'"
                                       value="收藏OvO"/>
                            @endif</li>
                    </ul>
            </div>
        </div>
    </div>
@endsection