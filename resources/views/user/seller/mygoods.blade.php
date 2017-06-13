@extends('layout.master')

@section('title', "我的出售")

@section('asset')
    <style>
        h5 {
            color: #ffffff;
        }

        .trans_msg {
            filter: alpha(opacity=100) revealTrans(duration=.2, transition=1) blendtrans(duration=.2);
            width: 400px;
            height: 200px;
        }
    </style>
@endsection

@section('content')

    <h3>我的出售</h3>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#goods" aria-controls="goods" role="tab" data-toggle="tab">我的商品</a></li>
        <li role="presentation"><a href="#trans" aria-controls="trans" role="tab" data-toggle="tab">交易订单</a></li>
        <li role="presentation"><a href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab">历史评价</a></li>
    </ul>
    <div class="panel panel-default">
    <div class="tab-content panel-body">
        <div role="tabpanel" class="tab-pane active" id="goods">
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>商品名称</th>
                    <th>商品价格</th>
                    <th>剩余库存</th>
                    <th>修改信息</th>
                    <th>删除商品</th>
                </tr>
                @foreach($goods as $good)
                    <tr id="good{{ $good->id }}">
                        <td>{{ $good->id }}</td>
                        <td><a href="/good/{{$good->id}}"
                                onMouseOver="toolTip('<img src=/good/{{ sha1($good->id) }}/titlepic>')"
                                onMouseOut="toolTip()">{{ $good->good_name }}</a></td>
                        <td>{{ $good->price }}</td>
                        <td>{{ $good->count }}</td>
                        <td>
                            <form action="/good/{{ $good->id }}/edit">
                                <input type="submit" class="btn btn-primary" value="修改" style="margin: 0;">
                            </form>
                        </td>
                        <td>
                            <form method="POST" id="delform">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                            </form>
                            <input type="submit" class="btn btn-primary" value="删除" style="margin: 0;" id="delbutton" onclick="del_good({{ $good->id }})">
                        </td>
                    </tr>
                @endforeach
                {{ $goods->links() }}
            </table>
        </div>
        <div class="tab-pane" id="trans">
        </div>
        <div class="tab-pane" id="tickets">
        </div>
    </div>

    <script src="/js/good/ToolTip.js"></script>
    <script>
        function del_good(goodid) {
            if (confirm('确定删除吗？')) {
                var str_data1 = $('#delform').serialize();
                var str_data = str_data1 + '&_method=DELETE';
                $.ajax({
                    type: "POST",
                    url: "/good/" + goodid + "/delete",
                    data: str_data,
                    success: function (msg) {
                        $('#good' + goodid).slideUp();
                    }
                });
            }
        }
        $(document).ready(function () {
            $("a[href='#trans']").click(function () {
                window.location.href = "/user/sell/trans";
            });
            $("a[href='#tickets']").click(function () {
                window.location.href = "/user/sell/tickets";
            });
        });
    </script>
@endsection