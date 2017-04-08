@extends('layout.master')

@section('title', "添加联系方式")

@section('content')

    <div class="row card">
        <div class="row">
            <div class="small-offset-11 small-1">
                <a href="/register/3">跳过</a>
            </div>
        </div>
        <div class="medium-4 medium-centered small-8 small-centered columns card-section">
            @if (count($errors) > 0)
                <label>
                    <span class="form-error is-visible">{!! $errors->first() !!}</span>
                </label>
            @endif
            <form action="/register/3" method="POST" enctype="multipart/form-data">
                @include('user.userInfo')
            </form>
        </div>
    </div>
@endsection