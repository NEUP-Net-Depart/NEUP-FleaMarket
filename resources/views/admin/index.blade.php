@extends('layout.master')

@section('title', "管理")

@section('content')

<ul class="tabs" data-tabs="w6tmms-tabs" id="editadmin" role="tablist">
        <li class="tabs-title  is-active " role="presentation"><a href="#announcement" aria-selected="true" role="tab" aria-controls="extra" id="extra-label">公告管理</a></li>
        <li class="tabs-title " role="presentation"><a href="#classify" role="tab" aria-controls="account" aria-selected="false" id="account-label">分类管理</a></li>
		<li class="tabs-title "><a href="#report">查看举报记录</a></li>
</ul>

<div class="tabs-content" data-tabs-content="editadmin">
        <div class="tabs-panel" id="announcement" role="tabpanel" aria-hidden="false" aria-labelledby="extra-label">
            <table>
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
							<input type="submit" class="button" value="删除">
							</form>
						</td>
                      </tr>
                    </tbody>
                    @endforeach
            </table>

            <form action="/notice" method="POST">
			{!! csrf_field() !!}
              标题
              <input type="text" placeholder="Title" name="title">
              内容
			  <textarea rows="4" placeholder="Content" name="content"></textarea>
              <input type="submit" class="button" value="发布公告">
            </form>
        </div>

        <div class="tabs-panel" id="classify" role="tabpanel" aria-hidden="false" aria-labelledby="extra-label">
          <table>
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
							<input type="submit" class="button" value="删除">
						</form>
					  </td>
                      @endforeach
                    </tr>
                  </tbody>
          </table>

          <form action="/cat/add" method="POST">
			{!! csrf_field() !!}
            新建分类
            <input type="text" placeholder="Classify" name="cat_name">
            <input type="submit" class="button" value="提交">
          </form>
		</div>

		<div class="tabs-panel" id="report">
			<div class="card-section">
				<table>
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
								<td>{{ $repo->id }}</td>
								<td>{{ $repo->sender_id }}</td>
								<td>{{ $repo->receiver_id }}</td>
								@if(!$repo->assignee)
									<td>
										<form action="/repo/{{ $repo->id }}/assign" method="POST">
											{!! csrf_field() !!}
											<input type="submit" class="button" value="领取">
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
                                                    <input type="submit" class="button" value="批准显示">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="/repo/{{ $repo->id }}/solve" method="POST">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="setstate" value="1">
                                                    <input type="submit" class="button" value="驳回此条">
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
			</div>
			{{ $reports->links() }}
		</div>

</div>
@endsection
