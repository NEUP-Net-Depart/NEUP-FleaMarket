@extends('user.seller.master')

@section('tab-list')
  <li class="nav-item"><a href="/user/sell" class="nav-link">我的商品（正在卖）</a></li>
  <li class="nav-item"><a href="/user/sell/sold" class="nav-link active">我的商品（已售出）</a></li>
  <li class="nav-item"><a href="/user/sell/trans" class="nav-link">交易订单</a></li>
  <li class="nav-item"><a href="/user/sell/tickets" class="nav-link">历史评价</a></li>
@endsection

@section('tab-content')
  @include('user.seller.mygoods')
@endsection