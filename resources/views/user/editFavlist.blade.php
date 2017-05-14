@extends('layout.master')

@section('title', "编辑收藏")

@section('asset')

    <style>
        h5 {
            color: #ffffff;
        }
        .pic{
            display:none;
            height:110px;
            width:200px;
        }
        .active{
            display:block;
        }
        .list{
            table-layout:fixed;
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
        <a href="/user/fav" class="button">返回收藏夹</a>
        <form action="/user/fav/del" method="POST">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <label>收藏商品</label>
            <table class="table">
                <tr>
                    <td>#</td>
                    <td>商品名称</td>
                    <td>商品价格</td>
                    <td>选择</td>
                </tr>
                @foreach($goods as $good)
                    <tr>
                        <td>{{ $good->good_id }}</td>
                        <td><a href="/good/{{$good->good_id}}" onMouseOver="toolTip('<img src=/good/{{ sha1($good->good_id) }}/titlepic>')" onMouseOut="toolTip()">{{ $good_info[$good->good_id]->good_name }}</a><img src="/good/{{ sha1($good->good_id) }}/titlepic" class="pic" /></td>
                        <td>{{ $good_info[$good->good_id]->price }}</td>
                        <td><input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->good_id }}"
                                   onclick="{setValue({{ $good->good_id }})}"/></td>
                    </tr>
                @endforeach
            </table>
            <input type="submit" name="del_submit" class="button" value="删除选中商品"/>
        </form>
    </div>
    <script>
        function setValue(good_id) {
            if (document.getElementById("box" + good_id).value == good_id)
                document.getElementById("box" + good_id).value = 0;
            else
                document.getElementById("box" + good_id).value = good_id;
        }
    </script>
    <script src="/js/good/ToolTip.js"></script>
@endsection