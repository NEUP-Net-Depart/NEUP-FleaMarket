@extends('layout.master')

@section('title', "即将打开新的大门")

@section('asset')
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
@endsection

@section('content')
<div class="row">
    <div class="col col-lg-10 col-xl-9 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    添加额外的联系方式：除了刚才设置的，这些联系方式也会在你的交易成立时传达给对方。
                </div>
                @include('user.userInfo')
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-auto ml-auto">
                        <button onclick="window.location.href='/'" class="btn btn-success">完成</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection