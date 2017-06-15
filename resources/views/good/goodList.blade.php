@extends('layout.master')

@section('title', "商品列表")

@section('asset')
    <link rel="stylesheet" href="/css/goodlist.css" />
@endsection

@section('content')

    <div class="row">
        <div class="small-0 medium-2 columns">
            <ul class="menu vertical hide-for-small-only">
                <li class="byj"><a href="/good?cat_id=5" @if($cat_id == 5) style="color: #ffffff; background-color: #ff172e" @else style="color: #ffffff; background-color: #ff5d73" @endif>毕业季活动</a></li>
                <li @if($cat_id == 0) class="active" @else class="cat" @endif><a href="/good">所有商品</a></li>
                @foreach($cats as $cat)
                    @if($cat->cat_name != "毕业季活动")
                        <li @if($cat_id == $cat->id) class="active" @else class="cat" @endif><a
                                    href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
                    @endif
                @endforeach
            </ul>
            <ul class="menu show-for-small-only" style="background-color: white;margin-bottom: 15px">
                <li class="byj"><a href="/good?cat_id=5" @if($cat_id == 5) style="color: #ffffff; background-color: #ff172e" @else style="color: #ffffff; background-color: #ff5d73" @endif>毕业季活动</a></li>
                <li @if($cat_id == 0) class="active" @else class="cat" @endif><a href="/good">所有商品</a></li>
            </ul>
        </div>
        <div class="small-12 medium-10 columns">
            <div class="row small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row>
                <div class="medium-12 shx">
                    <ul class="dropdown menu" style="background-color: white;" data-dropdown-menu>
                        <li>
                        <a id="nm" class="@if(isset($_GET['sort'])){{$_GET['sort']}}@endif">排序</a>
                        <ul class="menu">
                        <li><a href="/good/">综合排序</a></li>
                        <li><a onclick="setc('p')">按价格从低到高</a></li>
                        <li><a onclick="setc('pd')">按价格从高到低</a></li>
                        <li><a onclick="setc('c')">按库存从少到多</a></li>
                        <li><a onclick="setc('cd')">按库存从多到少</a></li>
                        </ul>
                        </li>
                        <li>
                            <a id="sxa"><div class="ad">价格筛选</div> <input id="priceSet1" style="" maxlength="9" value="@if(isset($_GET['start_price'])){{$_GET['start_price']}}@endif"/>-<input id="priceSet2" style="" maxlength="9" value="@if(isset($_GET['end_price'])){{$_GET['end_price']}}@endif"/>&nbsp;<button class="button sub" id="subk"  onclick="setc('a')">确定</button>
                            </a>
                        </li>
                        <li class="kucli">
                            <a id="kca"><div class="ad">库存下限</div> <input id="pricec" maxlength="9" style="" value="@if(isset($_GET['start_count'])){{$_GET['start_count']}}@endif" />&nbsp;<button class="button sub" id="subs"  onclick="setc('a')">确定</button>
                            </a>
                           </li>
                        </li>
                    </ul>
                </div>
                <div class="sm1 row" style="margin-left:1px;margin-right:5px">
                @foreach($goods as $good)
                    <div class="small-6 medium-3 end columns blck" id="good{{ $good->id }}">
                        <div class="good">
                        <a href="/good/{{ $good->id }}">
                            <div class="card">
                                <div class="card-divider" style="padding: 0;">
                                    <img src="/good/{{ sha1($good->id) }}/titlepic" title="{{ $good->good_name }}"/>
                                </div>
                                <div class="card-section" >
                                    <div class="one-line-text" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{ $good->good_name }}</div>
                                    <div style="color: #cc4b37;" class="one-line-text"><b>￥{{ $good->price }}</b></div>
                                    @if($good->count==0)
                                        <div style="color: #ffae00;" class="one-line-text">无库存QAQ</div>
                                    @else
                                        <div class="one-line-text">库存：{{ $good->count }}</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                        </div>
					</div>
                @endforeach
                </div>
            </div>
        </div>
        {{ $goods->appends([
                'start_price' => $start_price,
                'end_price' => $end_price,
                'start_count' => $start_count,
                'sort' => $sort,
                'query' => $query,
                'cat_id' => $cat_id
            ])
        ->links() }}
    </div>
    <script src="/js/good/cat.js"></script>
    <script src="/js/good/good_list.js"></script>
    <script src="/js/jquery.color.js"></script>
    

@endsection
