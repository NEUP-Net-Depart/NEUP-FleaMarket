@extends('layout.master')

@section('title', "我的订单")

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

    <h3>我的订单</h3>
    <div class="card-section">
        <label>友情提示：如果需要取消订单，请务必和对方沟通说明理由。恶意取消订单的行为可以举报。</label>
        <div class="row table-responsive">
            <table class="table">
                <tr>
                    <td>订单编号</td>
                    <td>商品名称</td>
                    <td>数量</td>
                    <td>订单状态</td>
                    <td>操作</td>
                </tr>
                @foreach($trans as $tran)
                    <tr id="tran{{ $tran->id }}">
                        <td>{{ $tran->id }}</td>
                        <td><a href="/good/{{$tran->good_id}}"
                               onMouseOver="toolTip('<img src=/good/{{ sha1($tran->good_id) }}/titlepic>')"
                               onMouseOut="toolTip()">{{ $tran->good->good_name }}</a></td>
                        <td>{{ $tran->number }}</td>
                        @if($tran->status == 0)
                            <td>
                                已取消
                            </td>
                        @elseif($tran->status == 1)
                            <td>
                                等待卖家确认
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
                        @elseif($tran->status == 3)
                            <td>
                                交易失败
                            </td>
                        @elseif($tran->status == 4)
                            <td>
                                交易成功待评价
                            </td>
                            <td>
                                <form action="/comment/{{ $tran->id }}">
									{!! csrf_field() !!}
                                    <input type="submit" class="button" value="评价" style="margin: 0;">
                                </form>
                            </td>
                        @elseif($tran->status == 5)
                            <td>
                                已评价
                            </td>
                        @endif
                    </tr>

                @endforeach
                {{ $trans->links() }}
            </table>
        </div>
    </div>

@endsection
