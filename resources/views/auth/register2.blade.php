@extends('layout.master')

@section('title', "完善个人信息")

@section('content')

    <div class="row card">
        <div class="row" style="margin-top: 5px">
            <div class="small-offset-10 small-2 medium-offset-11 medium-1">
                <a href="/register/3">跳过</a>
            </div>
        </div>
        <div class="medium-4 medium-centered small-8 small-centered columns card-section">
            @if (count($errors) > 0)
                <label>
                    <span class="form-error is-visible">{!! $errors->first() !!}</span>
                </label>
            @endif
            <form action="/register/2" method="POST" enctype="multipart/form-data">
                @include('user.editUserExtra')
            </form>
        </div>
    </div>
@endsection