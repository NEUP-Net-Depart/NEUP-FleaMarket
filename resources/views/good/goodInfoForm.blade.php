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

        <div class="panel panel-default">
            <div class="panel-body">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <form action= @if($add)"/good/add"@else"/good/{{$good->id}}/edit"@endif method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="good_name">商品名称</label>
                    <input type="text" name="good_name" id="good_name" class="form-control" value="{{count($errors) ? old('good_name') : $good->good_name}}" placeholder="商品名称">
                </div>
                <div class="form-group">
                    <label>商品分类</label>
                    <select name="cat_id" id="cat_id" class="btn btn-default dropdown-toggle" style="width:100%">
                        @foreach($cats as $cat)
                            <option value="{{$cat->id}}"  @if(($good->cat_id==$cat->id&&!count($errors))||(old('cat_id')==$cat->id&&count($errors))) 
                                        selected="selected" @endif>{{$cat->cat_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">商品描述</label>
                    <textarea name="description" id="description" placeholder="商品描述" class="form-control" style="resize:none" rows="6">{{count($errors) ? old('description') : $good->description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="price">商品价格</label>
                    <input type="number" min="0" name="price" id="price" value="{{count($errors) ? old('price') : $good->price}}" placeholder="商品价格" class="form-control">
                </div>
                <div class="form-group">
                    <label>商品类型</label>
                    <select name="type" class="btn btn-default dropdown-toggle" style="width:100%">
                        <option value="0" @if(($good->type==0&&!count($errors))||(old('type')==0&&count($errors))) selected="selected" @endif>普通商品</option>
                        <option value="1" @if(($good->type==1&&!count($errors))||(old('type')==1&&count($errors))) selected="selected" @endif>拍卖商品</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="count">商品数量</label>
                    <input type="number" name="count" id="count" min="0" value="{{count($errors) ? old('count') : $good->count}}" placeholder="库存" class="form-control">
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
                <div>
                    <label for="goodTitleUpload" class="btn btn-primary">上传封面</label>
                    <div id="preview"></div>
                </div><br/>
                <div style="display: none">
                    <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic"
                            onchange="preview(this)"/>
                    <input id="goodTitleUploadCpWidth" type="hidden" name="crop_width">
                    <input id="goodTitleUploadCpHeight" type="hidden" name="crop_height">
                    <input id="goodTitleUploadCpX" type="hidden" name="crop_x">
                    <input id="goodTitleUploadCpY" type="hidden" name="crop_y">
                </div>
                {!! csrf_field() !!}
                <input type="submit" class="btn btn-primary" value="@if($add)添加@else更改@endif"/>
                <input type="button" class="btn btn-success" value="商品列表" onclick="window.location.href=('/good')">
            </form>
        </div>
        </div>
    </div>
    <script type="text/javascript">
        function preview(file) {
            var prevDiv = document.getElementById('preview');
            if (file.files && file.files[0]) {
                var prreader = new FileReader();
                var reader = new FileReader();
                reader.onload = function (evt) {
                    prevDiv.innerHTML = '<br/><img id="goodimgpreview" src="' + evt.target.result + '" />';
                    $jQuery_CROPPER('#goodimgpreview').cropper({
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
                    /*var mime = isImage(fileBuf);
                    if (mime == null) {
                        //This should be modified
                        alert("Please open image!");
                        return;
                    }
                    else {*/
                        reader.readAsDataURL(file.files[0]);
                    //}
                };
                prreader.readAsArrayBuffer(file.files[0]);
            }
            else {
                prevDiv.innerHTML = '<br/><div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
            }
        }
    </script>

@endsection