    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            {!! $errors->first() !!}
        </div>
    @endif
    @if(isset($user->nickname))
        <div class="form-group">
            <label for="nickname">昵称</label>
            <input type="text" name="nickname" id="nickname" class="form-control" value="{{ $user->nickname }}"></label>
        </div>
    @else
        <div class="form-group">
            <label for="nickname">昵称</label>
            <input type="text" name="nickname" id="nickname" class="form-control"></label>
        </div>
    @endif
    {!! csrf_field() !!}
    <label for="avatarUpload" class="btn btn-primary">选择头像</label>
    <div id="preview"></div>
    <div style="display: none">
        <input type="file" id="avatarUpload" class="show-for-sr" name="avatarPic"
               onchange="preview(this)"/>
    </div>
    <input id="avatarUploadCpWidth" type="hidden" name="crop_width">
    <input id="avatarUploadCpHeight" type="hidden" name="crop_height">
    <input id="avatarUploadCpX" type="hidden" name="crop_x">
    <input id="avatarUploadCpY" type="hidden" name="crop_y">

<script>
    function preview(file) {
        var prevDiv = document.getElementById('preview');
        if (file.files && file.files[0]) {
            var prreader = new FileReader();
            var reader = new FileReader();
            reader.onload = function (evt) {
                prevDiv.innerHTML = '<br/><img id="avatarpreview" src="' + evt.target.result + '" />';
                $jQuery_CROPPER('#avatarpreview').cropper({
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
            prevDiv.innerHTML = '<br/><div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }
</script>