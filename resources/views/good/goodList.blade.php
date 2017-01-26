@include('includes.head')
    <title>先锋市场</title>
@include('layout.header')
    <div class="row">
    <div class="small-0 medium-2 columns">
        <ul class="menu vertical">
            <li @if($cat_id == 0) class="active" @endif><a href="/good">*</li>
            @foreach($cats as $cat)
            <li @if($cat_id == $cat->id) class="active" @endif><a href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</li>
            @endforeach
        </ul>
    </div>
    <div class="small-12 medium-10 columns">
        <table class="hover">
            @foreach($goods as $good)
                <tr class="cat{{ $good->cat_id }}">
                    <td><a href="/good/{{$good->id}}"><img src="/good/{{ sha1($good->id) }}/titlepic" style="width:5rem;height:5rem;"/></a></td>
                    <td>{{ $good->good_name }}</td>
                    <td><span style="color: #FF0033"><b>￥{{ $good->pricemin }}@if($good->type == 0) - ￥{{ $good->pricemax }}@else（拍卖中）@endif</b></span></td>
                    <td>@if($good->counts > 0)<span style="color: #3333FF">库存：{{ $good->counts }}@else<span style="color: #FF5555">无库存QAQ @endif</span></td>
                </tr>
            @endforeach
        </table>
    </div>
    </div>
@include('layout.footer')
@include('includes.foot')
