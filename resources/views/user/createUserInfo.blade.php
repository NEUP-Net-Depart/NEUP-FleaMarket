<form id="create_user_info_form">
    <label>真实姓名<input type="text" name="realname"></label>
    <label>手机<input type="text" name="tel_num"></label>
    <label>QQ<input type="text" name="QQ"></label>
    <label>微信<input type="text" name="wechat"></label>
    <label>地址<textarea name="address"></textarea></label>
    {!! csrf_field() !!}
    <input type="button" onclick="addUserInfo()" class="hollow button" value="保存">
</form>