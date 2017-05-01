@extends('layout.master')

@section('title', "商品列表")

@section('content')

    <div class="row">
        <div class="small-0 medium-2 columns">
            <ul class="menu vertical">
                <li @if($cat_id == 0) class="active" @endif><a href="/good">*</a></li>
                @foreach($cats as $cat)
                    <li @if($cat_id == $cat->id) class="active" @endif><a
                                href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="small-12 medium-10 columns">
            <div class="row small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row>
                @foreach($goods as $good)
                    <div class="columns">
                        <a href="/good/{{ $good->id }}">
                            <div class="card">
                                <div class="card-divider">
                                    <img src="/good/{{ sha1($good->id) }}/titlepic/320/180"/>
                                </div>
                                <div class="card-section">
                                    <div class="one-line-text">{{ $good->good_name }}</div>
                                    <div style="color: #cc4b37;" class="one-line-text"><b>￥{{ $good->pricemin }} -
                                            ￥{{ $good->pricemax }}</b></div>
                                    @if($good->counts==0)
                                        <div style="color: #ffae00;" class="one-line-text">无库存QAQ</div>
                                    @else
                                        <div class="one-line-text">库存：{{ $good->counts }}</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $goods->links() }}
    </div>

@endsection
