@extends('layout.master')

@section('title', "收藏夹")
@section('asset')
    <link rel="stylesheet" href="/css/favlist.css" />
@endsection

@section('content')
    <h5>收藏商品</h5>
    <div class="page-content">

        <div class="row" style="display: none">
            <h5>收藏商品</h5>
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

        <form  method="POST" id="favdel">
        <div class="row small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row>
            <div class="small-1 medium-1 medium-offset-10 columns">
            <button type="button" class="button" onclick="editfav()" id="editbutton">编辑收藏夹</button>
            <input type="button" id="del_submit" class="button" value="删除选中商品" style="display: none" onclick="submitdel()"  />

            </div>

                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}

            @foreach($goods as $good)
        <div class="columns" id="good{{ $good->good_id }}">
            <div style="bottom:-50px;left:+185px;z-index:100;position:relative">
            <input type="checkBox" name="del_goods[]" value="0" id="box{{ $good->good_id }}"
                   class="cb" onclick="{setValue({{ $good->good_id }})}" style="visibility:hidden;width:30px;height:30px;" />
            </div>

            <div class="good">
                <a href="/good/{{$good->good_id}}">
                    <div class="card">

                        <div class="card-divider" style="padding: 5%;">
                            <img src="/good/{{ sha1($good->good_id) }}/titlepic/320/180"/>
                        </div>
                        <div class="card-section">
                            <div class="one-line-text">{{ $good->good_name }}</div>
                            <div style="color: #cc4b37;" class="one-line-text"><b>￥{{ $good_info[$good->good_id]->price }}</b></div>
                            @if($good_info[$good->good_id]->count==0)
                                <div style="color: #ffae00;" class="one-line-text">无库存QAQ</div>
                            @else
                                <div class="one-line-text">库存：{{ $good_info[$good->good_id]->count }}</div>
                            @endif
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
@endsection