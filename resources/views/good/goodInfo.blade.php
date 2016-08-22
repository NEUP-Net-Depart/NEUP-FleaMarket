@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    {{$good->description}}<br/>
    @if($user_id==$good->user_id)
        <a href='/good/{{$good->id}}/edit'>Edit</a><br/>
        <form action='/good/{{$good->id}}/delete' method='POST'>
            {!! csrf_field() !!}
            {{ method_field('DELETE') }}
            <input type="submit" name="submit1" value="Delete">
        </form>
    @endif
    @if($user_id!=$good->user_id)
        <form action='/good/{{$good->id}}/buy' method='POST'>
            {!! csrf_field() !!}
            <input type="submit" name="sumbit2" value="Buy" >
        </form>
    @endif
		<form action = '/good/{{ $good->id }}/add_favlist' method = 'POST'>
			{!! csrf_field() !!}
			<input type = "submit" value = "✪ω✪"/>
		</form>
<a href='/good'>GoodList</a>
</div>
@include('layout.footer')
@include('includes.foot')
