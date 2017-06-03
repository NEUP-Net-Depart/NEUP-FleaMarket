@extends('layout.master')

@section('title', "管理")

@section('content')

<ul class="tabs" data-tabs="w6tmms-tabs" id="editadmin" role="tablist">
        <li class="tabs-title  is-active " role="presentation"><a href="#announcement" aria-selected="true" role="tab" aria-controls="extra" id="extra-label">公告管理</a></li>
        <li class="tabs-title " role="presentation"><a href="#classify" role="tab" aria-controls="account" aria-selected="false" id="account-label">分类管理</a></li>
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
                        <td><a href="" class="button">删除</a></td>
                      </tr>
                    </tbody>
                    @endforeach
            </table>

            <form>
              标题
              <input type="text" placeholder="Title">
              内容
              <textarea rows="4" placeholder="Content"></textarea>
              <a href="" class="button">发布公告</a>
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
                      <td><a href="" class="button">删除</a></td>
                      @endforeach
                    </tr>
                  </tbody>
          </table>

          <form>
            新建分类
            <input type="text" placeholder="Classify" >
            <a href="" class="button">提交</a>
          </form>

</div>
@endsection
