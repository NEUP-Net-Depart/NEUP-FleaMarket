@extends('layout.master')

@section('title', "商品列表")

@section('asset')
    <link rel="stylesheet" href="/css/goodlist.css" />
@endsection

@section('content')
    <div class="row">
    @include('layout.catlist')
    <div class="hidden-md-up">&nbsp;</div>
    <div class="col-12 col-md-10">
        <div class="row">
            <div class="col-12 col-md-2">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" id="sort" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <input type="hidden" id="nm" class="@if(isset($_GET['sort'])){{ $_GET['sort'] }}@endif">
                    排序
                </button>
                <div class="dropdown-menu" aria-labelledby="sort">
                    <a href="/good/" class="dropdown-item">综合排序</a>
                    <a href="#" onclick="setc('p')" class="dropdown-item">按价格从低到高</a>
                    <a href="#" onclick="setc('pd')" class="dropdown-item">按价格从高到低</a>
                    <a href="#" onclick="setc('c')" class="dropdown-item">按库存从少到多</a>
                    <a href="#" onclick="setc('cd')" class="dropdown-item">按库存从多到少</a>
                </div>
            </div>
            </div>
            <div class="col-12 col-lg-6">
                <a>价格筛选</a> <input id="priceSet1" style="display:inline-block"maxlength="9" class="form-control" value="@if(isset($_GET['start_price'])){{ $_GET['start_price'] }}@endif"/> - <input id="priceSet2" class="form-control" style="display:inline-block" maxlength="9" value="@if(isset($_GET['end_price'])){{ $_GET['end_price'] }}@endif"/>&nbsp;<button class="btn btn-primary" onclick="setc('a')">确定</button>
            </div>
            <div class="col-12 col-lg-4">
                <a>库存下限</a> <input id="pricec" style="display:inline-block" maxlength="9" class="form-control" value="@if(isset($_GET['start_count'])){{ $_GET['start_count'] }}@endif"/>&nbsp;<button class="btn btn-primary" id="subs" onclick="setc('a')">确定</button>
            </div>
        </div>
        <br/>
        <div class="row">
        @foreach($goods as $good)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="good">
                <a href="/good/{{ $good->id }}">
                    <div class="card">
                        <div class="card-img-top">
                            <img src="/good/{{ sha1($good->id) }}/titlepic" title="{{ $good->good_name }}" style="width:100%"/>
                        </div>
                        <div class="card-block">
                            <div style="word-break:break-all">{{ $good->good_name }}</div>
                            <div class="text-warning"><b>￥{{ $good->price }}</b></div>
                            @if($good->count==0)
                                <div class="text-danger">无库存QAQ</div>
                            @else
                                <div>库存：{{ $good->count }}</div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        </div>
        {{ $goods->links() }}
        @endforeach
        </div>
    </div>
    </div>
    <script src="/js/good/cat.js"></script>
    <script src="/js/good/good_list.js"></script>
    <script src="/js/jquery.color.js"></script>
    

@endsection
