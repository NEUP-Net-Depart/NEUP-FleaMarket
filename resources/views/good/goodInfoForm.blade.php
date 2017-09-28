@extends('layout.master')

@section('title', "添加商品")

@section('content')
<div class="row">
    <div class="col col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                                <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                                {!! $errors->first() !!}
                            </div>
                        @endif
                    </div>
                </div>
                <form action=@if($add) "/good/add" @else "/good/{{$good->id}}/edit" @endif method="POST" enctype="multipart/form-data" id="add_form">
                    <div class="form-group">
                        <label for="good_name">商品名称</label>
                        <input name="good_name" id="good_name" class="form-control" value="{{count($errors) ? old('good_name') : $good->good_name}}" placeholder="商品名称">
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>商品分类</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select name="cat_id" class="btn btn-secondary dropdown-toggle w-100">
                                @foreach($cats as $cat)
                                    <option value="{{$cat->id}}" @if(($good->cat_id==$cat->id&&!count($errors))||(old('cat_id')==$cat->id&&count($errors)))  selected="selected" @endif>{{$cat->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="description">商品描述</label>
                                {{-- <a style="float:right;font-size:13px;margin:0;" class="hidden-sm-up" href="#" id="trg">more</a> --}}
                                <textarea name="description" id="description" placeholder="商品描述" class="form-control" style="resize:none;" rows="6">{!! count($errors) ? old('description') : $good->description !!}</textarea>
                                <textarea id="full" placeholder="商品描述" style="resize:none;display:none" rows="6" class="form-control"></textarea>
                                <div style="display:none" id="ele"></div>
                                <div class="d-sm-none">
                                    <div id="imgdiv"></div>
                                    <div id="mb_div_upload" style="display:none">
                                        <div style="margin-top:8px;text-align:right;display:block">
                                            <label style="margin-bottom:0">
                                                <a class="fa fa-plus-circle" style="font-size:60px;"></a>
                                                <input type="file" id="btn_file" style="display:none"  multiple="multiple">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="price">商品价格</label>
                                <input type="number" step="0.01" min="0" name="price" id="price" value="{{count($errors) ? old('price') : $good->price}}" placeholder="商品价格" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group d-none">
                                <label>商品类型</label>
                                <select name="type" class="btn btn-secondary dropdown-toggle" value="0">
                                    <option value="0" @if(($good->type==0&&!count($errors))||(old('type')==0&&count($errors))) selected="selected" @endif>普通商品</option>
                                    <option value="1" @if(($good->type==1&&!count($errors))||(old('type')==1&&count($errors))) selected="selected" @endif>拍卖商品</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="count">商品数量</label>
                                <input type="number" name="count" id="count" min="0" value="{{count($errors) ? old('count') : $good->count}}" placeholder="库存" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />
                            </div>
                        </div>
                    </div>
                    {{--
                        <div class="row">
                            <div class="col">
                                <label class="right inline">商品标签:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @foreach($tags as $tag)
                                    <label><input type="checkbox" name="good_tag[]" value="{{$tag->id}}">{{$tag->tag_name}}</label>
                                @endforeach
                                <label>
                                    <input type="checkbox" name="good_tag[]" value="0">
                                    自定义
                                    <input type="text" name="other_tag" value="" placeholder="自定义标签请在这里输入">
                                </label>
                            </div>
                        </div>
                    --}}
                    <div class="row">
                        <div class="col">
                            <label for="goodTitleUpload" class="btn btn-primary">上传封面</label>
                            <div id="preview"></div>
                        </div>
                        <div style="display:none">
                            <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic" onchange="preview(this)"/>
                            <input id="goodTitleUploadCpWidth" type="hidden" name="crop_width">
                            <input id="goodTitleUploadCpHeight" type="hidden" name="crop_height">
                            <input id="goodTitleUploadCpX" type="hidden" name="crop_x">
                            <input id="goodTitleUploadCpY" type="hidden" name="crop_y">
                        </div>
                    </div>
                    <p></p>
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-auto mr-auto"><input type="button" class="btn btn-primary" value="@if($add)添加@else更改@endif" onclick="mb_upload()"/></div>
                        <div class="col-auto ml-auto"><input type="button" class="btn btn-success" value="商品列表" onclick="window.location.href=('/good')"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function $_(id) {
        return document.getElementById(id);
    }
</script>
<script>
    function together(){
        var one=$("#description").froalaEditor('html.get');
        var another=$("#full").val();
        var be=$("#description").val();
        if( $('#trg').text()=="more"){
            $("#description").val((be+another).replace(/\n|\r\n/g,'<br>'));
        }
        else{
            $("#description").val(one);
        }
        var forma = document.getElementById("add_form");
        forma.submit();
    }
    $("#btn_file").change(function(){
        mb_preview();
        $("#btn_file").val("");
    });
    function mb_preview(){
        $_('imgdiv').innerHTML+="<p style='text-align:center;margin-top:20px'><a class='fa fa-spinner fa-pulse'></a>上传中</p>"
        var file = $_('btn_file').files[0];
        r = new FileReader();
        r.onload = function(evt){
            var data1=evt.target.result.slice(evt.target.result.indexOf("base64,")+7);
            $.ajax({
                type: "POST",
                url: "https://flimg.neupioneer.com/api/1/upload",
                async:false,
                data:{
                    "source":data1,
                    "key":"7e945496f2de8cbc710ecca702062e9b",
                    "format": "flea-mart"
                },
                crossDomain:true,
                success: function (msg) {
                    $("#imgdiv").find('p').remove();
                    $_('imgdiv').innerHTML += '<div><img style=border-radius:5px;margin-top:8px src="' + msg.link + '"/><a class="fa fa-trash" style="position:absolute;" onclick=mb_delete(this)></a></div>';
                },
            });
        }
        r.readAsDataURL(file);
    }

    function mb_upload(){
        var pics=$("#imgdiv").find("img");
        for(var i=0;i<pics.length;i++){
            var myStr = pics[i].getAttribute("src");
            if(myStr!="null"){
                var before= $("#description").val();
                var imgadd = "<img src='"+myStr+"'/>"
                $("#description").val(before+imgadd);
            }
        }
        together();
    }

    function mb_delete(me){
        if(confirm("放弃上传这张图片？"))
        $(me).parent().remove();
    }
    function preview(file) {
        var prevDiv = document.getElementById('preview');
        if (file.files && file.files[0]) {
            var prreader = new FileReader();
            var reader = new FileReader();
            reader.onload = function (evt) {
                prevDiv.innerHTML = '<img id="goodimgpreview" src="' + evt.target.result + '" />';
                $('#goodimgpreview').cropper({
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
                    alert("文件格式有误，请打开图片文件!");
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
    // WYSIWYG Editor
    editor();
    function editor(){
        $('#trg').text('less');
    $("#description").froalaEditor({
        imageUploadParam: 'source',
        imageUploadParams: {
        key: "7e945496f2de8cbc710ecca702062e9b",
            format: "flea-mart"
        },
        imageUploadURL: 'https://flimg.neupioneer.com/api/1/upload',
        requestWithCORS: true,
        pluginsEnabled: ['image','link', 'colors',
            'fontSize', 'fontFamily', 'fullscreen'],
        toolbarButtonsMD: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'align', 'quote', '-',
            'insertImage', '|', 'emoticons', 'help', 'fullscreen', '|', 'undo', 'redo'],
        toolbarButtonsSM: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'align', 'quote', '-',
            'insertImage', '|', 'emoticons', 'help', 'fullscreen', '|', 'undo', 'redo'],
        toolbarButtonsXS: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'align', 'quote', '-',
            'insertImage', '|', 'emoticons', 'help', 'fullscreen', '|', 'undo', 'redo'],
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'align', 'quote', '-', 'insertImage', '|', 'emoticons', 'help', 'fullscreen', '|', 'undo', 'redo'],
        height: 150
    });
    }
    $('a[href="https://www.froala.com/wysiwyg-editor?k=u"]').wrap("<div hidden='hidden'></div>");
    $(document).ready(function(){
        $('#trg').click(function(){
            var one=$('#description').froalaEditor('html.get');
            $("#ele").html(one);
            var another=$("#full").val();
            if( $('#trg').text()=="more"){
                var pics=$("#imgdiv").find("img");
                var imgs="";
                for(var i=0;i<pics.length;i++){
                    imgs+='<img src="' + pics[i].getAttribute('src') + '" />'
                }
                another=another.replace(/\n|\r\n/g,'<br/>');
                $('#description').froalaEditor('html.set',one+another+imgs);
                $("#imgdiv").html("");
                $('#description').val("");
                $("#full").hide();
                $("#full").val("");
                $('#trg').text('less');
                $('.fr-box').show();
                $("#mb_div_upload").hide();
                $("#ele").html("");
            }
            else{
                var pics=$("#ele").find("img");
                for(var i=0;i<pics.length;i++){
                    $_('imgdiv').innerHTML += '<div><img style=border-radius:5px;margin-top:8px src="' + pics[i].getAttribute('src') + '" /><a class="fa fa-trash" style="position:absolute" onclick=mb_delete(this)></a></div>';
                    $(pics[i]).remove();
                }
                var paras=$("#ele").find("p");
                var content="";
                for(var i=0;i<paras.length;i++){
                    if(paras[i].innerHTML==""){
                        $(paras[i]).remove();
                    }
                    else{
                        if(i!=0)
                            content+='\r\n';
                        content+=$(paras[i]).html();
                    }
                }
                $("#full").val((content+another).replace("&nbsp;"," "));
                $('#description').froalaEditor('html.set',"");
                $("#trg").text('more');
                $('.fr-box').hide();
                $("#full").show();
                $("#mb_div_upload").show();
                $('#description').val("");
                $("#ele").html("");
            }
        });
        if($(window).width()<=640)
        {
            $("#trg").text('more');
            $("#full").show();
            $('.fr-box').hide();
            $("#mb_div_upload").show();
            $("#trg").click();
            $("#trg").click();
        }
    });
</script>
@endsection
