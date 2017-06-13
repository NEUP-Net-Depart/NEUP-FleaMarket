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
    <ul class="tabs" data-tabs id="editinfo">
        <li class="tabs-title is-active"><a href="#goods" aria-selected="true">我的商品</a></li>
        <li class="tabs-title"><a href="#trans">交易订单</a></li>
        <li class="tabs-title"><a href="#tickets">历史评价</a></li>
    </ul>
    <div class="tabs-content" data-tabs-content="editinfo">
        <div class="tabs-panel" id="goods">
            <div class="card-section">
                <div class="row table-responsive">
                    <table class="table">
                        <tr>
                            <td>#</td>
                            <td>商品名称</td>
                            <td>商品价格</td>
                            <td>剩余库存</td>
                            <td>修改信息</td>
                            <td>删除商品</td>
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
                                        <input type="submit" class="button" value="修改" style="margin: 0;">
                                    </form>
                                </td>
                                <td>

                                    <form method="POST" id="delform">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}

                                    </form>
                                    <input type="submit" class="button" value="删除" style="margin: 0;" id="delbutton"
                                           onclick="del_good({{ $good->id }})">
                                </td>

                            </tr>

                        @endforeach
                        {{ $goods->links() }}
                    </table>

                    <a href="/good/add" class="button">添加商品</a>
                </div>
            </div>
        </div>
        <div class="tabs-panel" id="trans">
        </div>
        <div class="tabs-panel" id="tickets">
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