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
            $("#pic").imgbox({
                'speedIn'		: 0,
                'speedOut'		: 0,
                'alignment'		: 'center',
                'overlayShow'	: true,
                'allowMultiple'	: false
            });
        });
    </script>

    <div class="row">
        <div class="small-12 medium-5 columns thumbnail">
            <a id="pic" title="<br/>" href="/good/{{ sha1($good->id) }}/titlepic"><img alt="" src="/good/{{ sha1($good->id) }}/titlepic" /></a>
        </div>
        <div class="small-12 medium-6 medium-offset-1 columns">
            <h1>{{ $good->good_name }}</h1>
            <div><!-- 放tag 和更多图片缩略图 --></div>
            <h4 style="color: #cc4b37"><b>￥{{ $good->price }}</b></h4>
            <div class="row">
                <div class="small-5 columns">
                    @if(($good->user_id) != Session::get('user_id'))
                        <form action="/good/{{ $good->id }}/buy" method="post">
                            <div class="input-group">
                                <input type="number" name="count" value="1" class="input-group-field"/>
                                {!! csrf_field() !!}
                                <div class="input-group-button">
                                    <input type="submit" class="button" value="购买"/>
                                </div>
                            </div>
                        </form>
                        (库存:{{ $good->count }}件)
                    @endif

                    @if($good->user_id == Session::get('user_id'))
                        <form action="/good/{{ $good->id }}/edit" style="margin:0px;display:inline;">
                            <input type="submit" class="button" value="修改">
                        </form>
                        <form action="/good/{{ $good->id }}/delete" method="POST" style="margin:0px;display:inline;" id="del" onsubmit="return confirm('确定删除吗？');">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="submit" class="button" value="删除">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-12 medium-6 medium-offset-6 columns">
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
        <div class="small-12 medium-12 columns">
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
                    $('#fav_smt').val('取消收藏QAQ');
                    $jQuery_NEW('#fav_smt').attr('onclick', 'del_favlist()');
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
                    $('#fav_smt').val('收藏OvO');
                    $jQuery_NEW('#fav_smt').attr('onclick', 'add_favlist()');
                }
            });
        }
    </script>
@endsection