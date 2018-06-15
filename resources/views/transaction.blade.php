@extends('layout.master')

@section('title', "首页")

@section('content')

  <h3>订单信息</h3>
  <div class="card-section">
    <div class="row table-responsive">
      <table class="table">
        <tr>
          <td nowrap="nowrap">订单编号</td>
          <td nowrap="nowrap">商品名称</td>
          <td nowrap="nowrap">数量</td>
          <td nowrap="nowrap">订单状态</td>
          <td nowrap="nowrap">操作</td>
        </tr>
        <tr id="tran{{ $tran->id }}">
          <td nowrap="nowrap">{{ $tran->id }}</td>
          <td nowrap="nowrap"><a href="/good/{{$tran->good_id}}"
                                 onMouseOver="toolTip('<img src=/good/{{ sha1($tran->good_id) }}/titlepic>')"
                                 onMouseOut="toolTip()">{{ $tran->good->good_name }}</a></td>
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
                <input type="submit" class="button" value="取消订单" style="margin: 0;"
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
            <td nowrap="nowrap">
              <form action="/comment/{{ $tran->id }}">
                {!! csrf_field() !!}
                <input type="submit" class="button" value="评价" style="margin: 0;">
              </form>
            </td>
          @elseif($tran->status == 5)
            <td nowrap="nowrap">
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
          <th nowrap="nowrap">真实姓名</th>
          <th nowrap="nowrap">手机</th>
          <th nowrap="nowrap">QQ</th>
          <th nowrap="nowrap">微信</th>
          <th nowrap="nowrap">地址</th>
        </tr>

        @if(count($seller->user_infos) == 0)
          <tr>
            <td nowrap="nowrap" colspan="5">该用户没有填写联系方式，你们可以通过“消息”来联系。“消息”会通过东大小秘书微信公众号进行推送。</td>
          </tr>
        @endif
        @foreach($seller->user_infos as $userinfo)
          <tr>
            <td nowrap="nowrap">{{ $seller->realname }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->tel_num) ? $userinfo->tel_num : "" }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->QQ) ? $userinfo->QQ : "" }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->wechat) ? $userinfo->wechat : "" }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->address) ? $userinfo->address : "" }}</td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
  <h3>买家联系方式</h3>
  <div class="card-section">
    <div class="row table-responsive">
      <table class="table">
        <tr>
          <th nowrap="nowrap">真实姓名</th>
          <th nowrap="nowrap">手机</th>
          <th nowrap="nowrap">QQ</th>
          <th nowrap="nowrap">微信</th>
          <th nowrap="nowrap">地址</th>
        </tr>

        @if(count($buyer->user_infos) == 0)
          <tr>
            <td nowrap="nowrap" colspan="5">该用户没有填写联系方式，你们可以通过“消息”来联系。“消息”会通过东大小秘书微信公众号进行推送。</td>
          </tr>
        @endif
        @foreach($buyer->user_infos as $userinfo)
          <tr>
            <td nowrap="nowrap">{{ $buyer->realname }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->tel_num) ? $userinfo->tel_num : "" }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->QQ) ? $userinfo->QQ : "" }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->wechat) ? $userinfo->wechat : "" }}</td>
            <td nowrap="nowrap">{{ isset($userinfo->address) ? $userinfo->address : "" }}</td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>

@endsection
