@include('includes.head')
@include('includes.good')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<script language="javascript" type="text/javascript">
    function test(Names) {
        if(Names=="mune_x0")
        {
            var Nnews = document.querySelectorAll(".cat1")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
            var Nnews = document.querySelectorAll(".cat2")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
            var Nnews = document.querySelectorAll(".cat3")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
            var Nnews = document.querySelectorAll(".cat4")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
        }else if(Names=="mune_x1")
        {
            var Nnews = document.querySelectorAll(".cat1")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
            var Nnews = document.querySelectorAll(".cat2")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat3")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat4")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
        }else if(Names=="mune_x2")
        {
            var Nnews = document.querySelectorAll(".cat1")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat2")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
            var Nnews = document.querySelectorAll(".cat3")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat4")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
        }else if(Names=="mune_x3")
        {
            var Nnews = document.querySelectorAll(".cat1")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat2")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat3")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
            var Nnews = document.querySelectorAll(".cat4")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
        } else if(Names=="mune_x4")
        {
            var Nnews = document.querySelectorAll(".cat1")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat2")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat3")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = 'none';
            }
            var Nnews = document.querySelectorAll(".cat4")
            for (var i = 0, len = Nnews.length; i < len; i++) {
                var Nnew = Nnews.item(i);
                Nnew.style.display = '';
            }
        }
    }
</script>
<div class="page-content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <label class="col-sm-2 control-label">选择分类:</label>
                <div class="col-sm-10">
                    <select size="1" name="D1" onChange="javascript:test('mune_x'+this.value)">
                        <option value="0" selected="selected">全部显示</option>
                        <option value="1" >我是分类1</option>
                        <option value="2">我是分类2</option>
                        <option value="3">我是分类4</option>
                        <option value="4">我是滑稽</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">商品列表</label>
                <table class="table table-striped">
                    <tr>
                        <td>#</td>
                        <td>商品名称</td>
                        <td>最低价格</td>
                        <td>最高价格</td>
                    </tr>
                    @foreach($goods as $good)
                        <tr class="cat{{ $good->cat_id }}">
                            <td>{{$good->id}}</td>
                            <td>{{ $good->good_name }}</td>
                            <td>{{ $good->pricemin }}</td>
                            <td>{{ $good->pricemax }}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
            <div class="form-group">
                <div class="col-sm-3 col-sm-offset-3">
                    <a href="/good/add" class="button">添加商品</a>
                </div>
                <div class="col-sm-4">
                    <a href="/good/mygood" class="button">我的商品</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layout.footer')
@include('includes.foot')
