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
<div class="row">
    @include('layout.catlist')
    <div class="col-12 col-md-7">
        @if(count($newgoods)>0)
            <h3>新品</h3>
                <div class="row">
                @foreach($newgoods as $good)
                    @include('good.goodInfoOnWelcome')
                @endforeach
                </div>
        @endif
            @if(count($populargoods)>0)
                <h3>热门</h3>
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
                <a href="#ann{{$announce->id}}" class="list-group-item" data-toggle="modal">{{ $announce->title }}</a>
                <div class="modal fade" id="ann{{$announce->id}}" tabindex="-1" role="dialog" aria-labelledby="ann{{$announce->id}}Label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">{{ $announce->title }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                {{$announce->content}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
<script src="/js/good/cat.js"></script>
<script src="/js/good/editfav.js"></script>
<script src="/js/jquery.color.js"></script>
@endsection
