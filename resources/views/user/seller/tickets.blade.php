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
            <div id="tickets-container" class="card-section">
                @foreach($tickets as $ticket)
                    <div class="card card-body" style="margin-bottom: 5px">
                        <label>{{ $ticket->created_at }}
                            @if($ticket->type == 1)
                                一只小萌妹评价了我说：
                            @else
                                一只小萌妹举报了我说：
                            @endif
                        </label>
                        <p>{{ $ticket->message }}</p>
                    </div>
                @endforeach
                @if(count($tickets)==0)
                    <div class="row">
                        <div style="margin-left:auto;margin-right:auto;">还没有人评价呢</div>
                    </div>
                @endif
            </div>
        </div>
@endsection