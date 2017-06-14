    @if(count($userinfos) != 0)
        <table class="table table-hover table-responsive">
            <tr>
                <th>手机</th>
                <th>QQ</th>
                <th>微信</th>
                <th>地址</th>
                <th>操作</th>
            </tr>

            @foreach($userinfos as $userinfo)
                <tr>
                    <td>{{ isset($userinfo->tel_num) ? $userinfo->tel_num : "" }}</td>
                    <td>{{ isset($userinfo->QQ) ? $userinfo->QQ : "" }}</td>
                    <td>{{ isset($userinfo->wechat) ? $userinfo->wechat : "" }}</td>
                    <td>{{ isset($userinfo->address) ? $userinfo->address : "" }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="editUserInfo({{$userinfo->id}})">修改</button>
                        <button type="button" class="btn btn-primary" onclick="deleteUserInfo({{$userinfo->id}})">删除</button>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    <a href="javascript: createUserInfo()">
        <center>添加联系方式</center>
    </a>

<script>
    function editUserInfo(userinfo_id) {
        $.ajax({
            type: "GET",
            url: "/user/userinfo/edit/" + userinfo_id,
            success: function (msg) {
                $('#userinfo-container').html(msg);
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
                    }
                })
            },
            error: function (xhr) {
                alert(xhr.responseJSON[Object.keys(xhr.responseJSON)[0]]);
            }
        })
    }
</script>