@foreach($goods as $good)
    <form action="/good/{{$good->id}}/edit" method="POST">
        good_name:<input name="good_name" value="{{$good->good_name}}"/><br/>
        cat:<select name="cat_id">
            @foreach($cats as $cat)
                <option value="{{$cat->id}}" @if($good->cat_id==$cat->id) selected="selected" @endif>{{$cat->cat_name}}</option>
            @endforeach
        </select><br/>
        description:<textarea name="description">{{$good->description}}</textarea><br/>
        pricemin:<input name="pricemin" value="{{$good->pricemin}}"/><br/>
        pricemax:<input name="pricemax" value="{{$good->pricemax}}"/><br/>
        type:<select name="type">
            <option value="0" @if($good->type==0) selected="selected" @endif>normal</option>
            <option value="1" @if($good->type==1) selected="selected" @endif>auction</option>
        </select><br/>
        counts:<input name="counts" value="{{$good->counts}}"/><br/>
        good_tag:<input name="good_tag" value="{{$good->good_tag}}"/><br/>
        {!! csrf_field() !!}
        <input type="submit"/>
    </form>
@endforeach
@if(count($errors) > 0)
    @foreach($errors as $error)
        {{$error}}
    @endforeach
@endif
<a href='/good/{{$good->id}}'>GoodInfo</a>
