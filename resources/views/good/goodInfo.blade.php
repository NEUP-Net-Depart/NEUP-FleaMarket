@extends('layout.master')

@section('title', "商品详情")

@section('asset')
    <link rel="stylesheet" href="/css/lrtk.css"/>
    <style>
        .input-group:not(.search-group) {
            max-width: 240px;
        }
        .table-goodinfo > tbody > tr > th {
            max-width: 90px;
        }
        .left-part{
            max-width: 692px;
        }
    </style>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $('.popover-dismiss').popover({
            trigger: 'focus'
        })
    </script>
@endsection

@section('content')
<div class="row-first">
    <div class="mx-auto col main-part">
        <div class="row">
            <div class="left-part col-xs-12 col-lg-8">
                <div class="row"><div class="mx-auto"><a id="pic" href="/good/{{ sha1($good->id) }}/titlepic"><img src="/good/{{ sha1($good->id) }}/titlepic" style="width:100%;padding-left:15px;padding-right:15px"/></a></div></div>
                <p></p>
                <div class="card">
                    <div class="card-header">商品介绍</div>
                    <div class="card-body" style="word-break:break-all;min-height: 100px">{!! $good->description !!}</div>
                </div>
                <p></p>
            </div>
            <div class="col">
                <table class="table" style="margin-bottom:0px">
                    <td style="border-top: 0px">
                        <h4 style="display:inline-block;word-break:break-all">{{ $good->good_name }}@if($good->baned)【已封禁】@endif</h4>
                    </td>
                </table>
                <p></p>
            <div class="row">
            <div class="row mx-auto">
                <div>售价：<h3 style="display:inline-block"><b class="text-warning">￥{{ $good->price }}</b></h3></div>
            </div>
            </div>
            <div class="row">
            <div class="row mx-auto">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    {!! $errors->first() !!}
                </div>
            @endif
            </div>
            </div>
            <div class="row">
            <div class="row mx-auto">
            @if(($good->user_id) != Session::get('user_id') && !$good->baned)
                <p></p>
                <form action="/good/{{ $good->id }}/buy" method="post">
                    <div class="input-group">
                        <input type="number" name="count" value="1" class="form-control" min="0" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
                        {!! csrf_field() !!}
                        <span class="input-group-btn">
                        <input type="submit" class="btn btn-primary" value="购买"/>
                    </span>
                    </div>
                </form>
                <p></p>
            @endif
            </div>
            </div>
            <p></p>
                        <div class="row">
                        <div class="row mx-auto">
                        @if($good->user_id == Session::get('user_id') || Session::get('is_admin') == 2)
                            <form action="/good/{{ $good->id }}/edit" style="display:inline-block;" class="hidden-sm-down">
                                <input type="submit" class="btn btn-primary" value="修改" style="margin-left:5px;margin-right:5px">
                            </form>
                            <form action="/good/{{ $good->id }}/delete" method="POST" style="display:inline-block;" onsubmit="return confirm('确定删除吗？');" class="hidden-sm-down">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="submit" class="btn btn-primary" value="删除" style="margin-left:5px;margin-right:5px">
                            </form>
                        @endif
                        @if(Session::get('is_admin') >= 1 && !$good->stared)
                            <form action="/good/{{ $good->id }}/star" method="POST" style="display:inline-block;">
                                {!! csrf_field() !!}
                                <input type="submit" class="btn btn-primary" value="置顶" style="margin-left:5px;margin-right:5px">
                            </form>
                        @endif
                        @if(Session::get('is_admin') >= 1 && $good->stared)
                            <form action="/good/{{ $good->id }}/unstar" method="POST" style="display:inline-block;">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="submit" class="btn btn-primary" value="取下" style="margin-left:5px;margin-right:5px">
                            </form>
                        @endif
                        @if(Session::get('is_admin') >= 1 && !$good->baned)
                            <form action="/good/{{ $good->id }}/ban" method="POST" style="display:inline-block;">
                                {!! csrf_field() !!}
                                <input type="submit" class="btn btn-primary" value="封禁" style="margin-left:5px;margin-right:5px">
                            </form>
                        @endif
                        </div>
                        </div>
            </p>
            <div class="card">
            <div class="card-header">
            商品信息
            </div>
            <table class="table table-hover table-goodinfo" style="margin-bottom:0">
                <tbody>
                    <tr>
                        <th>卖家</th>
                        <td><a href="/user/{{ $user->id }}">@if($user->nickname!=""&&$user->nickname!=NULL){{ $user->nickname }} @else 还没有昵称&gt;_&lt; @endif @if($user->baned)【已封禁】@endif</a></td>
                    </tr>
                    @if($user->user_rank == "Undergraduate" || $user->user_rank == "Graduate")
                    <tr>
                        <td style="color: red" colspan="2" align="middle"><strong>此卖家很可能已经毕业</strong></td>
                    </tr>
                    @endif
                    <tr>
                        <th>库存</th>
                        <td @if($good->count==0) class="text-danger" @endif>@if($good->count>0) @if($good->count > 1){{ $good->count }} 件@else 仅一件 @endif @else 没库存了QAQ @endif</td>
                    </tr>
                    <tr>
                        <th>分类</th>
						<td>
						@if(Session::get('is_admin')>=1 && !$good->baned)
							<form action="/good/{{$good->id}}/updateCat" method="POST">
							{!! csrf_field() !!}
								<select name="cat_id" id="cat_id" class="btn btn-secondary dropdown-toggle btn-sm" onchange="this.form.submit()">
									@foreach($cats as $cat)
									<option value="{{$cat->id}}" @if(($good->cat_id==$cat->id&&!count($errors))||(old('cat_id')==$cat->id&&count($errors)))
										selected="selected" @endif>{{$cat->cat_name}}</option>
									@endforeach
								</select>
							</form>
                        @else
                        {{$good->cat->cat_name}}
						@endif
                        </td>
                    </tr>
                    <tr>
                        <th>收藏</th>
                        <td>
                @if(isset($inFvlst))
                    @if(count($inFvlst) == 0)
                        <button class="fa fa-star-o btn btn-primary btn-sm" onclick="add_favlist()" data-toggle="tooltip" data-placement="top" title="收藏OvO"></button>
                    @endif
                    @if(count($inFvlst) != 0)
                        <button class="fa fa-star btn btn-primary btn-sm" onclick="del_favlist()" data-toggle="tooltip" data-placement="top" title="取消收藏QAQ"></button>
                    @endif
                @else
                    <button class="fa fa-star-o btn btn-primary btn-sm" onclick="window.location.href='/login'" data-toggle="tooltip" data-placement="top" title="收藏OvO"></button>
                @endif
                        </td>
                    </tr>
                    <tr>
                        <th>收藏量</th>
                        <td>{{$good->fav_num}}</td>
                    </tr>
                    <tr>
                        <th>上架时间</th>
                        <td>{{$good->created_at}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
            </div>
        </div>
    </div>
</div>
    <script>
        function add_favlist() {
            var str_data = $("#fav input").map(function () {
                return ($(this).attr("name") + '=' + $(this).val());
            }).get().join("&");
            $.ajax({
                type: "POST",
                url: "/good/{{ $good->id }}/add_favlist",
                data: str_data,
                success: function (msg) {
                    $('.fa-star-o').attr('title','取消收藏QAQ');
                    $('.fa-star-o').attr('onclick', 'del_favlist()');
                    $('.fa-star-o').tooltip('dispose');
                    $('.fa-star-o').tooltip('show');
                    $('.fa-star-o').attr('class','fa fa-star btn btn-primary btn-sm');
                }
            });
        }
        function del_favlist() {
            var str_data1 = $("#fav input").map(function () {
                return ($(this).attr("name") + '=' + $(this).val());
            }).get().join("&");
            var str_data = str_data1 + '&_method=DELETE';
            $.ajax({
                type: "POST",
                url: "/good/{{ $good->id }}/del_favlist",
                data: str_data,
                success: function (msg) {
                    $('.fa-star').attr('title','收藏OvO');
                    $('.fa-star').attr('onclick', 'add_favlist()');
                    $('.fa-star').tooltip('dispose');
                    $('.fa-star').tooltip('show');
                    $('.fa-star').attr('class','fa fa-star-o btn btn-primary btn-sm');
                }
            });
        }
    </script>
    <form id="fav">
        {!! csrf_field() !!}
    </form>
@endsection

@section('navbm')
    <!--<div class="d--block d-md-none col-12" style="position:sticky;bottom:37px">
        <div class="float-left">
            @if(isset($inFvlst))
                @if(count($inFvlst) == 0)
                    <button class="fa fa-star-o btn btn-primary" onclick="add_favlist()" href="#" title="收藏OvO" style="position:relative;top:4px"></button>
                @endif
                @if(count($inFvlst) != 0)
                    <button class="fa fa-star btn btn-primary" onclick="del_favlist()" href="#" title="取消收藏QAQ" style="position:relative;top:4px"></button>
                @endif
            @else
                <button class="fa fa-star-o btn btn-primary" onclick="window.location.href='/login'" title="收藏OvO" style="position:relative;top:4px"></button>
            @endif
        </div>
        <div class="float-right">
            @if($good->user_id == Session::get('user_id') || Session::get('is_admin') == 2)
                <form action="/good/{{ $good->id }}/edit" style="display:inline-block;">
                    <input type="submit" class="btn btn-primary" value="修改">
                </form>
                <form action="/good/{{ $good->id }}/delete" method="POST" style="display:inline-block;" onsubmit="return confirm('确定删除吗？');">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <input type="submit" class="btn btn-primary" value="删除">
                </form>
            @endif
        </div>
    </div>-->
@endsection
