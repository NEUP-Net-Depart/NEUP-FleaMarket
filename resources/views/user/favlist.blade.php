@extends('layout.master')

@section('title', "收藏夹")

@section('asset')

    <style>
        h5 {
            color: #ffffff;
        }
        .pic{
            display:none;
            height:110px;
            width:200px;
        }
        .active{
            display:block;
        }
        .list{
            table-layout:fixed;
        }
    </style>

@endsection

@section('content')

    <div class="page-content">
        <div class="row">
            <h5>收藏商品</h5>
            <table class="table">
                <tr>
                    <td>#</td>
                    <td>商品名称</td>
                    <td>最低价格</td>
                    <td>最高价格</td>
                </tr>
                @foreach($goods as $good)
                    <tr class="list">
                        <td>{{ $good->good_id }}</td>
                        <td class="name"><a href="/good/{{$good->good_id}}">{{ $good_info[$good->good_id]->good_name }}</a><img src="/good/{{ sha1($good->good_id) }}/titlepic" class="pic" /></td>
                        <td>{{ $good_info[$good->good_id]->pricemin }}</td>
                        <td>{{ $good_info[$good->good_id]->pricemax }}</td>
                    </tr>
                @endforeach
            </table>
            <a href="/user/edit_favlist" class="button">编辑收藏夹</a>
        </div>
    </div>
    <script src="/js/good/favorlist.js"></script>
@endsection