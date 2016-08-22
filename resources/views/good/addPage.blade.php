@include('includes.head')
@include('includes.good')
<title>添加出售 - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <form class="form-horizontal" action="/good/add" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group ">
                    <label class="col-sm-2 control-label">商品名称:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="商品名称" name="good_name">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">商品分类:</label>
                    <div class="col-sm-10">
                        <select name="cat_id" style="margin: 0;">
                            @foreach($cats as $cat)
                                <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">商品描述:</label>
                    <div class="col-sm-10">
                        <textarea style="margin: 0;" name="description" placeholder="商品描述（此处应支持HTML）"></textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">最低价格:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" placeholder="最低价格" name="pricemin">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">最高价格:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" placeholder="最高价格" name="pricemax">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">商品类型:</label>
                    <div class="col-sm-10">
                        <select  class="form-control" name="type" style="margin: 0;">
                            <option value="0">普通商品</option>
                            <option value="1">拍卖商品</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品数量:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" placeholder="库存" name="counts">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">商品标签:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="TAG" name="good_tag">
                    </div>
                </div>
                <div class="form-group">
                    <label for="goodTitleUpload"  class="col-md-2 col-sm-offset-5 button">上传封面</label>
                    <div class="col-sm-10">
                        <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic" style="margin: 0;" onchange="preview(this)">
                        {!! csrf_field() !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">封面预览:</label>
                    <div class="col-sm-10">
                        <div id="preview" style="max-width: 50%;margin-left: 25%"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-4">
                        <input type="submit" class=" button" value="确认添加" style="margin: 0;"/>
                    </div>
                    <div class="col-sm-4">
                        <a href="/good" class="button">返回商品列表</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if(count($errors) > 0)
        @foreach($errors as $error)
            {{$error}}
        @endforeach
    @endif
</div>
<script type="text/javascript">
    function preview(file)
    {
        var prevDiv = document.getElementById('preview');
        if (file.files && file.files[0])
        {
            var reader = new FileReader();
            reader.onload = function(evt){
                prevDiv.innerHTML = '<img src="' + evt.target.result + '" />';
            }
            reader.readAsDataURL(file.files[0]);
        }
        else
        {
            prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }
</script>
@include('layout.footer')
@include('includes.foot')