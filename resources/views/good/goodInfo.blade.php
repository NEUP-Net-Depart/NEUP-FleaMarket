@extends('layout.master')

@section('title', "商品详情")

@section('content')

    <div class="row">
        <div class="small-12 medium-5 columns thumbnail">
            <img src="/good/{{ sha1($good->id) }}/titlepic"/>
        </div>
        <div class="small-12 medium-6 medium-offset-1 columns">
            <h1>{{ $good->good_name }}</h1>
            <h4 style="color: #cc4b37"><b>￥{{ $good->pricemin }} - ￥{{ $good->pricemax }}</b></h4>
            <div class="row">
                <div class="small-5 columns">
                    @if($good->seller) != Session::get('user_id'))
                    <form action="/good/{{ $good->id }}/buy" method="post">
                        <div class="input-group">
                            <input type="number" name="counts" value="1" class="input-group-field"/>
                            {!! csrf_field() !!}
                            <div class="input-group-button">
                                <input type="submit" class="button" value="购买"/>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{ $good->description }}
    </div>
    <div class="row">
        <form id="fav">
            {!! csrf_field() !!}
            @if(count($inFvlst) == 0)
                <input id="fav_smt" class="button" type="button"  name="submit1" onclick="add_favlist()" value="收藏OvO"/>
            @endif
            @if(count($inFvlst) != 0)
                <input id="fav_smt" class="button" type="button" name="submit1" onclick="del_favlist()" value="取消收藏QAQ"/>
            @endif
        </form>
    </div>
    <script>
        function add_favlist() {
            var str_data = $("#fav input").map(function () {
                return ($(this).attr("name") + '=' + $(this).val());
            }).get().join("&");
            $.ajax({
                type: "GET",
                url: "/good/{{ $good->id }}/add_favlist",
                data: str_data,
                success: function (msg) {
                    $('#fav_smt').val('取消收藏QAQ');
                    $('#fav_smt').attr('onclick','del_favlist()');
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
                    $('#fav_smt').val('收藏QAQ');
                    $('#fav_smt').attr('onclick','add_favlist()');
                }
            });
        }
    </script>
@endsection