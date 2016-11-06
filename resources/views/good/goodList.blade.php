@include('includes.head')
@include('includes.good')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <label>选择分类:</label>
    <select size="1" name="D1" onChange="javascript:test(this.value,{{count($cats)}})">
        <option value="0" selected="selected">*</option>
        @foreach($cats as $cat)
            <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
        @endforeach
    </select>
    <label>商品列表</label>
    <table class="table">
        <tr>
            <td>#</td>
            <td>商品名称</td>
            <td>最低价格</td>
            <td>最高价格</td>
        </tr>
        @foreach($goods as $good)
            <tr class="cat{{ $good->cat_id }}">
                <td>{{ $good->id }}</td>
                <td><a href="/good/{{$good->id}}">{{ $good->good_name }}</a></td>
                <td>{{ $good->pricemin }}</td>
                <td>{{ $good->pricemax }}</td>
            </tr>
        @endforeach
    </table>
    <a href="/good/add" class="button">添加商品</a>
    <a href="/good/my" class="button">我的商品</a>
</div>
@include('layout.footer')
@include('includes.foot')
