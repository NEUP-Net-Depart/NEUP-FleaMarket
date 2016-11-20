@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
@foreach($goods as $good)
    <a href="/good/{{ $good->good_id }}">{{ $good->good_id }}</a>
        <form action='/good/{{ $good->id }}/allow' method='POST'>
            {!! csrf_field() !!}
            <input type="submit" name="sumbit3" value="确认出售" >
        </form>
    <br/>
@endforeach
@foreach($sells as $sell)
    <a href="/good/{{ $sell->good_id }}">查看商品信息</a><br/>
    <a href="/user/{{ $sell->seller_id }}">查看买家信息</a><br/>
    <form action='/good/{{ $sell->id }}/allow' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit4" value="完成交易" >
    </form>
    <br/>
@endforeach
@foreach($mysells as $mysell)
    <a href="/good/{{ $mysell->good_id }}">{{ $mysell->good_id }}</a>
    <form action='/good/{{ $mysell->id }}/allow' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit7" value="完成交易 >
    </form>
    <br/>
@endforeach
@foreach($transactions as $transaction)
    <a href="/good/{{ $transaction->good_id }}">查看商品信息</a><br/>
    <a href="/user/{{ $transaction->seller_id }}">查看卖家信息</a><br/>
    <form action='/good/{{ $transaction->id }}/allow' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit5" value="完成交易" >
    </form>
    <br/>
@endforeach
@foreach($users as $user)
    <a href="/good/{{ $user->good_id }}">{{ $user->good_id }}</a>
    <form action='/good/{{ $user->id }}/allow' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit6" value="完成交易" >
    </form>
    <br/>
@endforeach
</div>
@include('layout.footer')
@include('includes.foot')
