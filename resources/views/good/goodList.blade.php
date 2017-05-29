@extends('layout.master')

@section('title', "商品列表")

@section('content')
    <div class="medium-offset-2" style="font-size:13px;">
<ul class="menu">
    <li><a class="x" href="/good/">综合排序</a></li>
    <li><a class="x" href="/good/?sort=p" id="ppx">按价格从低到高</a></li>
    <li><a class="x" href="/good/?sort=pd" id="ppx">按价格从高到低</a></li>
    <li><a class="x" href="/good/?sort=c" id="cpx">按库存从少到多</a></li>
    <li><a class="x" href="/good/?sort=cd" id="cpx">按库存从多到少</a></li>
</ul>
        <ul class="menu">
            <li><a class="x">价格：</a></li>
            <li><input id="priceSet1" style="width:60px;" maxlength="9" value="<?php if(isset($_GET['start_price'])){echo $_GET['start_price']; } ?>"/>-<input id="priceSet2" style="width:60px;" maxlength="9" value="<?php if(isset($_GET['end_price'])){echo $_GET['end_price']; } ?>"/>&nbsp;<button class="button" style="width:40px;height:20px;font-size:9px;text-align:center; padding-top:4px;" onclick="setprice()">yes!</button></li>
            <li><a class="x">库存下限：</a></li>
            <li><input id="pricec" style="width:60px;" maxlength="9" value="<?php if(isset($_GET['start_count'])){echo $_GET['start_count']; } ?>" /><button class="button" style="width:40px;height:20px;font-size:9px;text-align:center; padding-top:4px;" onclick="setc()">yes!</button></li>
        </ul>
    </div>
    <div class="row">
        <div class="small-0 medium-2 columns">
            <ul class="menu vertical">
                <li @if($cat_id == 0) class="active" @else class="cat" @endif><a href="/good">所有商品</a></li>
                @foreach($cats as $cat)
                    <li @if($cat_id == $cat->id) class="active" @else class="cat" @endif><a
                                href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="small-12 medium-10 columns">
            <div class="row small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row>
                @foreach($goods as $good)
                    <div class="columns" id="good{{ $good->id }}">
                        <div class="good">
                        <a href="/good/{{ $good->id }}">
                            <div class="card">
                                <div class="card-divider" style="padding: 0;">
                                    <img src="/good/{{ sha1($good->id) }}/titlepic"/>
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
        {{ $goods->links() }}
    </div>
    <script src="/js/good/cat.js"></script>
    <script src="/js/good/good_list.js"></script>
    <script src="/js/jquery.color.js"></script>
    

@endsection
