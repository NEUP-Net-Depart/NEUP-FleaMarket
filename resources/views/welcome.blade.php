@extends('layout.master')

@section('title', "首页")

@section('asset')
    <link rel="stylesheet" href="/css/wel.css" />

<style>
.slide-title{
    background: rgba(0,0,0,.5);
    color: #fff;
    height: 34px;
    line-height: 34px;
    padding: 0 10px;
    font-size: 12px;
    font-weight: bold;    
}
.slide-title span{
    float: left;
    margin-right: 0px;    
}
.slide-title span:nth-child(1),
.slide-list li span:nth-child(1){
    width: 1500px;
}
.slide-title span:nth-child(2),
.slide-list li span:nth-child(2){
    width: 1500px;
}
.slide-title span:nth-child(3),
.slide-list li span:nth-child(3){
	width: 1500px;
}

.slide-container{
	position: relative;
	overflow: hidden;
	height: 90px;
}
.slide-list{
	position: absolute;
	width: 100%;
	left: 0;
	top: 0;
	color: #000;
	margin: 0;
    padding: 0;
}
.slide-list li {
	height: 30px;
	line-height: 30px;
	list-style: none;
	margin: 0;
	padding: 3px;
}
.slide-list li span {
	display: inline-block;
	margin-right: 0px;
	font-size: 13px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}
.slide-list li.odd{
    background: rgba(51,79,109,.2);
}
</style>

<script>
var doscroll = function(){
	var $parent = $('.js-slide-list');
	var $first = $parent.find('li:first');
	var height = $first.height();
	$first.animate({
		marginTop: -height + 'px'
		}, 500, function() {
		$first.css('marginTop', 0).appendTo($parent);
	});    
};
setInterval(function(){doscroll()}, 2000);
</script>

@endsection


