    <style>
        .cropper-crop-box, .cropper-view-box {
            border-radius: 50%;
        }

        .cropper-view-box {
            box-shadow: 0 0 0 1px #39f;
            outline: 0;
        }
    </style>
    <div class="row">
        <div class="mx-auto">
            <div id="preview"><label for="avatarUpload"><img id="avatarpreview" class="avatar" src="/avatar/{{Session::get('user_id')}}"/></label></div>
            <div style="display: none">
                <input type="file" id="avatarUpload" name="avatarPic" onchange="preview(this)"/>
            </div>
        </div>
    </div>
    <input id="avatarUploadCpWidth" type="hidden" name="crop_width">
    <input id="avatarUploadCpHeight" type="hidden" name="crop_height">
    <input id="avatarUploadCpX" type="hidden" name="crop_x">
    <input id="avatarUploadCpY" type="hidden" name="crop_y">
    <p>
    <div class="row">
        <div class="mx-auto">
            <label for="avatarUpload" class="btn btn-secondary">更改头像</label>
        </div>
    </div>
    </p>
    {!! csrf_field() !!}
    <div class="nickname-form">
        <div class="mx-auto">
            <div class="form-group">
                <label for="nickname">昵称</label>
                @if(isset($user->nickname))
                    <input type="text" name="nickname" id="nickname" class="form-control nickname-input" value="{{ $user->nickname }}">
                @else
                    <input type="text" name="nickname" id="nickname" class="form-control nickname-input">
                @endif
            </div>
        </div>
    </div>

<script>
    function preview(file) {
        var prevDiv = document.getElementById('preview');
        if (file.files && file.files[0]) {
            var prreader = new FileReader();
            var reader = new FileReader();
            reader.onload = function (evt) {
                prevDiv.innerHTML = '<img id="avatarpreview" class="avatar" src="' + evt.target.result + '"/>';
                $('#avatarpreview').cropper({
                    aspectRatio: 1 / 1,
                    autoCropArea: 1,
                    dragCrop: false,
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
                /*var mime = isImage(fileBuf);
                if (mime == null) {
                    alert("Please open image!");
                    return;
                } else {*/
                    reader.readAsDataURL(file.files[0]);
                //}
            };
            prreader.readAsArrayBuffer(file.files[0]);
        } else {
            prevDiv.innerHTML = '<div class="img" class="avatar" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }
</script>