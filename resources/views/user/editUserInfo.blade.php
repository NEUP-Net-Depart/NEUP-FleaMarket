<div class="row">
<div class="mx-auto">
<form id="modify_user_info_form">
    <input type="hidden" type="text" name="id" value="{{$userinfo[0]->id}}">
    <div class="form-group">
        <label for="tel_num">手机</label>
        <input type="text" name="tel_num" id="tel_num" class="form-control" value="{{$userinfo[0]->tel_num}}">
    </div>
    <div class="form-group">
        <label for="QQ">QQ</label>
        <input type="text" name="QQ" id="QQ" class="form-control" value="{{$userinfo[0]->QQ}}">
    </div>
    <div class="form-group">
        <label for="wechat">微信</label>
        <input type="text" name="wechat" id="wechat" class="form-control" value="{{$userinfo[0]->wechat}}">
    </div>
    <div class="form-group">
        <label for="address">地址</label>
        <textarea name="address" id="address" class="form-control">{{$userinfo[0]->address}}</textarea>
    </div>
    {!! csrf_field() !!}
    <div class="row">
        <div class="mx-auto">
            <input type="button" onclick="updateUserInfo()" class="btn btn-primary" value="保存">
        </div>
    </div>
</form>
</div>
</div>