<div class="yesrpg popular-children-col" style="max-width:175px;min-width:175px;padding-left:5px;padding-right:5px">
<div class="good" style="margin-bottom:20px;">
    <a href="/good/{{ $good->id }}">
        <div class="card">
            <div class="card-img-top">
                <div style="position:absolute;z-index:201">
                    <input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->id }}" class="cb" onclick="{setValue({{ $good->id }})}" style="visibility:hidden;width:20%;z-index:203" />
                </div>
                <img src="/good/{{ sha1($good->id) }}/titlepic" class="titlepic" style="height:91.69px;width:165px"/>
                <div class="details" style="position:absolute;z-index:200;width:100%;display:none;">
                    <div class="det-d d-none d-md-block" style="position:absolute;z-index:200;top:-20px;left:5px;color:white;font-size:12px;">
                        {{ $good->good_name }}
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
</div>