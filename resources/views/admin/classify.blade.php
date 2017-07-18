@extends('admin.master')

@section('tab-list')
    <li class="nav-item"><a class="nav-link" href="/admin">公告管理</a></li>
    <li class="nav-item"><a class="nav-link active" href="/admin/classify">分类管理</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/report">查看举报记录</a></li>
		<li class="nav-item"><a class="nav-link" href="/admin/userlist">查看所有用户</a></li>
		<li class="nav-item"><a class="nav-link" href="/admin/translist">交易列表</a></li>
@endsection

@section('tab-classify')
        <div class="tab-pane active" id="classify" role="tabpanel">
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
@endsection