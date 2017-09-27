@extends('layout.master')

@section('title', "商品列表")

@section('asset')
    <link rel="stylesheet" href="/css/goodlist-20170927.css"/>
    <script src="/js/good/good_list-20170927.js"></script>
@endsection

@section('content')
<div class="row">
    <input type="hidden" id="nm" value="@if(isset($_GET['sort'])){{ $_GET['sort'] }}@endif" class="d-none"/>
    <div class="col-auto nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" id="sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">商品排序</a>
        <div class="dropdown-menu" aria-labelledby="sort">
            <a href="/good" class="dropdown-item">默认排序</a>
            <a href="#" onclick="setc('p')" class="dropdown-item">按价格从低到高</a>
            <a href="#" onclick="setc('pd')" class="dropdown-item">按价格从高到低</a>
            <a href="#" onclick="setc('c')" class="dropdown-item">按库存从少到多</a>
            <a href="#" onclick="setc('cd')" class="dropdown-item">按库存从多到少</a>
        </div>
    </div>
    <div class="d-none" id="ds">
        <a>价格筛选</a>
        <input id="priceSet1" class="form-control" value="@if(isset($_GET['start_price'])){{ $_GET['start_price'] }}@endif"/> - <input id="priceSet2" class="form-control" value="@if(isset($_GET['end_price'])){{ $_GET['end_price'] }}@endif"/>
        <button class="btn btn-primary" onclick="setc('a')">确定</button>
    </div>
    <div class="col-auto nav-item dropdown" style="list-style-type:none;">
        <a class="nav-link dropdown-toggle" href="#" role="button" id="price" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">价格区间</a>
        <div class="dropdown-menu" aria-labelledby="price">
            <a href="/good" class="dropdown-item">无限制</a>
            <a class="dropdown-item" href="#" onclick="price(0,20)">0-20</a>
            <a class="dropdown-item" href="#" onclick="price(20,50)">20-50</a>
            <a class="dropdown-item" href="#" onclick="price(50,300)">50-300</a>
            <a class="dropdown-item" href="#" onclick="price2(300)">>300</a>
        </div>
    </div>
</div>

<p></p>

<div class="row">
    @foreach($goods as $good)
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="good">
                <a href="/good/{{ $good->id }}">
                    <div class="card">
                        <img src="/good/{{ sha1($good->id) }}/titlepic" title="{{ $good->good_name }}" class="card-img-top"/>
                        <div class="card-body">
                            <div>{{ $good->good_name }}</div>
                            <div class="text-warning" style="font-size:13px"><b>￥{{ $good->price }}</b></div>
                            @if($good->count==0)
                                <div class="text-dark" style="font-size:13px">无库存QAQ</div>
                            @else
                                <div class="text-dark" style="font-size:13px">库存：{{ $good->count }}</div>
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
])->links() }}
@endsection