<form id="create_user_info_form">
    <div class="form-group col-10 offset-1 col-md-6 offset-md-3">
        <label for="tel_num">手机</label>
        <input type="text" name="tel_num" id="tel_num" class="form-control">
    </div>
    <div class="form-group col-10 offset-1 col-md-6 offset-md-3">
        <label for="QQ">QQ</label>
        <input type="text" name="QQ" id="QQ" class="form-control">
    </div>
    <div class="form-group col-10 offset-1 col-md-6 offset-md-3">
        <label for="wechat">微信</label>
        <input type="text" name="wechat" id="wechat" class="form-control">
    </div>
    <div class="form-group col-10 offset-1 col-md-6 offset-md-3">
        <label for="address">地址</label>
        <textarea name="address" id="address" class="form-control"></textarea>
    </div>
    {!! csrf_field() !!}
    <div class="form-group col-10 offset-1 col-md-6 offset-md-3">
        <input type="button" onclick="addUserInfo()" class="btn btn-primary" value="保存">
    </div>
</form>