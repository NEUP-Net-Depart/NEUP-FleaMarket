@extends('user.seller.master')

@section('tab-list')
    <li class="nav-item"><a href="/user/sell" class="nav-link active">我的商品（正在卖）</a></li>
    <li class="nav-item"><a href="/user/sell/sold" class="nav-link">我的商品（已售出）</a></li>
    <li class="nav-item"><a href="/user/sell/trans" class="nav-link">交易订单</a></li>
    <li class="nav-item"><a href="/user/sell/tickets" class="nav-link">历史评价</a></li>
@endsection

@section('tab-content')
    <p>友情提示：商品售出后您无需删除商品！请在交易订单上点击“完成”，系统会自动扣除库存。库存为 0 的商品将不会继续被销售。</p>
    @include('user.seller.mygoods')
@endsection