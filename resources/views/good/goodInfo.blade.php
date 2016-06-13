@foreach($goods as $good)
    {{$good->description}}<br/>
    @if($userid==$good->user_id)
        <a href='/good/{{$good->id}}/edit'>Edit</a><br/>
        <a href='/good/{{$good->id}}/delete'>Delete</a><br/>
    @endif
@endforeach
<a href='/good'>GoodList</a>
