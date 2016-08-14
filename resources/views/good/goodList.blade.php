<ul>
@foreach($cats as $cat)
    <li>{{ $cat->cat_name  }}</li>
@endforeach
</ul>
<br/>
<br/>
<form action="/good/quick_access">
	<span>Quick Access: </span>
	<div>
		<input name="query" placeholder="Input Keyword to Search"/>
	</div>
	<input type="submit" value="Go"/>
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
@if($user_id != NULL)
	<a href='/good/mygood'>my good</a>
@endif
