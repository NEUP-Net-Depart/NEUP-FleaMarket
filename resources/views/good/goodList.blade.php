@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <div class="row">
    <div class="small-10 small-centered columns">
        <select size="1" name="D1" onChange="javascript:goodList_changeCat(this.value)">
            <option value="0" @if($cat_id == 0)selected="selected"@endif>*</option>
            @foreach($cats as $cat)
                <option value="{{$cat->id}}" @if($cat_id == $cat->id)selected="selected"@endif>{{$cat->cat_name}}</option>
            @endforeach
        </select>
        <table class="hover">
            @foreach($goods as $good)
                <tr class="cat{{ $good->cat_id }}">
                    <td><a href="/good/{{$good->id}}"><img src="/good/{{ $good->id }}/titlepic" style="width:5rem;height:5rem;"/></a></td>
                    <td>{{ $good->good_name }}</td>
                    <td><span style="color: #FF0033"><b>￥{{ $good->pricemin }}@if($good->type == 0) - ￥{{ $good->pricemax }}@else（拍卖中）@endif</b></span></td>
                    <td>@if($good->counts > 0)<span style="color: #3333FF">库存：{{ $good->counts }}@else<span style="color: #FF5555">无库存QAQ @endif</span></td>
                </tr>
            @endforeach
        </table>
        <a href="/good/add" class="button">添加商品</a>
        <a href="/good/my" class="button">我的商品</a>
    </div>
    </div>
</div>
@include('layout.footer')
@include('includes.foot')
