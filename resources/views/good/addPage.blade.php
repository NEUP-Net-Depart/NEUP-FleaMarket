@extends('layout.master')

@section('title', "添加商品")

@section('asset')
    <style>
        .goodimgpreview {
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="columns small-12 medium-8 medium-offset-2 large-6 large-offset-3">
        <div class="row">
            @if (count($errors) > 0)
                <label>
                    <span class="form-error is-visible">{!! $errors->first() !!}</span>
                </label>
            @endif
            <form action="/good/add" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="small-3 columns">
                        <label class="right inline">商品名称:</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" name="good_name" value="{{old('good_name')}}" placeholder="商品名称">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label class="right inline">商品分类:</label>
                    </div>
                    <div class="small-9 columns">
                        <select name="cat_id">
                            @foreach($cats as $cat)
                                <option value="{{$cat->id}}" {{old('cat_id') == $cat->id ? "selected" : ""}}>{{$cat->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label class="right inline">商品描述:</label>
                    </div>
                    <div class="small-9 columns">
                        <textarea name="description" placeholder="商品描述（此处应支持HTML）">{{old('description')}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label class="right inline">商品价格:</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" name="price" value="{{old('price')}}" placeholder="商品价格">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label class="right inline">商品类型:</label>
                    </div>
                    <div class="small-9 columns">
                        <select name="type">
                            <option value="0" {{old('type') == '0' ? "selected" : ""}}>普通商品</option>
                            <option value="1" {{old('type') == '1' ? "selected" : ""}}>拍卖商品</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label class="right inline">商品数量:</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="number" name="count" value="{{old('count')}}" placeholder="库存">
                    </div>
                </div>
                {{--
                <div class="row">
                    <div class="small-2 columns">
                        <label class="right inline">商品标签:</label>
                    </div>
                    <div class="small-10 columns">
                        @foreach($tags as $tag)
                            <label><input type="checkbox" name="good_tag[]" value="{{$tag->id}}">{{$tag->tag_name}}</label>
                        @endforeach
                        <label><input type="checkbox" name="good_tag[]" value="0">自定义
                            <input type="text" name="other_tag" value="" placeholder="自定义标签请在这里输入"></label>
                    </div>
                </div>
                --}}
                <div class="row">
                    <div class="small-3 columns">
                        <label for="goodTitleUpload" class="button right inline">上传封面</label>
                    </div>
                    <div id="preview" class="small-9 columns"></div>
                    <div style="display: none">
                        <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic"
                               onchange="preview(this)"/>
                        <input id="goodTitleUploadCpWidth" type="hidden" name="crop_width">
                        <input id="goodTitleUploadCpHeight" type="hidden" name="crop_height">
                        <input id="goodTitleUploadCpX" type="hidden" name="crop_x">
                        <input id="goodTitleUploadCpY" type="hidden" name="crop_y">
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
    </div>
    <script type="text/javascript">
        function preview(file) {
            var prevDiv = document.getElementById('preview');
            if (file.files && file.files[0]) {
                var prreader = new FileReader();
                var reader = new FileReader();
                reader.onload = function (evt) {
                    prevDiv.innerHTML = '<img id="goodimgpreview" src="' + evt.target.result + '" />';
                    $jQuery_FOUNDATION('#goodimgpreview').cropper({
                        aspectRatio: 16 / 9,
                        crop: function (e) {
                            $("#goodTitleUploadCpX").val(e.x);
                            $("#goodTitleUploadCpY").val(e.y);
                            $("#goodTitleUploadCpWidth").val(e.width);
                            $("#goodTitleUploadCpHeight").val(e.height);
                        }
                    });
                };
                prreader.onload = function (evt) {
                    var fileBuf = new Uint8Array(evt.target.result.slice(0, 11));
                    var mime = isImage(fileBuf);
                    if (mime == null) {
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
            else {
                prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
            }
        }
    </script>

@endsection