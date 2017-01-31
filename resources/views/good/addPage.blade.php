@include('includes.head')
<title>添加出售 - 先锋市场</title>
<style>
    label {
        text-align: right;
        font-size: medium;
        color: #ffffff;
        min-width: 80px;
        max-width: 100px;
        float: right;
    }
    .goodimgpreview {
        max-width: 100%;
    }
</style>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <div class="large-8 large-offset-2 small-10 small-offset-1 columns">
        <form action="/good/add" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">商品名称:</label>
                </div>
                <div class="small-10 columns">
                    <input type="text" name="good_name" placeholder="商品名称">
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">商品分类:</label>
                </div>
                <div class="small-10 columns">
                    <select name="cat_id">
                        @foreach($cats as $cat)
                            <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">商品描述:</label>
                </div>
                <div class="small-10 columns">
                    <textarea name="description" placeholder="商品描述（此处应支持HTML）"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">最低价格:</label>
                </div>
                <div class="small-10 columns">
                    <input type="number" name="pricemin" placeholder="最低价格">
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">最高价格:</label>
                </div>
                <div class="small-10 columns">
                    <input type="number" name="pricemax" placeholder="最高价格">
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">商品类型:</label>
                </div>
                <div class="small-10 columns">
                    <select name="type">
                        <option value="0">普通商品</option>
                        <option value="1">拍卖商品</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">商品数量:</label>
                </div>
                <div class="small-10 columns">
                    <input type="number" name="counts" placeholder="库存">
                </div>
            </div>
            <div class="row">
                <div class="small-2 columns">
                    <label class="right inline">商品标签:</label>
                </div>
                <div class="small-10 columns">
                    <input type="text" name="good_tag" placeholder="TAG">
                </div>
            </div>
            <div class="row">
                <div class="small-4 columns">
                    <label for="goodTitleUpload" class="button right inline">上传封面</label>
                </div>
                <div id="preview" class="small-8 columns"></div>
                <div style="display: none">
                    <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic"
                           onchange="preview(this)"/>
                </div>
            </div>
            <p></p>
            <div class="row">
                <div class="small-2 small-offset-3 columns">
                    <input type="submit" class="button" value="添加" style="margin: 0;"/>
                </div>
                <div class="small-4 columns">
                    <a href='/good' class="button">商品列表</a>
                </div>
            </div>
            {!! csrf_field() !!}
        </form>
    </div>
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
            var prreader = new FileReader();
            var reader = new FileReader();
            reader.onload = function(evt){
                prevDiv.innerHTML = '<img id="goodimgpreview" src="' + evt.target.result + '" />';
                $('#goodimgpreview').cropper({
                    aspectRatio: 16 / 9,
                    crop: function(e) {
                        // Output the result data for cropping image.
                        console.log(e.x);
                        console.log(e.y);
                        console.log(e.width);
                        console.log(e.height);
                        console.log(e.rotate);
                        console.log(e.scaleX);
                        console.log(e.scaleY);
                    }
                });
            };
            prreader.onload = function(evt){
                var fileBuf = new Uint8Array(evt.target.result.slice(0, 11));
                var mime = isImage(fileBuf);
                if(mime == null) {
                    //This should be modified
                    alert("Please open image!");
                    return;
                }
                else {
                    reader.readAsDataURL(file.files[0]);
                }
            };
            prreader.readAsArrayBuffer(file.files[0]);
        }
        else
        {
            prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }
    var pngMagic = [
        0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a
    ];
    var jpeg_jfif = [
        0x4a, 0x46, 0x49, 0x46
    ];
    var jpeg_exif = [
        0x45, 0x78, 0x69, 0x66
    ];
    var jpegMagic = [
        0xFF, 0xD8, 0xFF, 0xE0
    ];
    var gifMagic0 = [
        0x47, 0x49, 0x46, 0x38, 0x37, 0x61
    ];
    var getGifMagic1 = [
        0x47, 0x49, 0x46, 0x38, 0x39, 0x61
    ];

    function arraycopy(src, index, dist, distIndex, size) {
        for (i = 0; i < size; i++) {
            dist[distIndex + i] = src[index + i]
        }
    }

    function arrayEquals(arr1, arr2) {
        console.log(arr1)
        console.log(arr2)
        if (arr1 == 'undefined' || arr2 == 'undefined') {
            return false
        }
        if (arr1 instanceof Array && arr2 instanceof Array) {
            if (arr1.length != arr2.length) {
                return false
            }
            for (i = 0; i < arr1.length; i++) {
                if (arr1[i] != arr2[i]) {
                    return false
                }
            }
            return true
        }
        return false;
    }

    function isImage(buf) {
        if (buf == null || buf == 'undefined' || buf.length < 8) {
            return null;
        }
        var bytes = [];
        arraycopy(buf, 0, bytes, 0, 6);
        if (isGif(bytes)) {
            return "image/gif";
        }
        bytes = [];
        arraycopy(buf, 6, bytes, 0, 4);
        if (isJpeg(bytes)) {
            return "image/jpeg";
        }
        bytes = [];
        arraycopy(buf, 0, bytes, 0, 8);
        if (isPng(bytes)) {
            return "image/png";
        }
        return null;
    }


    /**
     * @param data first 6 bytes of file
     * @return gif image file true,other false
     */
    function isGif(data) {
        console.log('GIF')
        return arrayEquals(data, gifMagic0) || arrayEquals(data, getGifMagic1);
    }

    /**
     * @param data first 4 bytes of file
     * @return jpeg image file true,other false
     */
    function isJpeg(data) {
        console.log('JPEG')
        return arrayEquals(data, jpegMagic) || arrayEquals(data, jpeg_jfif) || arrayEquals(data, jpeg_exif);
    }

    /**
     * @param data first 8 bytes of file
     * @return png image file true,other false
     */
    function isPng(data) {
        console.log('PNG')
        return arrayEquals(data, pngMagic);
    }
</script>
@include('layout.footer')
@include('includes.foot')