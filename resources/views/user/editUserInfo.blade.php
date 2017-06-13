<form id="modify_user_info_form">
    <input type="hidden" type="text" name="id" value="{{$userinfo[0]->id}}">
    <label>手机<input type="text" name="tel_num" value="{{$userinfo[0]->tel_num}}"></label>
    <label>QQ<input type="text" name="QQ" value="{{$userinfo[0]->QQ}}"></label>
    <label>微信<input type="text" name="wechat" value="{{$userinfo[0]->wechat}}"></label>
    <label>地址<textarea name="address">{{$userinfo[0]->address}}</textarea></label>
    {!! csrf_field() !!}
    <input type="button" onclick="updateUserInfo()" class="hollow button" value="保存">
</form>