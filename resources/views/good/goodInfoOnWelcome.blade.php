<div class="yesrpg col-6 col-md-4 col-lg-2">
    <div class="good" style="margin-bottom:20px;">
        <a href="/good/{{ $good->id }}">
            <div class="card" style="box-shadow:1px 1px 2px #aaaaaa;border-style:none">
                <div class="card-img-top">
                    <div style="position:absolute;z-index:201">
                        <input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->id }}" class="cb" onclick="{setValue({{ $good->id }})}" style="visibility:hidden;width:20%;z-index:203" />
                    </div>
                    <img src="/good/{{ sha1($good->id) }}/titlepic" class="titlepic goodinfo-img"/>
                    <div class="details" style="position:absolute;z-index:200;width:100%;display:none;">
                        <div class="det-d d-none d-md-block" style="position:absolute;z-index:200;top:-37px;left:5px;color:lightgrey;font-size:12px;">
                        售价：￥{{ $good->price }}
                        <br/>
                            @if($good->count==0)
                                无库存QAQ
                            @else
                                库存：{{ $good->count }}
                            @endif
                        </div>
                    </div>
                    <div class="d-block d-sm-none" style="position:absolute;z-index:200;width:100%;height:25%;">
                        <div class="det-d" style="position:absolute;z-index:200;top:-18px;color:black;font-size:12px;filter:opacity(50%);background-color: black;right:0;border-radius:5px 0px 0 0px;">
                            ￥{{ $good->price }}&nbsp;
                        </div>
                        <div class="det-d" style="position:absolute;z-index:201;top:-18px;color:white;font-size:12px;right:0;">
                            <span>￥{{ $good->price }}&nbsp;</span>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="word-break:break-all;font-size:12px;padding:3px 7px;color:black;filter:opacity(90%);height:40px;">
                   <p style="max-height:100%;margin:0; overflow:hidden;">{{ $good->good_name }}</p>
                </div>
            </div>
        </a>
    </div>
</div>