@extends('layout.master')

@section('title', "欢迎")

@section('content')

    <div class="card">
        <div class="card-block">
            <div class="row">
            <div class="col-10 offset-1 col-md-8 offset-md-2">
                    <div class="alert alert-success" role="alert">
                        <span class="fa fa-check" aria-hidden="true"></span>
                        你已经成为了先锋市场的一分子啦！现在你可以为自己取一个昵称，以及上传一个头像。
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;">
                        </div>
                    </div><br/>
                    <form action="/register/2" method="POST" enctype="multipart/form-data">
                        @include('user.editUserExtra')
                        <br/>
                        <div class="float-left">
                            <input class="btn btn-primary" type="submit" name="submit" value="保存">
                        </div>
                        <div class="float-right">
                            <a href="/register/3" class="ml-auto btn btn-secondary">跳过</a>
                        </div>
                    </form>
            </div>
            </div>
        </div>
    </div>
@endsection