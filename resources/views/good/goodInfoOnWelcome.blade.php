<div class="yesrpg goodinfo-col col-6">
    <div class="good" style="margin-bottom:20px;">
        <a href="/good/{{ $good->id }}">
            <div class="card">
                <div class="card-img-top">
                    <div style="position:absolute;z-index:201">
                        <input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->id }}" class="cb" onclick="{setValue({{ $good->id }})}" style="visibility:hidden;width:20%;z-index:203" />
                    </div>
                    <img src="/good/{{ sha1($good->id) }}/titlepic" class="titlepic goodinfo-img"/>
                    <div class="details" style="position:absolute;z-index:200;width:100%;display:none;">
                        <div class="det-d d-none d-md-block" style="position:absolute;z-index:200;top:-37px;left:5px;color:white;font-size:12px;">
                        售价：￥{{ $good->price }}
                        <p></p>
                            @if($good->count==0)
                                无库存QAQ
                            @else
                                库存：{{ $good->count }}
                            @endif
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="word-break:break-all">
                    {{ $good->good_name }}
                </div>
            </div>
        </a>
    </div>
</div>