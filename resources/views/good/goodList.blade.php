@extends('layout.master')

@section('title', "商品列表")

@section('asset')
    <link rel="stylesheet" href="/css/goodlist.css" />
@endsection

@section('content')
    <div class="row">
        @include('layout.catlist')
        <div class="col-12 col-md-10">
            <p>
            <div class="row">
                <div class="col-12 col-md-3">
                    <input type="hidden" id="nm" value="@if(isset($_GET['sort'])){{ $_GET['sort'] }}@endif" style="display: none" />
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="sort" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            综合排序
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
                <div class="col-12 col-lg-5" id="ds">
                    <a>价格筛选</a> <input id="priceSet1" style="display:inline-block"maxlength="9" class="form-control" value="@if(isset($_GET['start_price'])){{ $_GET['start_price'] }}@endif"/> - <input id="priceSet2" class="form-control" style="display:inline-block" maxlength="9" value="@if(isset($_GET['end_price'])){{ $_GET['end_price'] }}@endif"/><button class="btn btn-primary" onclick="setc('a')">确定</button>
                </div>
                <div class="col-12 col-lg-5" style="display:none">
                    <a>库存下限</a> <input id="pricec" style="display:inline-block" maxlength="9" class="form-control" value="@if(isset($_GET['start_count'])){{ $_GET['start_count'] }}@endif"/><button class="btn btn-primary" id="subs" onclick="setc('a')">确定</button>
                </div>
            </div>
            </p>
            <div class="row">
                @foreach($goods as $good)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="good" style="margin-bottom:20px;">
                            <a href="/good/{{ $good->id }}">
                                <div class="card">
                                    <div class="card-img-top">
                                        <img src="/good/{{ sha1($good->id) }}/titlepic" title="{{ $good->good_name }}" style="width:100%"/>
                                    </div>
                                    <div class="card-body">
                                        <div style="word-break:break-all">{{ $good->good_name }}</div>
                                        <div class="text-warning" style="font-size: 13px"><b>￥{{ $good->price }}</b></div>
                                        @if($good->count==0)
                                            <div class="text-danger"  style="font-size: 13px;color: black">无库存QAQ</div>
                                        @else
                                            <div  style="font-size: 13px;color: black">库存：{{ $good->count }}</div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
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
    </div>
    <script src="/js/good/cat.js"></script>
    <script src="/js/good/good_list.js"></script>
    <script src="/js/jquery.color.js"></script>

@endsection