@extends('layout.master')

@section('title', "用户")

@section('asset')

@endsection

@section('content')

    <div class="row">
        <div class="column">
            <h2>
                @if(isset($user->nickname))
                    {{ $user->nickname }}
                    @if($user->baned)
                        【已封禁】
                    @endif
                @else
                    还没有昵称&gt;_&lt;
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
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="column" style="max-width: 256px">
            <p>
                <img src="/avatar/{{ $user->id }}/256/256"/>
            </p>
            <p>
                <input type="button" value="和他联系" class="button"
                       onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
            @if(Session::has('user_id') && Session::get('user_id')!=$user->id)
                @if(Session::get('user_id') == $user->id)
                @elseif(Session::get('is_admin') >= 1)
                    <form action="/user/{{ $user->id }}/banpage" method="GET">
                        <input type="submit" class="button" value="封禁该用户">
                    </form>
                @else
                    <form action="/report/{{ $user->id }}" method="GET">
                        <input type="submit" class="button" value="举报该用户">
                    </form>
                    @endif
                    @endif
                    </p>
        </div>
        <div class="column medium-8 large-9">
            <ul class="tabs" data-tabs id="editinfo">
                <li class="tabs-title is-active"><a href="#goods" aria-selected="true">他的商品</a></li>
                <li class="tabs-title"><a href="#tickets">历史评价</a></li>
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
@endsection