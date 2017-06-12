<div class="col-sm-2 hidden-xs">
    <ul class="nav nav-pills nav-stacked">
        <li role="presentation"@if(isset($cat_id)&&$cat_id == 0) class="active"@endif><a href="/good">所有商品</a></li>
        @foreach($cats as $cat)
            <li role="presentation" @if(isset($cat_id)&&$cat_id == $cat->id)class="active"@endif><a href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
        @endforeach
    </ul>
</div>
<div class="col-xs-12 visible-xs-block">
    <ul class="nav nav-pills">
        <li role="presentation"@if(isset($cat_id)&&$cat_id == 0) class="active"@endif><a href="/good">所有商品</a></li>
        @foreach($cats as $cat)
            <li role="presentation" @if(isset($cat_id)&&$cat_id == $cat->id)class="active"@endif><a href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
        @endforeach
    </ul>
</div>