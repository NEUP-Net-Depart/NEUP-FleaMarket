@extends('layout.master')

@section('title', "添加联系方式")

@section('content')

    <div class="row card">
        <div class="row" style="margin-top: 5px">
            <div class="small-offset-10 small-2 medium-offset-11 medium-1">
                <a href="/">跳过</a>
            </div>
        </div>
        <div class="small-12 medium-10 small-centered columns card-section">
            @if (count($errors) > 0)
                <label>
                    <span class="form-error is-visible">{!! $errors->first() !!}</span>
                </label>
            @endif
            <div id="userinfo-container">
                @include('user.userInfo')
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