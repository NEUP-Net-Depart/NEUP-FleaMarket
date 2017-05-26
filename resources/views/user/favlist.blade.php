@extends('layout.master')

@section('title', "收藏夹")
@section('asset')
    <link rel="stylesheet" href="/css/favlist.css" />
@endsection

@section('content')

    <div class="page-content" style="margin:0px;">
        <div class="row hide-for-medium" >
            <h5 style="left:5%">收藏商品</h5>
            <table class="table">
                <tr>
                    <td>#</td>
                    <td>商品名称</td>
                    <td>商品价格</td>
                    <td>库存</td>
                </tr>
                @foreach($goods as $good)
                    <tr class="list">
                        <td>{{ $good->good_id }}</td>
                        <td class="name"><a href="/good/{{$good->good_id}}" onMouseOver="toolTip('<img src=/good/{{ sha1($good->good_id) }}/titlepic>')" onMouseOut="toolTip()">{{ $good_info[$good->good_id]->good_name }}</a><img src="/good/{{ sha1($good->good_id) }}/titlepic" class="pic" /></td>
                        <td>{{ $good_info[$good->good_id]->price }}</td>
                        <td>{{ $good_info[$good->good_id]->count }}</td>
                    </tr>
                @endforeach
            </table>
            <a href="/user/fav/edit" class="button">编辑收藏夹</a>
        </div>

        <form  method="POST" id="favdel" style="" class="hide-for-small-only">
            <div class="row small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row>
                <div class="row" >
                    <h4 style="float:left">收藏商品</h4>
                    <div class="small-3 medium-3 medium-offset-9 small-offset-3">
                    <button type="button" class="button" onclick="editfav()" id="editbutton">编辑收藏夹</button>
                    <input type="button" id="del_submit" class="button" value="删除选中商品" style="display: none" onclick="submitdel()"  />
                    </div>
                </div>

                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}

                @foreach($goods as $good)
                    <div class="columns yesrpg" id="good{{ $good->good_id }}" >
                        <div class="good">
                            <a href="/good/{{$good->good_id}}">
                                <div class="card" style="z-index:100;">
                                    <div class="card-divider" style="padding: 0;background-color:white;position:relative">
                                        <img src="/good/{{ sha1($good->good_id) }}/titlepic/"/>
                                        <div style="position:absolute;z-index:201;right:0%;top:0%;">
                                            <input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->good_id }}"
                                                   class="cb" onclick="{setValue({{ $good->good_id }})}" style="visibility:hidden;width:5%;z-index:203;position: absolute;" />
                                        </div>
                                        <div class="details" style="position:absolute;z-index:200;height:100%;width:100%;top:0%;display:none">
                                            <div style="position:absolute;z-index:200;left:+8%;">
                                                <p style="color:white">商品名：{{$good_info[$good->good_id]->good_name}} </p><br/>
                                            </div>
                                            <div style="position:absolute;z-index:200;left:+8%;bottom:0%">
                                                售价：￥{{ $good_info[$good->good_id]->price }}<br/>
                                                @if($good_info[$good->good_id]->count==0)
                                                    无库存QAQ
                                                @else
                                                    库存：{{ $good_info[$good->good_id]->count }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-section" style="border: 0;">
                                        <div class="one-line-text">{{ $good_info[$good->good_id]->good_name }}</div>

                                    </div>
                                </div>




                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        </form>



        <script src="/js/good/editfav.js"></script>
        <script src="/js/good/ToolTip.js"></script>
    </div>
@endsection