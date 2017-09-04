@extends('layout.master')

@section('title', "首页")

@section('asset')
    <style>
    @media (max-width: 640px){
        .det-d{
            font-size: 30px;
        }
    }
    </style>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
@endsection


@section('content')
<div class="row">
    <div id="carouselStarGoodIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($stargoods as $stargood)
                <li data-target="#carouselStarGoodIndicators" data-slide-to="{{ $stargood->id }}" class="active"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($stargoods as $stargood)
                <div class="carousel-item active">
                    <img class="d-block w-100" src="/good/{{ sha1($stargood->id) }}/titlepic" alt="{{ $stargood->good_name }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>{{ $stargood->good_name }}</h3>
                        <p>{{ $stargood->user->nickname }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselStarGoodIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselStarGoodIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="col-12 col-md-9">
        @if(count($newgoods)>0)
            <h3 style="display : inline">新品</h3>
                <div class="row">
                @foreach($newgoods as $good)
                    @include('good.goodInfoOnWelcome')
                @endforeach
                </div>
        @endif
        @if(count($populargoods)>0)
            <h3 style="display : inline">热门</h3><span style="font-size: 13px;margin-left:3px" class="text-warning">热门商品都在这里哦</span>
            <div class="row">
                @foreach($populargoods as $good)
                    @include('good.goodInfoOnWelcome')
                @endforeach
            </div>
        @endif
        <h3>随便看看</h3>
        @foreach($cats as $cat)
            @if(count($catgoods[$cat->cat_name]))
                <h4>{{ $cat->cat_name }}</h4>
                <div class="row">
                @foreach($catgoods[$cat->cat_name] as $good)
                    @include('good.goodInfoOnWelcome')
                @endforeach
                </div>
            @endif
        @endforeach
    </div>
    <div class="col-12 col-md-3">
        <div class="card">
            <div class="card-header"><h4>公告</h4></div>
            <div class="list-group list-group-flush">
            @foreach($announces as $announce)
                <a class="list-group-item" href="/notice/{{$announce->id}}">{{ $announce->title }}</a>
            @endforeach
            </div>
        </div>
    </div>
</div>
<script src="/js/good/cat.js"></script>
<script src="/js/good/editfav.js"></script>
<script src="/js/jquery.color.js"></script>
@endsection
