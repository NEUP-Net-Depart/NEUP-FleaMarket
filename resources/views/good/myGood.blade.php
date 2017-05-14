@extends('layout.master')

@section('title', "我的商品")

@section('asset')
<style>
    h5 {
        color: #ffffff;
    }
    .trans_msg
    {
        filter:alpha(opacity=100) revealTrans(duration=.2,transition=1) blendtrans(duration=.2);
        width:400px;
        height:200px;
    }
</style>
@endsection

@section('content')

<div class="page-content">
    <div class="row">
        <h5>商品列表</h5>
        <table class="table">
            <tr>
                <td>#</td>
                <td>商品名称</td>
                <td>商品价格</td>
                <td>修改信息</td>
                <td>删除商品</td>
            </tr>
            @foreach($goods as $good)
                <tr id="good{{ $good->id }}">
                    <td>{{ $good->id }}</td>
                    <td><a href="/good/{{$good->id}}" onMouseOver="toolTip('<img src=/good/{{ sha1($good->id) }}/titlepic>')" onMouseOut="toolTip()">{{ $good->good_name }}</a></td>
                    <td>{{ $good->price }}</td>
                    <td>
                        <form action="/good/{{ $good->id }}/edit">
                            <input type="submit" class="button" value="修改" style="margin: 0;">
                        </form>
                    </td>
                    <td>

                        <form  method="POST"   id="delform">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}

                        </form>
                        <input type="submit" class="button" value="删除" style="margin: 0;" id="delbutton" onclick="del_good({{ $good->id }})">
                    </td>

                </tr>

            @endforeach
        </table>
        <a href="/good/add" class="button">添加商品</a>
    </div>
</div>
<script src="/js/good/ToolTip.js"></script>
<script>
    function del_good(goodid) {
        if(confirm('确定删除吗？')){
        var str_data1 = $('#delform').serialize();
        var str_data = str_data1 + '&_method=DELETE';
        $.ajax({
            type: "POST",
            url: "/good/"+goodid+"/delete",
            data: str_data,
            success: function (msg) {
                $('#good'+goodid).slideUp();
            }
        });
    }
    }
</script>
@endsection