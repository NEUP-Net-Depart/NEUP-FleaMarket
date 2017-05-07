@extends('layout.master')

@section('title', "我的商品")

@section('asset')
<style>
    h5 {
        color: #ffffff;
    }
</style>
@endsection

@section('content')

<div class="page-content">
    <div class="row">
        <h5>商品列表</h5>
        <table class="table">
            <tr>
                <td>#</td>
                <td>商品名称</td>
                <td>最低价格</td>
                <td>最高价格</td>
                <td>修改信息</td>
                <td>删除商品</td>
            </tr>
            @foreach($goods as $good)
                <tr>
                    <td>{{ $good->id }}</td>
                    <td><a href="/good/{{$good->id}}">{{ $good->good_name }}</a></td>
                    <td>{{ $good->pricemin }}</td>
                    <td>{{ $good->pricemax }}</td>
                    <td>
                        <form action="/good/{{ $good->id }}/edit">
                            <input type="submit" class="button" value="修改" style="margin: 0;">
                        </form>
                    </td>
                    <td>
                        <form action="/good/{{ $good->id }}/delete" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="submit" class="button" value="删除" style="margin: 0;">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        <a href="/good/add" class="button">添加商品</a>
    </div>
</div>

@endsection