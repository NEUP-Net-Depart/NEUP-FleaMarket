@extends('layout.master')

@section('title', "欢迎")

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="row">
                    <div class="bs-callout bs-callout-info" role="alert">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        你已经成为了先锋市场的一分子啦！现在你可以为自己取一个昵称，以及上传一个头像。
                    </div>
                </div>
                <div class="row">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;">
                            <span class="sr-only">33% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <form action="/register/2" method="POST" enctype="multipart/form-data">
                        @include('user.editUserExtra')
                        <br/>
                        <div class="pull-left">
                            <input class="btn btn-primary" type="submit" name="submit" value="保存">
                        </div>
                        <div class="pull-right">
                            <a href="/register/3" class="pull-right btn btn-default">跳过</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection