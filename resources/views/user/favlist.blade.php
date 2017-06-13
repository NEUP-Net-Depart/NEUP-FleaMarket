@extends('layout.master')

@section('title', "收藏夹")
@section('asset')
    <link rel="stylesheet" href="/css/favlist.css" />
@endsection

@section('content')
        <form  method="POST" id="favdel">
            <div class="col-sm-2">
                <h4>收藏商品</h4><br/>
            </div>
            <div class="col-sm-7">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            @foreach($goods as $good)
                <?php $good = $good_info[$good->good_id] ?>
                @include('good.goodInfoOnWelcome')
            @endforeach
            </div>
            <div class="col-sm-3">
                <a href="#" type="button" class="btn btn-primary" onclick="editfav()" id="editbutton">编辑收藏夹</a>
                <input type="button" id="del_submit" class="btn btn-primary" value="删除选中商品" style="display: none" onclick="submitdel()"  />
            </div>
        </form>

        <script src="/js/good/editfav.js"></script>
        <script src="/js/good/ToolTip.js"></script>
@endsection