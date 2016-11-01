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
    <form action="/good/add" method="POST">
        <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 50%;margin-bottom: 0">
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">商品名称:</p>
                </td>
                <td style="width: 80%">
                    <input type="text" name="good_name" placeholder="商品名称"  align="middle" style="margin: 0;" />
                </td>
            </tr>
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">商品分类:</p>
                </td>
                <td>
                    <select name="cat_id" style="margin: 0;">
                        @foreach($cats as $cat)
                            <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">商品描述:</p>
                </td>
                <td>
                    <textarea style="margin: 0;" name="description" placeholder="商品描述（此处应支持HTML）"></textarea>
                </td>
            </tr>
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">最低价格:</p>
                </td>
                <td>
                    <input type="number" name="pricemin" placeholder="最低价格" style="margin: 0;"/>
                </td>
            </tr>
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">最高价格:</p>
                </td>
                <td>
                    <input type="number" name="pricemax" placeholder="最高价格" style="margin: 0;"/>
                </td>
            </tr>
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">商品类型:</p>
                </td>
                <td>
                    <select name="type" style="margin: 0;">
                        <option value="0">普通商品</option>
                        <option value="1">拍卖商品</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">商品数量:</p>
                </td>
                <td>
                    <input type="number" name="counts" placeholder="库存" style="margin: 0;"/>
                </td>
            </tr>
            <tr>
                <td style="width: 20%" align="middle">
                    <p style="margin: 0">商品标签:</p>
                </td>
                <td>
                    <input type="text" name="good_tag" placeholder="TAG" style="margin: 0;"/>
                </td>
            </tr>
        </table>
        <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 50%;margin-bottom: 0">
            <tr>
                <td>
                    <table border="0" align="center" cellpadding="0" cellspacing="0" style="margin-bottom: 0;border-collapse: separate">
                        <tr>
                            <td style="width: 20%">
                                <label for="goodTitleUpload" class="button" style="margin: 0;">上传封面</label>
                                <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic" style="margin: 0;" onchange="preview(this)"/><br/>
                                {!! csrf_field() !!}
                            </td>
                            <td>
                                <div id="preview" style="max-width: 50%;margin-left: 25%"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <table border="0" align="center" cellpadding="0" cellspacing="0" style="margin-bottom: 0;border-collapse: separate;border-right:none; border-left:none;">
                        <tr>
                            <td style="width: 50%" align="right">
                                <input type="submit" class="button" value="添加" style="margin: 0;"/>
                            </td>
                            <td>
                                <a href='/good'>商品列表</a>
                            </td>
                        </tr>
                    </table>

                </td>

            </tr>
        </table>
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