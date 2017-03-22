@extends('layout.master')

@section('title', "商品详情")

@section('content')

    <div class="row">
        <div class="small-12 medium-5 columns thumbnail">
            <img src="/good/{{ sha1($good->id) }}/titlepic"/>
        </div>
        <div class="small-12 medium-6 medium-offset-1 columns">
            <h1>{{ $good->good_name }}</h1>
            <h4 style="color: #cc4b37"><b>￥{{ $good->pricemin }} - ￥{{ $good->pricemax }}</b></h4>
            <div class="row">
                <div class="small-5 columns">
                    @if($good->seller) != Session::get('user_id'))
                    <form action="/good/{{ $good->id }}/buy" method="post">
                        <div class="input-group">
                            <input type="number" name="counts" value="1" class="input-group-field"/>
                            {!! csrf_field() !!}
                            <div class="input-group-button">
                                <input type="submit" class="button" value="购买"/>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{ $good->description }}
    </div>

@endsection