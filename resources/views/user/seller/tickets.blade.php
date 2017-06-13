@extends('user.seller.master')

@section('tab-list')
    <li role="presentation"><a href="/user/sell">我的商品</a></li>
    <li role="presentation"><a href="/user/sell/trans">交易订单</a></li>
    <li role="presentation" class="active"><a href="/user/sell/tickets">历史评价</a></li>
@endsection

@section('tab-content')
        <div role="tabpanel" class="tab-pane" id="goods">
        </div>
        <div role="tabpanel" class="tab-pane" id="trans">
        </div>
        <div role="tabpanel" class="tab-pane" id="tickets">
        </div>
@endsection