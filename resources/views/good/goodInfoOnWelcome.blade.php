<div class="col-xs-6 col-sm-4">
<div class="good">
    <a href="/good/{{ $good->id }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <img src="/good/{{ sha1($good->id) }}/titlepic" class="titlepic"/>
                <div class="details" style="position:absolute;z-index:200;width:100%;display:none;">
                    <div class="det-d hidden-xs" style="position:absolute;z-index:200;top:-35px;left:5px;color:white;font-size:12px;">
                        售价：￥{{ $good->price }}<br/>
                        @if($good->count==0)
                            无库存QAQ
                        @else
                            库存：{{ $good->count }}
                        @endif
                    </div>
                    <div class="det-d visible-xs-block" style="position:absolute;z-index:200;top:-50%;left:+2%;color:white;font-size:15px;">
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