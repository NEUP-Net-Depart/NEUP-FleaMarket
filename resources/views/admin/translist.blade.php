@extends('admin.master')

@section('tab-list')
  <li class="nav-item"><a class="nav-link" href="/admin">公告管理</a></li>
  <li class="nav-item"><a class="nav-link" href="/admin/classify">分类管理</a></li>
  <li class="nav-item"><a class="nav-link" href="/admin/report">查看举报记录</a></li>
  <li class="nav-item"><a class="nav-link" href="/admin/userlist">查看所有用户</a></li>
  <li class="nav-item"><a class="nav-link active" href="/admin/translist">交易列表</a></li>
@endsection

@section('tab-translist')
  <div class="tab-pane active" id="translist" role="tabpanel">
    <table class="table table-hover">
      <thead>
      <tr>
        <th>交易单号</th>
        <th>卖家</th>
        <th>买家</th>
        <th>商品ID</th>
        <th>交易数目</th>
        <th>交易状态</th>
        <th>评价</th>
        <th>交易日期</th>
      </tr>
      </thead>
      @foreach($trans as $tran)
        @if($tran->seller != NULL)
          <tbody>
          <tr>
            <td>{{$tran->id}}</td>
            <td>
              <a href="/user/{{$tran->seller->id}}">学号{{$tran->seller->stuid}}</a>
              @foreach($tran->seller->user_infos()->get() as $user)
                <br />手机{{$user->tel_num}}
                <br />QQ{{$user->QQ}}
                <br />微信{{$user->wechat}}
              @endforeach
            </td>
            <td>
              <a href="/user/{{$tran->buyer_id}}">学号{{$tran->buyer->stuid}}</a>
              @foreach($tran->buyer->user_infos()->get() as $user)
                <br />手机{{$tran->buyer->user_infos()->first()->tel_num}}
                <br />QQ{{$tran->buyer->user_infos()->first()->QQ}}
                <br />微信{{$tran->buyer->user_infos()->first()->wechat}}
              @endforeach
            </td>
            <td><a href="/good/{{$tran->good_id}}"
                   onMouseOver="toolTip('<img src=/good/{{ sha1($tran->good_id) }}/titlepic/>')"
                   onMouseOut="toolTip()">{{$tran->good_id}}</a></td>
            <td>{{$tran->number}}</td>
            <td>
              @if($tran->status == 0)
                订单已取消
              @endif
              @if($tran->status == 1)
                买家已购买，卖家未确认
              @endif
              @if($tran->status == 2)
                卖家已确认
              @endif
              @if($tran->status == 3)
                交易失败
              @endif
              @if($tran->status == 4)
                交易成功待评价
              @endif
              @if($tran->status == 5)
                交易成功已评价
              @endif
            </td>
            <td>
              @if($tran->status == 5)
                {{$tran->reason}}
              @else
                无
              @endif
            </td>
            <td>{{ $tran->updated_at }}</td>
          </tr>
          </tbody>
        @endif
      @endforeach
    </table>
    {{ $trans->links() }}
  </div>

  <script src="/js/good/ToolTip.js"></script>
@endsection