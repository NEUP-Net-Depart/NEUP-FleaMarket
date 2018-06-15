@extends('layout.master')

@section('title', "封禁设置")

@section('content')

  <div style="width:480px; float:left; margin-right:100px;">
    <h6>暂时封禁</h6>
    <form action="/setBan/{{ $user_id }}" method="POST">
      {!! csrf_field()!!}
      <label class="right inline">封禁理由:</label>
      <textarea name="reason"></textarea>
      <label class="right inline">举报单号(可为空):</label>
      <textarea name="ticket_id"></textarea>
      <label class="right inline">请选择封禁时间(天):</label>
      <div class="input-group gb_right" style="max-width:180px;">
        <input type="number" name="count" value="1" class="input-group-field" min="1" />
        <div class="input-group-button">
          <input type="submit" class="button" value="确认" />
        </div>
      </div>
    </form>
  </div>
  <div style="width:480px; float:left">
    <h6>永久封禁</h6>
    <form action="/setBan/{{ $user_id }}" method="POST">
      {!! csrf_field() !!}
      <label class="right inline">封禁理由:</label>
      <textarea name="reason"></textarea>
      <label class="right inline">举报单号(可为空):</label>
      <textarea name="ticket_id"></textarea>
      <div>
        <input type="submit" class="button" value="永久封禁" />
        <input type="hidden" name="count" value="-1" />
      </div>
    </form>
  </div>

@endsection
