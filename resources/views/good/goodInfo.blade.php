@include('includes.head')
<title>先锋市场</title>
<style>
    p {
        color: #ffffff;
    }
</style>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <div class="large-8 large-offset-2 small-10 small-offset-1 columns">
        <p>
            {{ $good->description }}</p>
        <div class="row">
            <p>
                <img src="/good/{{ sha1($good->id) }}/titlepic"/>
            </p>
        </div>
        <div class="row">
            @if($user_id == $good->user_id)
                <a class="button" href='/good/{{ $good->id }}/edit'>编辑</a><br/>
                <form action='/good/{{ $good->id }}/delete' method='POST'>
                    {!! csrf_field() !!}
                    {{ method_field('DELETE') }}
                    <input class="button" type="submit" name="submit1" value="Delete">
                </form>
            @endif
            @if($user_id != $good->user_id)
                <form action='/good/{{ $good->id }}/buy' method='POST'>
                    {!! csrf_field() !!}
                    购买数量 ：<input type="number" name="counts"><br/>
                    <input class="button" type="submit" name="sumbit2" value="Buy">
                </form>
            @endif
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

        <a class="button" href='/good'>商品列表</a>
    </div>
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
@include('layout.footer')
@include('includes.foot')
