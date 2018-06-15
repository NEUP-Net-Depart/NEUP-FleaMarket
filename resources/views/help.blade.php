@extends('layout.master')

@section('title', "帮助/反馈")

@section('content')


  <form action="/help" method="POST">
    {!! csrf_field() !!}
    <div class="row form-group">
      <div class="col col-xs-12 col-sm-6 col-md-4">
        <select id="type" name="type" class="form-control">
          <option value="3">使用帮助</option>
          <option value="4">账号申诉</option>
          <option value="5">Bug/功能意见反馈</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col col-xs-12 col-sm-8 col-md-6">
        <p id="tips">如果您已经登录，我们的客服/管理员会通过站内消息联系您。如果您没有登录，请务必在内容中注明联系方式以便我们联系您。</p>
      </div>
    </div>
    <div class="row form-group">
      <div class="col col-xs-12 col-sm-8 col-md-6">
        <label class="right-inline">内容:</label>
        <textarea name="reason" rows="5" class="form-control"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col col-xs-12">
        <input type="submit" class="btn btn-primary" value="确认">
      </div>
    </div>
  </form>

  <script>
    $("#type").change(function () {
      if ($("#type").val() == 3 || $("#type").val() == 4) {
        $("#tips").html("如果您已经登录，我们的客服/管理员会通过站内消息联系您。如果您没有登录，请务必在内容中注明联系方式以便我们联系您。")
      } else if ($("#type").val() == 5) {
        $("#tips").html("请务必在内容中注明联系方式以便我们联系您。")
      }
    });

    function refresh_hash() {
      if (window.location.hash == "#complain") {
        $("#type").val(4);
        $("#tips").html("如果您已经登录，我们的客服/管理员会通过站内消息联系您。如果您没有登录，请务必在内容中注明联系方式以便我们联系您。")
      } else if (window.location.hash == "#bug") {
        $("#type").val(5);
        $("#tips").html("请务必在内容中注明联系方式以便我们联系您。")
      }
    }

    $(function () {
      refresh_hash();
      $(window).bind('hashchange', refresh_hash);
    })
  </script>

@endsection
