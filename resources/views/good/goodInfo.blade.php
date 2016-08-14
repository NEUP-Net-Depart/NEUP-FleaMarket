
    {{$goods->description}}<br/>
    @if($user_id==$goods->user_id)
        <a href='/good/{{$goods->id}}/edit'>Edit</a><br/>
        <form action='/good/{{$goods->id}}/delete' method='POST'>
            {!! csrf_field() !!}
            {{ method_field('DELETE') }}
            <input type="submit" name="submit1" value="Delete">
        </form>
		<form action = '/good/{{ $good->id }}/add_favlist' method = 'POST'>
			{!! csrf_field() !!}
			<input type = "submit" value = "✪ω✪"/>
		</form>
    @endif
    @if($user_id!=$goods->user_id)
        <form action='/good/{{$goods->id}}/buy' method='POST'>
            {!! csrf_field() !!}
            <input type="submit" name="sumbit2" value="Buy" >
        </form>
        @endif
    @if($user_id == $sells->buyer_id&&$sells->status==2)
        {{$users->tel_num}}<br/>
        @endif
<a href='/good'>GoodList</a>
