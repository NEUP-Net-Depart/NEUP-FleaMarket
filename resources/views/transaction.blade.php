@extends('layout.master')

@section('title', "首页")

@section('content')

    <h3>订单信息</h3>
    <div class="card-section">
        <div class="row table-responsive">
            <table class="table">
                <tr>
                    <td>订单编号</td>
                    <td>商品名称</td>
                    <td>数量</td>
                    <td>订单状态</td>
                    <td>操作</td>
                </tr>
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
            </table>
        </div>
    </div>
    <h3>卖家联系方式</h3>
    <div class="card-section">
        <div class="row table-responsive">
            <table class="table">
                <tr>
                    <th>真实姓名</th>
                    <th>手机</th>
                    <th>QQ</th>
                    <th>微信</th>
                    <th>地址</th>
                </tr>

                @foreach($seller->user_infos as $userinfo)
                    <tr>
                        <td>{{ $seller->realname }}</td>
                        <td>{{ isset($userinfo->tel_num) ? $userinfo->tel_num : "" }}</td>
                        <td>{{ isset($userinfo->QQ) ? $userinfo->QQ : "" }}</td>
                        <td>{{ isset($userinfo->wechat) ? $userinfo->wechat : "" }}</td>
                        <td>{{ isset($userinfo->address) ? $userinfo->address : "" }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <h3>买家联系方式</h3>
    <div class="card-section">
        <div class="row table-responsive">
            <table class="card-table" rules="rows">
                <tr>
                    <th>真实姓名</th>
                    <th>手机</th>
                    <th>QQ</th>
                    <th>微信</th>
                    <th>地址</th>
                </tr>

                @foreach($buyer->user_infos as $userinfo)
                    <tr>
                        <td>{{ $buyer->realname }}</td>
                        <td>{{ isset($userinfo->tel_num) ? $userinfo->tel_num : "" }}</td>
                        <td>{{ isset($userinfo->QQ) ? $userinfo->QQ : "" }}</td>
                        <td>{{ isset($userinfo->wechat) ? $userinfo->wechat : "" }}</td>
                        <td>{{ isset($userinfo->address) ? $userinfo->address : "" }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
