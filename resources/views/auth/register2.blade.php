@extends('layout.master')

@section('title', "注册")

@section('content')

    <div class="row card">
        <div class="row">
            <div class="small-offset-11 small-1">
                <a href="/register/3">跳过</a>
            </div>
        </div>
        <div class="medium-4 medium-centered small-8 small-centered columns card-section">
            @if (count($errors) > 0)
                <label>
                    <span class="form-error is-visible">{!! $errors->first() !!}</span>
                </label>
            @endif
            <form action="/register/2" method="POST" enctype="multipart/form-data">
                <div class="row">
                    @if(isset($user->nickname))
                        <label>昵称<input type="text" name="nickname" value="{{ $user->nickname }}"></label>
                    @else
                        <label>昵称<input type="text" name="nickname"></label>
                    @endif
                    {!! csrf_field() !!}
                    <input type="submit" class="hollow button" value="保存">
                </div>
                <div class="row">
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
            </form>
        </div>
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