@foreach($goods as $good)
    <a href="/good/{{ $good->good_id }}">{{ $good->good_id }}</a>
        <form action='/good/{{$good->good_id}}/{{$good->id}}' method='POST'>
            {!! csrf_field() !!}
            <input type="submit" name="sumbit3" value="确认出售" >
        </form>
    <br/>
@endforeach
@foreach($sells as $sell)
    <a href="/good/{{ $sell->good_id }}">{{ $sell->good_id }}</a>
    <form action='/good/{{$sell->good_id}}/{{$sell->id}}' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit4" value="完成交易" >
    </form>
    <br/>
@endforeach
@foreach($mysells as $mysell)
    <a href="/good/{{ $mysell->good_id }}">{{ $mysell->good_id }}</a>
    <form action='/good/{{$mysell->good_id}}/{{$mysell->id}}' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit7" value="完成交易" >
    </form>
    <br/>
@endforeach
@foreach($transactions as $transaction)
    <a href="/good/{{ $transaction->good_id }}">{{ $transaction->good_id }}</a>
    <form action='/good/{{$transaction->good_id}}/{{$transaction->id}}' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit5" value="完成交易" >
    </form>
    <br/>
@endforeach
@foreach($users as $user)
    <a href="/good/{{ $user->good_id }}">{{ $user->good_id }}</a>
    <form action='/good/{{$user->good_id}}/{{$user->id}}' method='POST'>
        {!! csrf_field() !!}
        <input type="submit" name="sumbit6" value="完成交易" >
    </form>
    <br/>
@endforeach
