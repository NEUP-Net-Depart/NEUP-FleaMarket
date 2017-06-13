@extends('layout.master')

@section('title', "商品列表")

@section('asset')
    <link rel="stylesheet" href="/css/goodlist.css" />
@endsection

@section('content')
    @include('layout.catlist')
    <div class="col-xs-12 col-sm-7">
        <div>
        <div class="dropdown" style="display:inline-block">
            <button class="btn btn-primary" id="sort" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="hidden" id="nm" class="@if(isset($_GET['sort'])){{ $_GET['sort'] }}@endif">
                排序
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="sort">
                <li><a href="/good/">综合排序</a></li>
                <li><a href="#" onclick="setc('p')">按价格从低到高</a></li>
                <li><a href="#" onclick="setc('pd')">按价格从高到低</a></li>
                <li><a href="#" onclick="setc('c')">按库存从少到多</a></li>
                <li><a href="#" onclick="setc('cd')">按库存从多到少</a></li>
            </ul>
        </div>&nbsp;&nbsp;&nbsp;
        <div style="display:inline-block">
            <a>价格筛选</a> <input id="priceSet1" style="display:inline-block"maxlength="9" class="form-control" value="@if(isset($_GET['start_price'])){{ $_GET['start_price'] }}@endif"/> - <input id="priceSet2" class="form-control" style="display:inline-block" maxlength="9" value="@if(isset($_GET['end_price'])){{ $_GET['end_price'] }}@endif"/>&nbsp;<button class="btn btn-primary" onclick="setc('a')">确定</button>
        </div>&nbsp;&nbsp;&nbsp;
        <div style="display:inline-block">
            <a>库存下限</a> <input id="pricec" style="display:inline-block" maxlength="9" class="form-control" value="@if(isset($_GET['start_count'])){{ $_GET['start_count'] }}@endif"/>&nbsp;<button class="btn btn-primary" id="subs" onclick="setc('a')">确定</button>
        </div>
        </div>
        <br/>
        @foreach($goods as $good)
        <div class="col-xs-6 col-sm-4">
            <div class="good">
                <a href="/good/{{ $good->id }}">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <img src="/good/{{ sha1($good->id) }}/titlepic" title="{{ $good->good_name }}" style="width:100%"/>
                        </div>
                        <div class="panel-body">
                            <div>{{ $good->good_name }}</div>
                                <div class="text-warning"><b>￥{{ $good->price }}</b></div>
                                    @if($good->count==0)
                                        <div class="text-danger">无库存QAQ</div>
                                    @else
                                        <div>库存：{{ $good->count }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        {{ $goods->links() }}
        @endforeach
    </div>
    <script src="/js/good/cat.js"></script>
    <script src="/js/good/good_list.js"></script>
    <script src="/js/jquery.color.js"></script>
    

@endsection
