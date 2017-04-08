<div class="card-section">
    <form action="/user/{{$user->id}}/edit/middle" method="POST" enctype="multipart/form-data">
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