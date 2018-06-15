<div class="yesrpg col-md-4">
  <div class="good" style="margin-bottom:20px;">
    <a href="/good/{{ $good->id }}">
      <div class="card">
        <div class="card-img-top">
          <div style="position:absolute;z-index:201">
            <input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->id }}" class="cb"
                   onclick="{setValue({{ $good->id }})}" style="visibility:hidden;width:20%;z-index:203" />
          </div>
          <img src="/good/{{ sha1($good->id) }}/titlepic" class="titlepic" style="width:100%" />
          <div class="details" style="position:absolute;z-index:200;width:100%;display:none;">
            <div class="det-d d-none d-md-block"
                 style="position:absolute;z-index:200;top:-20px;left:5px;color:white;font-size:12px;">
              {{ $good->good_name }}
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>