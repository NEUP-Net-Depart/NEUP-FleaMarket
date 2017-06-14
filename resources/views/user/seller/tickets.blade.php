@extends('user.seller.master')

@section('tab-list')
    <li class="nav-item"><a href="/user/sell" class="nav-link">我的商品</a></li>
    <li class="nav-item"><a href="/user/sell/trans" class="nav-link">交易订单</a></li>
    <li class="nav-item"><a href="/user/sell/tickets" class="nav-link active">历史评价</a></li>
@endsection

@section('tab-content')
        <div role="tabpanel" class="tab-pane" id="goods">
        </div>
        <div role="tabpanel" class="tab-pane" id="trans">
        </div>
        <div role="tabpanel" class="tab-pane active" id="tickets">
                <ul>
                    @foreach($tickets as $ticket)
                        <li>
                            <label>{{ $ticket->created_at }}
                                @if($ticket->type == 1)
                                    评价
                                @else
                                    举报
                                @endif
                            </label>
                            <p>{{ $ticket->message }}</p>
                        </li>
                    @endforeach
                </ul>
        </div>
@endsection