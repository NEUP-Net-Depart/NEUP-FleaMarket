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
    <label>友情提示：如果需要取消订单，请务必和对方沟通说明理由。恶意取消订单的行为可以举报。</label>
    <table class="table table-hover table-responsive">
        <tr>
            <td nowrap="nowrap">订单编号</td>
            <td nowrap="nowrap">商品名称</td>
			<td nowrap="nowrap">卖家昵称</td>
            <td nowrap="nowrap">数量</td>
            <td nowrap="nowrap">订单状态</td>
            <td nowrap="nowrap">操作</td>
        </tr>
		@foreach($trans as $tran)
			@if(isset($tran->good))
            <tr id="tran{{ $tran->id }}">
				<td nowrap="nowrap">{{ $tran->id }}</td>
				@if($tran->good->deleted_at == NULL)
				<td nowrap="nowrap"><a href="/good/{{$tran->good_id}}"
					onMouseOver="toolTip('<img src=/good/{{ sha1($tran->good_id) }}/titlepic>')"
					onMouseOut="toolTip()">{{ $tran->good->good_name }}</a></td>
				@elseif($tran->good->deleted_at != NULL)
				<td nowrap="nowrap">{{ $tran->good->good_name }} (已删除)</td>
				@endif
				<td nowrap="nowrap"><a href="/user/{{ $tran->seller->id }}">{{ $tran->seller->nickname ?  $tran->seller->nickname : "无昵称用户" }}@if($tran->seller->baned)【已封禁】@endif</a></td>
                <td nowrap="nowrap">{{ $tran->number }}</td>
                @if($tran->status == 0)
                    <td nowrap="nowrap">
                        已取消
                    </td>
                @elseif($tran->status == 1)
                    <td nowrap="nowrap">
                        等待卖家确认
                    </td>
                    <td>
                        <form method="POST" action="/trans/{{ $tran->id }}/cancel" id="delform">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="submit" class="btn btn-primary" value="取消订单" style="margin: 0;"
                                   id="delbutton">
                        </form>
                    </td>
                @elseif($tran->status == 2)
                    <td nowrap="nowrap">
                        交易已成立
                    </td>
                    <td nowrap="nowrap">
                        <a href="/trans/{{ $tran->id }}">查看交易</a>
                    </td>
                @elseif($tran->status == 3)
                    <td nowrap="nowrap">
                        交易失败
                    </td>
                @elseif($tran->status == 4)
                    <td nowrap="nowrap">
                        交易成功待评价
                    </td>
                    <td>
                        <form action="/comment/{{ $tran->id }}">
                            {!! csrf_field() !!}
                            <input type="submit" class="btn btn-primary" value="评价" style="margin: 0;">
                        </form>
                    </td>
                @elseif($tran->status == 5)
                    <td nowrap="nowrap">
                        已评价
                    </td>
                @endif
            </tr>
			@endif
        @endforeach
        {{ $trans->links() }}
    </table>

    <script src="/js/good/ToolTip.js"></script>

@endsection
