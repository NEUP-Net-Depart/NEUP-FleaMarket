@extends('user.seller.master')

@section('tab-list')
    <li class="nav-item"><a href="/user/sell" class="nav-link">我的商品（正在卖）</a></li>
    <li class="nav-item"><a href="/user/sell/sold" class="nav-link">我的商品（已售出）</a></li>
    <li class="nav-item"><a href="/user/sell/trans" class="nav-link active">交易订单</a></li>
    <li class="nav-item"><a href="/user/sell/tickets" class="nav-link">历史评价</a></li>
@endsection

@section('asset')
    <script>
        function change(me,id){
            if($(me).hasClass("fa-pencil")){
                $(me).siblings("span").css("display","none");
                $(me).siblings("input").css("display","inline");
                $(me).removeClass("fa-pencil");
                $(me).addClass("fa-check");
            }
            else{
                if($(me).siblings("span").text()!=$(me).siblings("input[name='number']").val()){
                    var str_data = $(me).parent().serialize();
                    str_data+="&_method=PUT";
                    $.ajax({
                        type: "POST",
                        url: "/trans/"+id+"/edit",
                        data: str_data,
                        success: function (msg) {
                            alert("修改成功");
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(XMLHttpRequest.readyState);
                            alert(textStatus);
                        }
                    });
                }
                    $(me).siblings("span").text($(me).siblings("input[name='number']").val());
                    $(me).siblings("span").css("display","inline");
                    $(me).siblings("input").css("display","none");
                    $(me).removeClass("fa-check");
                    $(me).addClass("fa-pencil");
            }
        }
        $(document).ready(function() {
            $(".finish").hover(function(){
                    $(this).find(".aban").css("visibility","visible");
                },
                function(){
                    $(this).find(".aban").css("visibility","hidden");
                })

        });
    </script>
@endsection
@section('tab-content')
        <div role="tabpanel" class="tab-pane" id="goods">
        </div>
        <div role="tabpanel" class="tab-pane active" id="trans">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <label>友情提示：如果需要取消订单，请务必和对方沟通说明理由。恶意取消订单的行为可以举报。</label>
                    <table class="table table-hover table-responsive">
                        <tr>
                            <td nowrap="nowrap">订单编号</td>
                            <td nowrap="nowrap">商品名称</td>
                            <td nowrap="nowrap">买家昵称</td>
                            <td nowrap="nowrap">数量</td>
                            <td nowrap="nowrap">订单状态</td>
                            <td nowrap="nowrap" colspan="3">操作</td>
                        </tr>
                        @foreach($trans as $tran)
                            <tr id="tran{{ $tran->id }}">
                                <td nowrap="nowrap">{{ $tran->id }}</td>
								@if($tran->good->deleted_at == NULL)
								<td nowrap="nowrap"><a href="/good/{{$tran->good_id}}"
									onMouseOver="toolTip('<img src=/good/{{ sha1($tran->good_id) }}/titlepic>')"
									onMouseOut="toolTip()">{{ $tran->good->good_name }}</a></td>
								@elseif($tran->good->deleted_at != NULL)
								<td nowrap="nowrap">{{ $tran->good->good_name }} (已删除)</td>
								@endif
                                <td nowrap="nowrap"><a href="/user/{{ $tran->buyer_id }}">{{ $tran->buyer->nickname ? $tran->buyer->nickname : "无昵称用户" }}@if($tran->buyer->baned)【已封禁】@endif</a></td>
                                <td nowrap="nowrap" style="min-width:73px">
                                    <form class="fuck">
                                        {!! csrf_field() !!}
                                    <span>{{ $tran->number }}</span>
                                    @if($tran->status == 2)
                                        <input type="input" name="number" value="{{ $tran->number }}" style="display: none;width:30px"/>
                                        <span class="fa fa-pencil" onclick="change(this,'{{ $tran->id }}')"></span>
                                        @endif
                                    </form>
                                </td>
                                @if($tran->status == 0)
                                    <td nowrap="nowrap">
                                        已取消
                                    </td>
                                @elseif($tran->status == 1)
                                    <td nowrap="nowrap">
                                        买家已下单
                                    </td>
                                    <td>
                                        <form method="POST" action="/trans/{{ $tran->id }}/confirm">
                                            {!! csrf_field() !!}
                                            <input type="submit" class="btn btn-primary" value="确认订单" style="margin: 0;">
                                        </form>
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
                                        <a href="/trans/{{ $tran->id }}" class="btn btn-primary">查看交易</a>
                                    </td>

                                    <td nowrap="nowrap" class="finish">
                                        <form method="POST" action="/trans/{{ $tran->id }}/confirm" style="float: right">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="result" value="1">
                                            <input type="submit" class="btn btn-success" value="完成交易" style="margin: 0;">
                                        </form>
                                    </td>
                                    <td nowrap="nowrap" class="abantd">
                                        <form method="POST" action="/trans/{{ $tran->id }}/confirm" style="float: right">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="result" value="0">
                                            <input type="submit" class="btn btn-primary aban" value="交易失败" style="margin: 0;">
                                        </form>
                                    </td>
                                @elseif($tran->status == 3)
                                    <td nowrap="nowrap">
                                        交易失败
                                    </td>
                                @elseif($tran->status == 4)
                                    <td nowrap="nowrap">
                                        交易成功待评价
                                    </td>
                                @elseif($tran->status == 5)
                                    <td nowrap="nowrap">
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