@section('content')

    <div class="row">
        <div class="medium-2 columns hide-for-small-only">
            <ul class="menu vertical">
                <li class="cat"><a href="/good">所有商品</a></li>
                @foreach($cats as $cat)
                    <li class="cat"><a
                                href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="show-for-small-only ddd">
            <ul class="menu">
                <li class="cat"><a href="/good">所有商品</a></li>
                @foreach($cats as $cat)
                    <li class="cat"><a
                                href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="small-12 medium-10 columns">
            <div class="row">
                <div class="medium-12 large-7 columns">
                    <div class="row">
                    @if(count($stargoods) > 0)
                        <div class="orbit" role="region" aria-label="推荐商品" data-orbit>
                            <ul class="orbit-container">
                                @if(count($stargoods) > 1)
                                    <button class="orbit-previous"><span class="show-for-sr">←</span>&#9664;&#xFE0E;</button>
                                    <button class="orbit-next"><span class="show-for-sr">→</span>&#9654;&#xFE0E;</button>
                                @endif
                                @foreach($stargoods as $good)
                                    <li class="orbit-slide">
                                        <a href="/good/{{ $good->id }}"><img class="orbit-image"
                                                                             src="/good/{{ sha1($good->id) }}/titlepic"
                                                                             alt="{{ $good->name }}"/>
                                            <figcaption class="orbit-caption">{{ $good->good_name }}</figcaption>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <br/>
                    @endif
                    </div>
                    @if(count($populargoods)>0)
                        <h3>热门</h3>
                        <div class="row small-up-2 medium-up-4 large-up-3">
                            @foreach($populargoods as $good)
                                <div class="columns">
                                    <div class="good">
                                        <a href="/good/{{ $good->id }}">
                                            <div class="card">
                                                <div class="card-divider" style="padding:0;">
                                                    <img src="/good/{{ sha1($good->id) }}/titlepic"/>
                                                </div>
                                                <div class="details" style="position:absolute;z-index:200;width:200px;height:100px;display:none;">
                                                    <div class="det-d hide-for-small-only" style="position:absolute;z-index:200;top:-40%;left:+2%;color:white;font-size:12px;">
                                                        售价：￥{{ $good->price }}<br/>
                                                        @if($good->count==0)
                                                            无库存QAQ
                                                        @else
                                                            库存：{{ $good->count }}
                                                        @endif
                                                    </div>
                                                    <div class="det-d show-for-small-only" style="position:absolute;z-index:200;top:-50%;left:+2%;color:white;font-size:15px;">
                                                        售价：￥{{ $good->price }}<br/>
                                                        @if($good->count==0)
                                                            无库存QAQ
                                                        @else
                                                            库存：{{ $good->count }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-section sec-name"style=";white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-size:15px;padding:10px 10px">
                                                    {{ $good->good_name }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if(count($newgoods)>0)
                        <h3>新品</h3>
                        <div class="row small-up-2 medium-up-4 large-up-3">
                            @foreach($newgoods as $good)
                                <div class="columns">
                                    <div class="good">
                                        <a href="/good/{{ $good->id }}">
                                            <div class="card">
                                                <div class="card-divider" style="padding:0;">
                                                    <img src="/good/{{ sha1($good->id) }}/titlepic"/>
                                                </div>
                                                <div class="details" style="position:absolute;z-index:200;width:200px;height:100px;display:none;">
                                                    <div class="det-d hide-for-small-only" style="position:absolute;z-index:200;top:-40%;left:+2%;color:white;font-size:12px;">
                                                        售价：￥{{ $good->price }}<br/>
                                                        @if($good->count==0)
                                                            无库存QAQ
                                                        @else
                                                            库存：{{ $good->count }}
                                                        @endif
                                                    </div>
                                                    <div class="det-d show-for-small-only" style="position:absolute;z-index:200;top:-50%;left:+2%;color:white;font-size:15px;">
                                                        售价：￥{{ $good->price }}<br/>
                                                        @if($good->count==0)
                                                            无库存QAQ
                                                        @else
                                                            库存：{{ $good->count }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-section sec-name"style=";white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-size:15px;padding:10px 10px">
                                                    {{ $good->good_name }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <h3>随便看看</h3>
                    @foreach($cats as $cat)
                        @if(count($catgoods[$cat->cat_name]))
                            <h4>{{ $cat->cat_name }}</h4>
                            <div class="row small-up-2 medium-up-4 large-up-3">
                                @foreach($catgoods[$cat->cat_name] as $good)
                                    <div class="columns">
                                        <div class="good">
                                            <a href="/good/{{ $good->id }}">
                                                <div class="card">
                                                    <div class="card-divider" style="padding:0;">
                                                        <img src="/good/{{ sha1($good->id) }}/titlepic"/>
                                                    </div>
                                                    <div class="details" style="position:absolute;z-index:200;width:200px;height:100px;display:none;">
                                                        <div style="position:absolute;z-index:200;top:-40%;left:+1%;color:white;font-size:12px;">
                                                            售价：￥{{ $good->price }}<br/>
                                                            @if($good->count==0)
                                                                无库存QAQ
                                                            @else
                                                                库存：{{ $good->count }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-section" style=";white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-size:15px;padding:10px 10px">
                                                        {{ $good->good_name }}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="large-5 columns">
                    <div class="row">
                        <div class="medium-10 medium-offset-2 columns">
                            <div class="card">
                                <h4 class="card-divider">公告</h4>
                                @foreach($announces as $announce)
                                    <a href="/notice/{{ $announce->id }}" class="card-item">
                                        <div class="card-section">{{ $announce->title }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="medium-10 medium-offset-2 columns">
							<div class="slide-title">
								<h4>交易公示牌OvO</h4>
							</div>
							<div class="slide-container">
								<ul class="slide-list js-slide-list">
								@foreach($trans as $tran)
								@if($tran->seller != NULL)
									<li class="odd"><span>恭喜{{$tran->seller->getcoding()}}和{{$tran->buyer->getcoding()}}成功完成了一笔交易！OvO</span></li>
								@endif
								@endforeach
								</ul>
							</div>
						</div>
					</div>
                </div>
            </div>
            <script src="/js/good/cat.js"></script>
            <script src="/js/good/editfav.js"></script>
            <script src="/js/jquery.color.js"></script>
        </div>
    </div>
@endsection
