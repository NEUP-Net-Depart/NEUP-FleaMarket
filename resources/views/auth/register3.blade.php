@extends('layout.master')

@section('title', "添加联系方式")

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
            <div class="col-xs-12">
                <a href="/" class="pull-right">完成</a>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <div id="userinfo-container">
                @include('user.userInfo')
            </div>
            </div>
        </div>
    </div>

    <script>
        function createUserInfo() {
            $.ajax({
                type: "GET",
                url: "/user/userinfo/create",
                success: function (msg) {
                    $('#userinfo-container').html(msg);
                }
            })
        }
        function addUserInfo() {
            var str_data = $("#create_user_info_form input,#create_user_info_form textarea").map(function () {
                return ($(this).attr("name") + '=' + encodeURIComponent($(this).val()));
            }).get().join("&");
            $.ajax({
                type: "POST",
                url: "/user/userinfo",
                data: str_data,
                success: function (msg) {
                    $.ajax({
                        type: "GET",
                        url: "/user/userinfo",
                        success: function (msg) {
                            window.location.href = "/";
                        }
                    })
                }
            })
        }
    </script>

@endsection