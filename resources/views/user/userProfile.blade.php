@extends('layout.master')

@section('title', "用户")

@section('asset')

@endsection

@section('content')

    <div class="row">
        <div class="column">
            @if(isset($user->nickname))
                <h2>{{ $user->nickname }}</h2>
            @else
                <h2>还没有昵称&gt;_&lt;</h2>
            @endif
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