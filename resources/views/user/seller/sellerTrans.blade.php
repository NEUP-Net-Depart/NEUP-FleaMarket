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
        <li class="tabs-title"><a href="#goods" aria-selected="true">我的商品</a></li>
        <li class="tabs-title is-active"><a href="#trans">交易订单</a></li>
        <li class="tabs-title"><a href="#tickets">历史评价</a></li>
    </ul>
    <div class="tabs-content" data-tabs-content="editinfo">
        <div class="tabs-panel" id="goods">
        </div>
        <div class="tabs-panel" id="trans">
            <div class="card-section">
                <div class="row table-responsive">
                    <table class="table">
                        <tr>
                            <td>订单编号</td>
                            <td>商品名称</td>
                            <td>买家昵称</td>
                            <td>数量</td>
                            <td>订单状态</td>
                            <td colspan="3">操作</td>
                        </tr>
                        @foreach($trans as $tran)
                            <tr id="tran{{ $tran->id }}">
                                <td>{{ $tran->id }}</td>
                                <td><a href="/good/{{$tran->good_id}}"
                                       onMouseOver="toolTip('<img src=/good/{{ sha1($tran->good_id) }}/titlepic>')"
                                       onMouseOut="toolTip()">{{ $tran->good->good_name }}</a></td>
                                <td>{{ $tran->buyer->nickname ? $tran->buyer->nickname : "无昵称用户" }}</td>
                                <td>{{ $tran->number }}</td>
                                @if($tran->status == 0)
                                    <td>
                                        已取消
                                    </td>
                                @elseif($tran->status == 1)
                                    <td>
                                        买家已下单
                                    </td>
                                    <td>
                                        <form method="POST" action="/trans/{{ $tran->id }}/confirm">
                                            {!! csrf_field() !!}
                                            <input type="submit" class="button" value="确认订单" style="margin: 0;">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="/trans/{{ $tran->id }}/cancel" id="delform">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <input type="submit" class="button" value="取消订单" style="margin: 0;"
                                                   id="delbutton">
                                        </form>
                                    </td>
                                @elseif($tran->status == 2)
                                    <td>
                                        交易已成立
                                    </td>
                                    <td>
                                        <a href="/trans/{{ $tran->id }}">查看交易</a>
                                    </td>
                                    <td>
                                        <form action="#">
                                            <input type="submit" class="button" value="修改订单" style="margin: 0;">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="/trans/{{ $tran->id }}/confirm">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="result" value="1">
                                            <input type="submit" class="button" value="完成交易" style="margin: 0;">
                                        </form>
                                    </td>
                                @elseif($tran->status == 3)
                                    <td>
                                        交易失败
                                    </td>
                                @elseif($tran->status == 4)
                                    <td>
                                        交易成功待评价
                                    </td>
                                @elseif($tran->status == 5)
                                    <td>
                                        买家已评价
                                    </td>
                                @endif
                            </tr>

                        @endforeach
                        {{ $trans->links() }}
                    </table>
                </div>
            </div>
        </div>
        <div class="tabs-panel" id="tickets">
        </div>
    </div>

    <script src="/js/good/ToolTip.js"></script>
    <script>
        $(document).ready(function () {
            $("a[href='#goods']").click(function () {
                window.location.href = "/user/sell";
            });
            $("a[href='#tickets']").click(function () {
                window.location.href = "/user/sell/tickets";
            });
        });
    </script>
@endsection