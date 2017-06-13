@extends('layout.master')

@section('title', "即将打开新的大门")

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
                <div class="row">
                    <div class="bs-callout bs-callout-info" role="alert">
                        如果你希望在先锋市场出售物品，你还<b>需要</b>添加至少一种联系方式。其他用户会在与你开始某件商品的交易时将可以看到你的联系方式。
                    </div>
                </div>
                <div class="row">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100" style="width: 67%;">
                            <span class="sr-only">67% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="userinfo-container">
                        @include('user.userInfo')
                    </div>
                </div>
                <div class="row">
                    <div class="pull-right">
                        <a href="/" class="pull-right btn btn-default">完成</a>
                    </div>
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