    <div id="userinfo-container">
        <table class="table table-hover table-responsive" style="width:100%">
            <tr>
                <th style="width:130px">手机</th>
                <th style="width:110px">QQ</th>
                <th style="width:110px">微信</th>
                <th>地址</th>
                <th style="width:165px">操作</th>
            </tr>

            @foreach($userinfos as $userinfo)
                <tr>
                    <td>{{ isset($userinfo->tel_num) ? $userinfo->tel_num : "" }}</td>
                    <td>{{ isset($userinfo->QQ) ? $userinfo->QQ : "" }}</td>
                    <td>{{ isset($userinfo->wechat) ? $userinfo->wechat : "" }}</td>
                    <td class="address-th">{{ isset($userinfo->address) ? $userinfo->address : "" }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="editUserInfo({{$userinfo->id}})">修改</button>
                        <button type="button" class="btn btn-danger" onclick="deleteUserInfo({{$userinfo->id}})">删除</button>
                    </td>
                </tr>
            @endforeach
        </table>
    <div class="row">
        <div class="mx-auto">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#add-form" aria-expanded="false" aria-controls="add-form"><span class="fa fa-plus"> 添加联系方式</span></button>
        </div>
    </div>
    <div class="row">
        <div class="mx-auto">
            <div class="collapse" id="add-form">
                <p>
                <div class="card card-body">
                    @include('user.createUserInfo')
                </div>
                </p>
            </div>
        </div>
    </div>
    </div>
<script>
    function editUserInfo(userinfo_id) {
        $.ajax({
            type: "GET",
            url: "/user/userinfo/edit/" + userinfo_id,
            success: function (msg) {
                $('#userinfo-container').html(msg);
                WidthChange(window.matchMedia(match_media));
            }
        })
    }

    function deleteUserInfo(userinfo_id) {
        $.ajax({
            type: "POST",
            url: "/user/userinfo/delete",
            data: {
                "_method" : "DELETE",
                "_token": "{{ csrf_token() }}",
                "id": userinfo_id
            },
            success: function (msg) {
                $.ajax({
                    type: "GET",
                    url: "/user/userinfo",
                    success: function (msg) {
                        $('#userinfo-container').html(msg);
                        WidthChange(window.matchMedia(match_media));
                    }
                })
            },
            error: function (xhr) {
                alert('删除失败');
            }
        })
    }

    function updateUserInfo() {
        var str_data = $("#modify_user_info_form input,#modify_user_info_form textarea").map(function () {
            return ($(this).attr("name") + '=' + encodeURIComponent($(this).val()));
        }).get().join("&");
        str_data = str_data + "&_method=PUT";
        $.ajax({
            type: "POST",
            url: "/user/userinfo/edit",
            data: str_data,
            success: function (msg) {
                $.ajax({
                    type: "GET",
                    url: "/user/userinfo",
                    success: function (msg) {
                        $('#userinfo-container').html(msg);
                        WidthChange(window.matchMedia(match_media));
                    }
                })
            },
            error: function (xhr) {
                alert(xhr.responseJSON[Object.keys(xhr.responseJSON)[0]]);
            }
        })
    }

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
                        $('#userinfo-container').html(msg);
                        WidthChange(window.matchMedia(match_media));
                    }
                })
            },
            error: function (xhr) {
                alert(xhr.responseJSON[Object.keys(xhr.responseJSON)[0]]);
            }
        })
    }
</script>