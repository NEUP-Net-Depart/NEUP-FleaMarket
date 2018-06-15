@extends('layout.master')

@section('title', "发送消息")

@section('content')

  <div class="page-content">
    <form action="/message" method="post">
      <p>Title:<input type="text" name="title"></p>
      <p>Content:<textarea name="content" row="15" cols="45"></textarea></p>
      <p>Receiver:<input type="text" name="receiver"></p>
      {!! csrf_field() !!}
      <p><input type="submit" value="Send"></p>
    </form>
  </div>

@endsection