@extends('layout.master')

@section('title', "完善个人信息")

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <div class="col-xs-12">
                <a href="/register/3" class="pull-right">>>下一步</a>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {!! $errors->first() !!}
                </div>
            @endif
            <form action="/register/2" method="POST" enctype="multipart/form-data">
                @include('user.editUserExtra')
            </form>
            </div>
        </div>
    </div>
@endsection