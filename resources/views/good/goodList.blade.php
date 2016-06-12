<ul>
@foreach($cats as $cat)
    <li>{{$cat->cat_name}}</li>
@endforeach
</ul>
<br/>
<br/>
<br/>
@foreach($goods as $good)
    <div class="cat{{$good->cat_id}}"><a href="/good/{{$good->id}}">{{$good->good_name}}</a></div>
@endforeach
<br/>
<br/>
<br/>
@if($userid!=NULL)
    <a href='/good/addPage'>Add</a>
@endif