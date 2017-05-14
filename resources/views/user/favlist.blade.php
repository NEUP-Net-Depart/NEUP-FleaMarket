@extends('layout.master')

@section('title', "收藏夹")

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
        <div class="row">
            <h5>收藏商品</h5>
            <table class="table">
                <tr>
                    <td>#</td>
                    <td>商品名称</td>
                    <td>商品价格</td>
                    <td>库存</td>
                </tr>
                @foreach($goods as $good)
                    <tr class="list">
                        <td>{{ $good->good_id }}</td>
                        <td class="name"><a href="/good/{{$good->good_id}}" onMouseOver="toolTip('<img src=/good/{{ sha1($good->good_id) }}/titlepic>')" onMouseOut="toolTip()">{{ $good_info[$good->good_id]->good_name }}</a><img src="/good/{{ sha1($good->good_id) }}/titlepic" class="pic" /></td>
                        <td>{{ $good_info[$good->good_id]->price }}</td>
                        <td>{{ $good_info[$good->good_id]->count }}</td>
                    </tr>
                @endforeach
            </table>
            <a href="/user/fav/edit" class="button">编辑收藏夹</a>
        </div>
    </div>
    <script src="/js/good/ToolTip.js"></script>
@endsection