@extends('layout.master')

@section('title', "首页")

@section('content')

    <div class="row">
        <div class="small-12 medium-8 columns">
            @if(count($stargoods) > 0)
                <div class="orbit" role="region" aria-label="热销商品" data-orbit>
                    <ul class="orbit-container">
                        @if(count($stargoods) > 1)
                            <button class="orbit-previous"><span class="show-for-sr">←</span>&#9664;&#xFE0E;</button>
                            <button class="orbit-next"><span class="show-for-sr">→</span>&#9654;&#xFE0E;</button>
                        @endif
                        @foreach($stargoods as $good)
                            <li class="orbit-slide">
                                <a href="/good/{{ $good->id }}"><img class="orbit-image"
                                                                     src="/good/{{ sha1($good->id) }}/titlepic"
                                                                     alt="{{ $good->name }}"/>
                                    <figcaption class="orbit-caption">{{ $good->good_name }}</figcaption>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <br/>
            @endif
            @if(count($newgoods)>0)
                <h3>新品</h3>
                <div class="row small-up-1 medium-up-2 large-up-4">
                    @foreach($newgoods as $good)
                        <div class="columns">
                            <a href="/good/{{ $good->id }}">
                                <div class="card">
                                    <div class="card-divider">
                                        <img src="/good/{{ sha1($good->id) }}/titlepic"/>
                                    </div>
                                    <div class="card-section">
                                        {{ $good->good_name }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            <h3>随便看看</h3>
            @foreach($cats as $cat)
                @if(count($catgoods[$cat->cat_name]))
                    <h4>{{ $cat->cat_name }}</h4>
                    <div class="row small-up-1 medium-up-2 large-up-4">
                        @foreach($catgoods[$cat->cat_name] as $good)
                            <div class="columns">
                                <a href="/good/{{ $good->id }}">
                                    <div class="card">
                                        <div class="card-divider">
                                            <img src="/good/{{ sha1($good->id) }}/titlepic"/>
                                        </div>
                                        <div class="card-section">
                                            {{ $good->good_name }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
        <div class="small-12 medium-4 columns">
            <div class="row">
                <div class="medium-10 medium-offset-2 columns">
                    <div class="card">
                        <h4 class="card-divider">公告</h4>
                        @foreach($announces as $announce)
                            <a href="/announcement/{{ $announce->id }}">
                                <div class="card-section">{{ $announce->title }}</div>
                            </a>
                            @if($announce != $announces->last())
                                <hr>@endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
