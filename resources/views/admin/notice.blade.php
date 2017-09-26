@extends('admin.master')

@section('tab-list')
    <li class="nav-item"><a class="nav-link active" href="/adminnnouncement">公告管理</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/classify">分类管理</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/report">查看举报记录</a></li>
	<li class="nav-item"><a class="nav-link" href="/admin/userlist">查看所有用户</a></li>
	<li class="nav-item"><a class="nav-link" href="/admin/translist">交易列表</a></li>
@endsection

@section('tab-announcement')
        <div role="tabpanel" class="tab-pane active" id="announcement">
            <h4>公告功能已下线</h4>
            <p>要发布活动公告，如“先锋市场公测用户群成立啦！”“先锋市场六维邀请码放送活动”，请</p>
            <ul>
                <li>P一张好看的封面图</li>
                <li>添加一个商品，描述写公告内容，将库存设置为零</li>
                <li>置顶该商品</li>
            </ul>
            <p>要发布通知公告，如“xxx商品即日起禁止销售”，请</p>
            <p>群发系统消息（开发中）</p>
            <h4>下面是旧版公告入口</h4>
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
			  <textarea rows="4" id="content" placeholder="Content" name="content" class="form-control"></textarea>
              <input type="submit" class="btn btn-primary" value="发布公告">
            </form>
        </div>
@endsection