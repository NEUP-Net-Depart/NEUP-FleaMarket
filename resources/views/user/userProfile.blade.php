@extends('layout.master')

@section('title', "用户")

@section('asset')

@endsection

@section('content')

    <div class="row">

    </div>

    <div class="card" style="display:none;">
        <div class="card-header">
            <div class="col-12 col-md-7">
                <div style="width:150px; height:150px; border-radius:50%; overflow:hidden;">
                    <img src="/avatar/{{ $user->id }}/150/150"/></div>
            </div>
            <div class="col-12 col-md-5">
                <input type="button" value="和他联系" class="btn btn-secondary"
                       onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
                @if(Session::get('user_id') == $user->id)
                @elseif(Session::get('is_admin') >= 1)
                    <input type="button" value="和他联系" class="btn btn-secondary"
                           onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
                    <form action="/user/{{ $user->id }}/banpage" method="GET">
                        <input type="submit" class="btn btn-secondary" value="封禁该用户">
                    </form>
                @else
                    <input type="button" value="和他联系" class="btn btn-secondary"
                           onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
                    <form action="/report/{{ $user->id }}" method="GET">
                        <input type="submit" class="btn btn-secondary" value="举报该用户">
                    </form>
                @endif
            </div>
            <div class="col-12">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item active"><a class="nav-link" href="#goods" aria-controls="goods" role="tab" data-toggle="tab">他的商品</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab">历史评价</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="editinfo">
                    <div class="tabs-panel" id="goods">
                        <div class="card-section">
                            <div class="row table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>#</td>
                                        <td>商品名称</td>
                                        <td>商品价格</td>
                                        <td>剩余库存</td>
                                    </tr>
                                    @foreach($goods as $good)
                                        <tr id="good{{ $good->id }}">
                                            <td>{{ $good->id }}</td>
                                            <td><a href="/good/{{$good->id}}"
                                                   onMouseOver="toolTip('<img src=/good/{{ sha1($good->id) }}/titlepic>')"
                                                   onMouseOut="toolTip()">{{ $good->good_name }}</a></td>
                                            <td>{{ $good->price }}</td>
                                            <td>{{ $good->count }}</td>
                                        </tr>

                                    @endforeach
                                    {{ $goods->links() }}
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tabs-panel" id="tickets">
                        <div id="tickets-container" class="card-section">
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
                    </div>
                </div>
            </div>
        </div>
    </div>






    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-7">
                    <img src="/avatar/{{ $user->id }}/150/150"  style="width:150px; height:150px; border-radius:50%; overflow:hidden;margin-bottom:10px" />

                    <div class="column" style="margin-bottom:10px;padding-left:5px">
                        @if(isset($user->nickname))
                            用户名： {{ $user->nickname }}
                            @if($user->baned)
                                【已封禁】
                            @endif
                        @else
                            还没有昵称&gt;&lt;
                            @if($user->baned)
                                【已封禁】
                            @endif
                        @endif
                        @if(isset($user->stuid))
                            @if(strlen($user->stuid) == 8)
                                @if(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR'))
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-54c0e6.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR') - 1)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-a31b3f.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR') - 2)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-3ca88e.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR') - 3)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-d58d15.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) < 2000 + env('FRESH_YEAR') - 3)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E6%A0%A1%E5%8F%8B%E8%AE%A4%E8%AF%81-bfbfbf.svg">
                                @endif
                            @elseif(strlen($user->stuid) == 7)
                                <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E7%A0%94%E7%A9%B6%E7%94%9F%E8%AE%A4%E8%AF%81-ec3468.svg">
                            @elseif(strlen($user->stuid) == 5)
                                <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E6%95%99%E8%81%8C%E5%B7%A5%E8%AE%A4%E8%AF%81-000000.svg">
                            @endif
                        @endif
                        @if($user->privilege == 1)
                            <img src="https://img.shields.io/badge/%E5%85%88%E9%94%8B%E5%B8%82%E5%9C%BA-%E7%AE%A1%E7%90%86%E5%91%98-9300dd.svg">
                        @elseif($user->privilege == 2)
                            <img src="https://img.shields.io/badge/%E5%85%88%E9%94%8B%E5%B8%82%E5%9C%BA-%E7%AE%A1%E7%90%86%E5%91%98-ee0000.svg">
                        @endif
                    </div>

                </div>
                <div class="col-md-5">
                    @if(Session::get('user_id') == $user->id)
                    @elseif(Session::get('is_admin') >= 1)
                        <form action="/user/{{ $user->id }}/banpage" method="GET" style="position:absolute;bottom:0px">
                            <input type="submit" class="btn btn-secondary" value="封禁该用户">
                            <input type="button" value="和他联系" class="btn btn-secondary"
                                   onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
                        </form>
                    @else
                        <form action="/report/{{ $user->id }}" method="GET" style="position:absolute;bottom:0px">
                            <input type="submit" class="btn btn-secondary" value="举报该用户">
                            <input type="button" value="和他联系" class="btn btn-secondary"
                                   onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
                        </form>
                    @endif
                </div>
            </div>
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" href="#goods" aria-controls="goods" role="tab" data-toggle="tab">他的商品</a></li>
                <li class="nav-item"><a class="nav-link" href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab">历史评价</a></li>
            </ul>
        </div>
        <div class="tab-content card-block">
            <div role="tabpanel" class="tab-pane active" id="goods">
                <div class="row table-responsive">
                    <table class="table">
                        <tr>
                            <td>#</td>
                            <td>商品名称</td>
                            <td>商品价格</td>
                            <td>剩余库存</td>
                        </tr>
                        @foreach($goods as $good)
                            <tr id="good{{ $good->id }}">
                                <td>{{ $good->id }}</td>
                                <td><a href="/good/{{$good->id}}"
                                       onMouseOver="toolTip('<img src=/good/{{ sha1($good->id) }}/titlepic>')"
                                       onMouseOut="toolTip()">{{ $good->good_name }}</a></td>
                                <td>{{ $good->price }}</td>
                                <td>{{ $good->count }}</td>
                            </tr>

                        @endforeach
                        {{ $goods->links() }}
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tickets">
                <div class="card-section">
                    <div id="tickets-container" class="card-section">
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
                </div>
            </div>
        </div>
    </div>
@endsection