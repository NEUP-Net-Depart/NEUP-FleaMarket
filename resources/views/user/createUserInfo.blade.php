<form id="create_user_info_form" style="width:300px">
  <p><input type="text" name="tel_num" id="tel_num" class="form-control" placeholder="手机"></p>
  <p><input type="text" name="QQ" id="QQ" class="form-control" placeholder="QQ"></p>
  <p><input type="text" name="wechat" id="wechat" class="form-control" placeholder="微信"></p>
  <p><textarea name="address" id="address" class="form-control" placeholder="地址"></textarea></p>
  {!! csrf_field() !!}
  <div class="row">
    <div class="mx-auto">
      <input type="button" onclick="addUserInfo()" class="btn btn-primary" value="保存">
    </div>
  </div>
</form>