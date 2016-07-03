<ul>
@foreach($cats as $cat)
    <li>{{ $cat->cat_name  }}</li>
@endforeach
</ul>
<br/>
<br/>
<form action="/good/quick_access">
	<span>Quick Access: </span>
	<div class="search-container">
		<input class="form-control search-title good-id" name="query" placeholder="Input GoodID or Good Name to Search" type="text" autocomplete="off" />
		<div class="search-option hidden"></div>
	</div>
	<input class="btn btn-info" type="submit" value="&nbsp;&nbsp;Go&nbsp;&nbsp;" />
</form>
<br/>
@foreach($goods as $good)
    <div class="cat{{ $good->cat_id }}"><a href="/good/{{ $good->id }}">{{ $good->good_name }}</a></div>
@endforeach
<br/>
<br/>
<br/>
@if($user_id != NULL)
    <a href='/good/add'>Add</a>
@endif
