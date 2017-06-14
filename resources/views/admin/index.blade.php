@extends('layout.master')

@section('title', "管理")

@section('content')

<div class="card">
<div class="card-header">
<ul class="nav nav-tabs card-header-tabs" role="tab-list">
        <li class="nav-item"><a class="nav-link active" href="#announcement" role="tab" data-toggle="tab" aria-controls="announcement">公告管理</a></li>
        <li class="nav-item"><a class="nav-link" href="#classify" role="tab" data-toggle="tab" aria-controls="classify">分类管理</a></li>
		<li class="nav-item"><a class="nav-link" href="#report" role="tab" data-toggle="tab" aria-controls="report">查看举报记录</a></li>
		<li class="nav-item"><a class="nav-link" href="#userlist" role="tab" data-toggle="tab" aria-controls="userlist">查看所有用户</a></li>
</ul>
</div>

    <div class="tab-content card-block">
        <div role="tabpanel" class="tab-pane active" id="announcement">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>公告标题</th>
                  <th>公告内容</th>
                  <th>发布时间</th>
                </tr>
              </thead>
                    @foreach($announcements as $announcement)
                    <tbody>
                      <tr>
                        <td>{{ $announcement ->id }}</td>
                        <td style="max-width:100px;word-break:break-all;">{{ $announcement->title }}</td>
                        <td style="max-width:500px;word-break:break-all;">{{ $announcement->content }}</td>
                        <td>{{ $announcement->created_at }}</td>
						</td>
						<td>
							<form action="/notice/{{ $announcement -> id }}" method="POST">
							{!! csrf_field() !!}
							{!! method_field('DELETE') !!}
							<input type="submit" class="btn btn-primary" value="删除">
							</form>
						</td>
                      </tr>
                    </tbody>
                    @endforeach
            </table>

            <form action="/notice" method="POST">
			{!! csrf_field() !!}
              标题
              <input type="text" placeholder="Title" name="title" class="form-control">
              内容
			  <textarea rows="4" placeholder="Content" name="content" class="form-control"></textarea>
              <input type="submit" class="btn btn-primary" value="发布公告">
            </form>
        </div>

        <div class="tab-pane" id="classify" role="tabpanel">
          <table class="table table-hover">
            <thead>
              <tr>
                  @foreach($cats as $cat)
                  <td width="100px">{{ $cat ->cat_name}}</td>
                  @endforeach
              </tr>
            </thead>
                  <tbody>
                    <tr>
                      @foreach($cats as $cat)
					  <td>
						<form action="/cat/{{ $cat->id }}/delete" method="POST">
							{!! csrf_field() !!}
							{!! method_field('DELETE') !!}
							<input type="submit" class="btn btn-primary" value="删除">
						</form>
					  </td>
                      @endforeach
                    </tr>
                  </tbody>
          </table>

          <form action="/cat/add" method="POST">
			{!! csrf_field() !!}
            新建分类
            <input type="text" placeholder="Classify" name="cat_name" class="form-control">
            <input type="submit" class="btn btn-primary" value="提交">
          </form>
		</div>

		<div class="tab-pane" id="report" role="tabpanel">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>举报者ID</th>
							<th>被举报者ID</th>
							<th>受理管理员ID</th>
							<th colspan="2">状态</th>
						</tr>
					</thead>
						@foreach($reports as $repo)
						<tbody>
							<tr>
								<td><a href="#repo{{$repo->id}}" data-toggle="modal">{{ $repo->id }}</a></td>
								<td><a href="#repo{{$repo->id}}" data-toggle="modal">{{ $repo->sender_id }}</a></td>
								<td><a href="#repo{{$repo->id}}" data-toggle="modal">{{ $repo->receiver_id }}</a></td>
							<div class="modal fade" id="repo{{$repo->id}}" tabindex="-1" role="dialog" aria-labelledby="repo{{$repo->id}}Label">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">举报理由：</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
											{{ $repo->message }}
										</div>
									</div>
								</div>
							</div>
								@if(!$repo->assignee)
									<td>
										<form action="/repo/{{ $repo->id }}/assign" method="POST">
											{!! csrf_field() !!}
											<input type="submit" class="btn btn-primary" value="领取">
										</form>
									</td>
									<td>未领取</td>
								@else
                                    <td>{{ $repo->assignee }}</td>
                                    @if(!$repo->state)
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
		<div class="tab-pane" id="userlist" role="tabpanel">
			<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>权限</th>
							<th>用户名</th>
							<th>学号</th>
							<th>真名</th>
							<th>昵称</th>
							<th>邮箱</th>
							<th>是否封禁</th>
						</tr>
					</thead>
					@foreach($users as $user)
					<tbody>
						<tr>
							<td>{{$user->id}}</td>
							<td>{{$user->privilege}}</td>
							<td>{{$user->username}}</td>
							<td>{{$user->stuid}}</td>
							<td>{{$user->realname}}</td>
							<td>{{$user->nickname}}</td>
							<td>{{$user->email}}</td>
							<td>
								@if($user->baned == 0)
									否
								@endif
								@if($user->baned == 1)
									已封禁{{$user->banedtime}}天
								@endif
								@if($user->baned == -1)
									已永久封禁
								@endif
							</td>
						</tr>
					</tbody>
				@endforeach
			</table>
		</div>
</div>
@endsection
