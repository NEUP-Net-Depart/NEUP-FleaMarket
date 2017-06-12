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
@endsection

@section('content')
    @include('layout.catlist')
    <div class="col-xs-12 col-sm-7">
        {{--@if(count($stargoods) > 0)
            <div class="orbit" role="region" aria-label="推荐商品" data-orbit>
                <ul class="orbit-container">
                    @if(count($stargoods) > 1)
                        <button class="orbit-previous"><span class="show-for-sr">←</span>&#9664;&#xFE0E;</button>
                        <button class="orbit-next"><span class="show-for-sr">→</span>&#9654;&#xFE0E;</button>
                    @endif
                    @foreach($stargoods as $good)
                        <li class="orbit-slide">
                            <a href="/good/{{ $good->id }}"><img class="orbit-image" src="/good/{{ sha1($good->id) }}/titlepic" alt="{{ $good->name }}"/>
                                <figcaption class="orbit-caption">{{ $good->good_name }}</figcaption>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <br/>
        @endif--}}
        @if(count($newgoods)>0)
            <h3>新品</h3>
                <div class="row">
                @foreach($newgoods as $good)
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
    <div class="col-xs-12 col-sm-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>公告</h4></div>
            <div class="list-group">
            @foreach($announces as $announce)
                <a href="/announcement/{{ $announce->id }}" class="list-group-item">{{ $announce->title }}</a>
            @endforeach
            </div>
        </div>
    </div>
    <script src="/js/good/cat.js"></script>
    <script src="/js/good/editfav.js"></script>
    <script src="/js/jquery.color.js"></script>
</div>
@endsection
