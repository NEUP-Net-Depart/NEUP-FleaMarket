@extends('layout.master')

@section('title', "编辑用户")

@section('asset')

    <style>
        .avatarpreview {
            max-width: 100%;
        }
    </style>

@endsection

@section('content')

    <div class="page-content">
        <form action="/user/{{$user->id}}/edit/middle" method="POST" enctype="multipart/form-data">
            <ul class="tabs" data-tabs id="editinfo">
                <li class="tabs-title is-active"><a href="#avatar" aria-selected="true">头像</a></li>
                <li class="tabs-title"><a href="#studentid">学号审核</a></li>
                <li class="tabs-title"><a href="#userinfo">个人信息</a></li>
            </ul>
            <div class="tabs-content" data-tabs-content="editinfo">
                <div class="tabs-panel" id="avatar">
                    <label for="avatarUpload" class="button right inline">上传头像</label>
                    <div id="preview"></div>
                    <div style="display: none">
                        <input type="file" id="avatarUpload" class="show-for-sr" name="avatarPic"
                               onchange="preview(this)"/>
                    </div>
                    <input id="avatarUploadCpWidth" type="hidden" name="crop_width">
                    <input id="avatarUploadCpHeight" type="hidden" name="crop_height">
                    <input id="avatarUploadCpX" type="hidden" name="crop_x">
                    <input id="avatarUploadCpY" type="hidden" name="crop_y">
                    <input class="button" type="submit" name="submit" value="上传">
                </div>
                <div class="tabs-panel" id="studentid">
                </div>
                <div class="tabs-panel" id="userinfo">
                    性别:
                    <select name="gender">
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                    真实姓名：
                    <input type="text" name="realname">
                    手机号：
                    <input type="text" name='tel_num'>
                    地址：
                    <input type="text" name="address">
                    {!! csrf_field() !!}
                    <input class="button" type="submit" name="submit" value="修改">
                </div>
            </div>
    </div>
    </form>
    </div>
    <script>
        function preview(file) {
            var prevDiv = document.getElementById('preview');
            if (file.files && file.files[0]) {
                var prreader = new FileReader();
                var reader = new FileReader();
                reader.onload = function (evt) {
                    prevDiv.innerHTML = '<img id="avatarpreview" src="' + evt.target.result + '" />';
                    $('#avatarpreview').cropper({
                        aspectRatio: 1 / 1,
                        crop: function (e) {
                            $('#avatarUploadCpX').val(e.x);
                            $('#avatarUploadCpY').val(e.y);
                            $('#avatarUploadCpWidth').val(e.width);
                            $('#avatarUploadCpHeight').val(e.height);
                        }
                    });
                };
                prreader.onload = function (evt) {
                    var fileBuf = new Uint8Array(evt.target.result.slice(0, 11));
                    var mime = isImage(fileBuf);
                    if (mime == null) {
                        alert("Please open image!");
                        return;
                    } else {
                        reader.readAsDataURL(file.files[0]);
                    }
                };
                prreader.readAsArrayBuffer(file.files[0]);
            } else {
                prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
            }
        }
    </script>

@endsection