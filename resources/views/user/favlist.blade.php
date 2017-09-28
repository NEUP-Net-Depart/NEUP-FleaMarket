@extends('layout.master')

@section('title', "收藏夹")

@section('asset')
    <link rel="stylesheet" href="/css/favlist.css" />
@endsection

@section('content')
<form method="POST" id="favdel">
    <div class="row">
        <div class="col-auto mr-auto"><h4>收藏商品</h4></div>
        <div class="col-auto ml-auto">
            <a href="#" class="btn btn-primary" onclick="editfav()" id="editbutton">编辑收藏夹</a>
            <a href="#" class="btn btn-primary" onclick="submitdel()" style="display:none" id="del_submit">删除选中商品</a>
        </div>
    </div>
    <div class="row">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        @foreach($goods as $good)
            <?php $good = $good_info[$good->good_id] ?>
            @include('good.goodInfoOnWelcome')
        @endforeach
    </div>
</form>

<script src="/js/good/editfav-20170928.js"></script>
<script src="/js/good/ToolTip.js"></script>
@endsection