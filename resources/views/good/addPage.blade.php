@include('includes.head')
    <title>添加出售 - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
<form action="/good/add" method="POST">
    <input type="text" name="good_name" placeholder="商品名称"/>
    <select name="cat_id">
        @foreach($cats as $cat)
            <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
        @endforeach
    </select>
    <textarea name="description" placeholder="商品描述（此处应支持HTML）"></textarea>
    <input type="number" name="pricemin" placeholder="最低价格"/>
    <input type="number" name="pricemax" placeholder="最高价格"/>
    <select name="type">
        <option value="0">普通商品</option>
        <option value="1">拍卖商品</option>
    </select>
    <input type="number" name="counts" placeholder="库存"/>
    <input type="text" name="good_tag" placeholder="TAG"/>
    <label for="goodTitleUpload" class="button">上传封面</label>
    <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic"/><br/>
    {!! csrf_field() !!}
    <input type="submit" class="button" value="添加"/>
</form>
@if(count($errors) > 0)
    @foreach($errors as $error)
        {{$error}}
    @endforeach
@endif
<a href='/good'>商品列表</a>
</div>
@include('layout.footer')
@include('includes.foot')