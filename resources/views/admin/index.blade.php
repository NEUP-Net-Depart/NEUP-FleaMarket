@extends('layout.master')

@section('title', "管理")

@section('content')


<h2>公告</h2>
  <table id="t1">
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
    <font size="5">标题</font>
    <input type="text" placeholder="Title">

    <font size="5">内容</font>
    <textarea rows="4" placeholder="Content"></textarea>

    <a href="" class="button">发布公告</a>
  </form>

@endsection
