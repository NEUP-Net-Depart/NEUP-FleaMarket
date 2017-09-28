@extends('admin.master')

@section('tab-list')
        <li class="nav-item"><a class="nav-link" href="/admin">公告管理</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/classify">分类管理</a></li>
		<li class="nav-item"><a class="nav-link" href="/admin/report">查看举报记录</a></li>
		<li class="nav-item"><a class="nav-link active" href="/admin/userlist">查看所有用户</a></li>
		<li class="nav-item"><a class="nav-link" href="/admin/translist">交易列表</a></li>
@endsection

@section('tab-userlist')
		<div class="tab-pane active" id="userlist" role="tabpanel">
			<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>权限</th>
                            <th>学号</th>
                            <th>真实姓名</th>
                            <th>昵称</th>
							<th>用户名</th>
							<th>邮箱</th>
							<th>手机</th>
							<th>微信</th>
							<th>是否封禁</th>
                            <th>注册时间</th>
						</tr>
					</thead>
					@foreach($users as $user)
					<tbody>
						<tr>
							<td><a href="/user/{{$user->id}}">{{$user->id}}</a></td>
							<td>{{$user->privilege}}</td>
                            <td>{{$user->stuid}}</td>
                            <td>{{$user->realname}}</td>
                            <td><a href="/user/{{$user->id}}">{{$user->nickname}}</a></td>
							<td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
							<td>{{$user->tel}}</td>
							<td>{{$user->wechat_open_id != null ? 1 : 0}}</td>
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
                            <td>{{$user->created_at}}</td>
						</tr>
					</tbody>
				@endforeach
			</table>
			{{ $users->links() }}
		</div>
@endsection