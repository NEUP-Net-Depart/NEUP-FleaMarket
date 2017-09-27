@extends('layout.master')

@section('title', "首页")

@section('content')
<div class="row">
    <div class="col-12 col-md-5">
    <div id="carouselStarGoodIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @if(count($stargoods) == 0)
            <div class="carousel-item active">
                <a href="/"><img class="d-block" src="/good/{{ sha1(1) }}/titlepic" alt="先锋市场"></a>
            </div>
            @endif
            @foreach($stargoods as $good)
                <div class="carousel-item @if($loop->first) active @endif ">
                    <a href="/good/{{ $good->id }}"><img class="d-block slide-img w-100" src="/good/{{ sha1($good->id) }}/titlepic" alt="{{ $good->good_name }}"></a>
                </div>
            @endforeach
        </div>
        @if(count($stargoods) > 1)
        <a class="carousel-control-prev" href="#carouselStarGoodIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselStarGoodIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        @endif
    </div>
    </div>
    <div class="col-7 d-none d-md-block">
        <div class="row">
        @foreach($populargoods as $good)
            @include('good.goodSimpleInfoOnWelcome')
        @endforeach
        </div>
    </div>
</div>
<div class="row mx-auto d-md-none" style="margin-top:12px;height:65px;overflow:hidden">
    <div class="row">
    <div style="overflow-x: scroll;overflow-y: hidden;height:133px;white-space: nowrap;display:-webkit-box;display:-moz-box;">
    @foreach($populargoods as $good)
        @include('good.goodSimpleInfoOnWelcome2')
    @endforeach
    </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col">
        @if(count($newgoods)>0)
            <h3>新鲜上架</h3>
            <hr style="margin-top:0">
                <div class="row">
                @foreach($newgoods as $good)
                    @include('good.goodInfoOnWelcome')
                @endforeach
                </div>
        @endif
        <h3>随便看看</h3>
        <hr style="margin-top:0">
        @foreach($cats as $cat)
            @if(count($catgoods[$cat->cat_name]))
                <p><h4>{{ $cat->cat_name }}</h4></p>
                <div class="row">
                @foreach($catgoods[$cat->cat_name] as $good)
                    @include('good.goodInfoOnWelcome')
                @endforeach
                </div>
            @endif
        @endforeach
    </div>
<!--    <div class="col-12 col-md-3">
        <div class="card">
            <div class="card-header"><h4>公告</h4></div>
            <div class="list-group list-group-flush">
            @foreach($announces as $announce)
                <a class="list-group-item" href="/notice/{{$announce->id}}">{{ $announce->title }}</a>
            @endforeach
            </div>
        </div>-->
    </div>
</div>
    </div>
<script src="/js/good/cat.js"></script>
<script src="/js/good/editfav.js"></script>
<script src="/js/jquery.color.js"></script>
@endsection
