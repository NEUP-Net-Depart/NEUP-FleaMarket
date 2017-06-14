@extends('user.seller.master')

@section('tab-list')
    <li class="nav-item"><a href="/user/sell" class="nav-link">我的商品</a></li>
    <li class="nav-item"><a href="/user/sell/trans" class="nav-link active">交易订单</a></li>
    <li class="nav-item"><a href="/user/sell/tickets" class="nav-link">历史评价</a></li>
@endsection

@section('tab-content')
        <div role="tabpanel" class="tab-pane" id="goods">
        </div>
        <div role="tabpanel" class="tab-pane active" id="trans">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <label>友情提示：如果需要取消订单，请务必和对方沟通说明理由。恶意取消订单的行为可以举报。</label>
                    <table class="table table-hover table-responsive">
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
                                <td><a href="/user/{{ $tran->buyer_id }}">{{ $tran->buyer->nickname ? $tran->buyer->nickname : "无昵称用户" }}@if($tran->buyer->baned)【已封禁】@endif</a></td>
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
                                    {{--<td>
                                        <form action="#">
                                            <input type="submit" class="button" value="修改订单" style="margin: 0;">
                                        </form>
                                    </td>--}}
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
        <div role="tabpanel" class="tab-pane" id="tickets">
        </div>
@endsection