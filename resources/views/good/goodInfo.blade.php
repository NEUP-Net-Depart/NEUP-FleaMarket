@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class = "page-content">
    {{ $good->description }}<br/>
    <img src = "/good/{{ $good->id }}/titlepic"/>
    @if($user_id == $good->user_id)
        <a href = '/good/{{ $good->id }}/edit'>Edit</a><br/>
        <form action = '/good/{{ $good->id }}/delete' method = 'POST'>
            {!! csrf_field() !!}
            {{ method_field('DELETE') }}
            <input type = "submit" name = "submit1" value = "Delete">
        </form>
    @endif
    @if($user_id != $good->user_id)
        <form action = '/good/{{ $good->id }}/buy' method = 'POST'>
            {!! csrf_field() !!}
            <input type = "submit" name = "sumbit2" value = "Buy" >
        </form>
    @endif
	@if(count($inFvlst) == 0)
		<form action = '/good/{{ $good->id }}/add_favlist' method = 'GET'>
			{!! csrf_field() !!}
			<input type = "submit" value = "收藏OvO"/>
		</form>
	@endif
	@if(count($inFvlst) != 0)
		<form action = '/good/{{ $good->id }}/del_favlist' method = 'POST'>
			{!! csrf_field() !!}
			{{ method_field('DELETE') }}
			<input type = "submit" name = "submit1" value = "取消收藏QAQ" />
		</form>
	@endif
<a href = '/good'>GoodList</a>
</div>
@include('layout.footer')
@include('includes.foot')
