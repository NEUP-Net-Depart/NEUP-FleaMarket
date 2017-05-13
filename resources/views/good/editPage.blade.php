@extends('layout.master')

@section('title', "编辑商品")

@section('asset')

    <style>
        label {
            text-align: right;
            font-size: medium;
            min-width: 80px;
            max-width: 100px;
            float: right;
        }
    </style>

@endsection

@section('content')

    <div class="page-content">
        <div class="large-8 large-offset-2 small-10 small-offset-1 columns">
            @foreach($goods as $good)
                <form action="/good/{{$good->id}}/edit" method="POST">
                    <div class="row">
                        <div class="small-2 columns">
                            <label class="right inline">商品名称:</label>
                        </div>
                        <div class="small-10 columns">
                            <input type="text" name="good_name" value="{{$good->good_name}}" placeholder="商品名称">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-2 columns">
                            <label class="right inline">商品分类:</label>
                        </div>
                        <div class="small-10 columns">
                            <select name="cat_id">
                                @foreach($cats as $cat)
                                    <option value="{{$cat->id}}"
                                            @if($good->cat_id==$cat->id) selected="selected" @endif>{{$cat->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-2 columns">
                            <label class="right inline">商品描述:</label>
                        </div>
                        <div class="small-10 columns">
                            <textarea name="description" placeholder="商品描述（此处应支持HTML）">{{$good->description}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-2 columns">
                            <label class="right inline">商品价格:</label>
                        </div>
                        <div class="small-10 columns">
                            <input type="number" name="price" value="{{$good->price}}" placeholder="商品价格">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-2 columns">
                            <label class="right inline">商品类型:</label>
                        </div>
                        <div class="small-10 columns">
                            <select name="type">
                                <option value="0" @if($good->type==0) selected="selected" @endif>普通商品</option>
                                <option value="1" @if($good->type==1) selected="selected" @endif>拍卖商品</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-2 columns">
                            <label class="right inline">商品数量:</label>
                        </div>
                        <div class="small-10 columns">
                            <input type="number" name="count" value="{{$good->count}}" placeholder="库存">
                        </div>
                    </div>
                    {{--
                    <div class="row">
                        <div class="small-2 columns">
                            <label class="right inline">商品标签:</label>
                        </div>
                        <div class="small-10 columns">
                            @foreach($tags as $tag)
                                @if(in_array($tag->id, $this_good_tags))
                                    <label><input type="checkbox" name="good_tag[]" value="{{$tag->id}}" checked="checked">{{$tag->tag_name}}</label>
                                @else
                                    <label><input type="checkbox" name="good_tag[]" value="{{$tag->id}}">{{$tag->tag_name}}</label>
                                @endif
                            @endforeach
                                <label><input type="checkbox" name="good_tag[]" value="0">自定义
                                    <input type="text" name="other_tag" value="" placeholder="自定义标签请在这里输入"></label>
                        </div>
                    </div>
                    --}}
                    {{--            <div class="row">
                                    <div class="small-4 columns">
                                        <label for="goodTitleUpload" class="button right inline">上传封面</label>
                                    </div>
                                    <div id="preview" class="small-8 columns"></div>
                                    <div style="display: none">
                                        <input type="file" id="goodTitleUpload" class="show-for-sr" name="goodTitlePic"
                                               onchange="preview(this)"/>
                                    </div>
                                </div>
                                <p></p>--}}
                    <div class="row">
                        <div class="small-2 small-offset-3 columns">
                            <input type="submit" class="button" value="更改" style="margin: 0;"/>
                        </div>
                        <div class="small-4 columns">
                            <a href='/good/{{$good->id}}' class="button">商品信息</a>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                </form>
            @endforeach
            @if(count($errors) > 0)
                @foreach($errors as $error)
                    {{$error}}
                @endforeach
            @endif
        </div>
    </div>
@endsection