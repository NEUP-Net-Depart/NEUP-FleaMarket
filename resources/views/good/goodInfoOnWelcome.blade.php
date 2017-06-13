<div class="col-xs-6 col-sm-4">
<div class="good">
    <a href="/good/{{ $good->id }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="position:absolute;z-index:201">
                    <input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->good_id }}" class="cb" onclick="{setValue({{ $good->good_id }})}" style="visibility:hidden;width:20%;z-index:203" />
                </div>
                <img src="/good/{{ sha1($good->id) }}/titlepic" class="titlepic"/>
                <div class="details" style="position:absolute;z-index:200;width:100%;display:none;">
                    <div class="det-d hidden-xs" style="position:absolute;z-index:200;top:-42px;left:5px;color:white;font-size:12px;">
                        售价：￥{{ $good->price }}<br/>
                        @if($good->count==0)
                            无库存QAQ
                        @else
                            库存：{{ $good->count }}
                        @endif
                    </div>
                    <div class="det-d visible-xs-block" style="position:absolute;z-index:200;top:-42px;left:5px;color:white;font-size:15px;">
                        售价：￥{{ $good->price }}<br/>
                        @if($good->count==0)
                            无库存QAQ
                        @else
                            库存：{{ $good->count }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {{ $good->good_name }}
            </div>
        </div>
    </a>
</div>
</div>