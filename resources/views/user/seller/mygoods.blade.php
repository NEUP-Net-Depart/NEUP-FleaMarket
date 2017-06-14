@extends('user.seller.master')

@section('tab-list')
    <li class="nav-item"><a href="/user/sell" class="nav-link active">我的商品</a></li>
    <li class="nav-item"><a href="/user/sell/trans" class="nav-link">交易订单</a></li>
    <li class="nav-item"><a href="/user/sell/tickets" class="nav-link">历史评价</a></li>
@endsection

@section('tab-content')
        <div role="tabpanel" class="tab-pane active" id="goods">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <table class="table table-hover table-responsive">
                <thead>
                <tr>
                    <th>#</th>
                    <th>商品名称</th>
                    <th>商品价格</th>
                    <th>剩余库存</th>
                    <th>修改信息</th>
                    <th>删除商品</th>
                </tr>
                </thead>
                <tbody>
                @foreach($goods as $good)
                    <tr id="good{{ $good->id }}">
                        <td>{{ $good->id }}</td>
                        <td><a href="/good/{{$good->id}}"
                                onMouseOver="toolTip('<img src=/good/{{ sha1($good->id) }}/titlepic>')"
                                onMouseOut="toolTip()">{{ $good->good_name }}</a></td>
                        <td>{{ $good->price }}</td>
                        <td>{{ $good->count }}</td>
                        <td>
                            <form action="/good/{{ $good->id }}/edit">
                                <input type="submit" class="btn btn-primary" value="修改" style="margin: 0;">
                            </form>
                        </td>
                        <td>
                            <form method="POST" id="delform">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                            </form>
                            <input type="submit" class="btn btn-primary" value="删除" style="margin: 0;" id="delbutton" onclick="del_good({{ $good->id }})">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $goods->links() }}
        </div>
        <div role="tabpanel" class="tab-pane" id="trans">
        </div>
        <div role="tabpanel" class="tab-pane" id="tickets">
        </div>
@endsection