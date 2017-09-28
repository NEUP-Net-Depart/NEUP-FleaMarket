@extends('layout.master')

@section('title', "欢迎")

@section('asset')
    <script>
        $(document).ready(function() {
            $('.nickname-input').attr('placeholder','你可以随时修改你的昵称');
        });
    </script>
    <script src="/js/avatar_crop-20170927.js"></script>
@endsection

@section('content')
<div class="row">
    <div class="col col-lg-10 col-xl-9 mx-auto">
        <div class="card">
            <form action="/register/2" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        <span class="fa fa-check" aria-hidden="true"></span>
                        你已经成为了先锋市场的一份子啦！现在你可以为自己上传一个头像，以及取一个昵称。
                    </div>
                    @include('user.editUserExtra')
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-auto ml-auto">
                            <input class="btn btn-success" type="submit" name="submit" value="下一步">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection