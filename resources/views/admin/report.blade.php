@extends('admin.master')

@section('tab-list')
  <li class="nav-item"><a class="nav-link" href="/admin">公告管理</a></li>
  <li class="nav-item"><a class="nav-link" href="/admin/classify">分类管理</a></li>
  <li class="nav-item"><a class="nav-link active" href="/admin/report">查看举报记录</a></li>
  <li class="nav-item"><a class="nav-link" href="/admin/userlist">查看所有用户</a></li>
  <li class="nav-item"><a class="nav-link" href="/admin/translist">交易列表</a></li>
@endsection

@section('tab-report')
  <div class="tab-pane active" id="report" role="tabpanel">
    <table class="table table-hover">
      <thead>
      <tr>
        <th>#</th>
        <th>举报者ID</th>
        <th>被举报者ID</th>
        <th>举报理由</th>
        <th>受理管理员ID</th>
        <th colspan="2">状态</th>
      </tr>
      </thead>
      @foreach($reports as $repo)
        <tbody>
        <tr>
          <td><a href="#repo{{$repo->id}}" data-toggle="modal">{{ $repo->id }}</a></td>
          <td><a href="/user/{{ $repo->sender_id }}">{{ $repo->sender_id }}</a></td>
          @if($repo->type == 3)
            <td>使用帮助</td>
          @elseif($repo->type == 4)
            <td>账号申诉</td>
          @elseif($repo->type == 5)
            <td>Bug/功能问题反馈</td>
          @else
            <td><a href="/user/{{ $repo->receiver_id }}">{{ $repo->receiver_id }}</a></td>
          @endif
          <td><a class="btn btn-primary" href="#repo{{$repo->id}}" data-toggle="modal">查看</a></td>
          <div class="modal fade" id="repo{{$repo->id}}" tabindex="-1" role="dialog"
               aria-labelledby="repo{{$repo->id}}Label">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">举报理由：</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  {{ $repo->message }}
                </div>
              </div>
            </div>
          </div>
          @if($repo->type == 5)

          @elseif(!$repo->assignee)
            <td>
              <form action="/repo/{{ $repo->id }}/assign" method="POST">
                {!! csrf_field() !!}
                <input type="submit" class="btn btn-primary" value="领取">
              </form>
            </td>
            <td>未领取</td>
          @else
            <td>{{ $repo->assignee }}</td>
            @if($repo->type == 3 || $repo->type == 4)
              <td>已处理</td>
            @elseif(!$repo->state)
              @if(session('user_id') == $repo->assignee)
                <td>
                  <form action="/repo/{{ $repo->id }}/solve" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="setstate" value="2">
                    <input type="submit" class="btn btn-primary" value="批准显示">
                  </form>
                </td>
                <td>
                  <form action="/repo/{{ $repo->id }}/solve" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="setstate" value="1">
                    <input type="submit" class="btn btn-default" value="驳回此条">
                  </form>
                </td>
              @else
                <td>已领取未处理</td>
              @endif
            @elseif($repo->state == 1)
              <td>已驳回</td>
            @elseif($repo->state == 2)
              <td>已批准</td>
            @endif
          @endif
        </tr>
        </tbody>
      @endforeach
    </table>
    {{ $reports->links() }}
  </div>
@endsection