<form action="/good/add" method="POST">
    good_name:<input name="good_name"/><br/>
    cat:<select name="cat_id">
        @foreach($cats as $cat)
            <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
        @endforeach
    </select><br/>
    description:<textarea name="description"></textarea><br/>
    pricemin:<input name="pricemin"/><br/>
    pricemax:<input name="pricemax"/><br/>
    type:<select name="type">
        <option value="0">normal</option>
        <option value="1">auction</option>
    </select><br/>
    counts:<input name="counts"/><br/>
    good_tag:<input name="good_tag"/><br/>
    {!! csrf_field() !!}
    <input type="submit"/>
</form>
@if(count($errors) > 0)
    @foreach($errors as $error)
        {{$error}}
    @endforeach
@endif
<a href='/good'>GoodList</a>
