@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
@foreach($goods as $good)
    {{$good->description}}<br/>
    @if($user_id==$good->user_id)
        <a href='/good/{{$good->id}}/edit'>Edit</a><br/>
        <form action='/good/{{$good->id}}/delete' method='POST'>
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
</div>
@include('layout.footer')
@include('includes.foot')
