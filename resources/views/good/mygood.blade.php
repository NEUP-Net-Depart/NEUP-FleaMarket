<ul>
    @foreach($mygoods as $mygood)
        <div class="cat{{ $mygood->cat_id }}"><a href="/good/{{ $mygood->id }}">{{ $mygood->good_name }}</a></div>
    @endforeach
</ul>