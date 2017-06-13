@extends('layout.master')

@section('title', "用户")

@section('asset')

    <style>
        .avatarpreview {
            max-width: 100%;
        }
    </style>

@endsection

@section('content')

    @if (count($errors) > 0)
        <label>
            <span class="form-error is-visible">{{$errors->first()}}</span>
        </label>
    @endif
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" @if($tab == "profile") class="active" @endif><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">个人信息</a></li>
        <li role="presentation" @if($tab == "account") class="active" @endif><a href="#account" aria-controls="account" role="tab" data-toggle="tab">用户帐户</a></li>
        <li role="presentation" @if($tab == "contact") class="active" @endif><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">联系方式</a></li>
    </ul>
    <div class="panel panel-default">
    <div class="tab-content panel-body">
        <div role="tabpanel" class="tab-pane @if($tab == 'profile') active @endif" id="profile">
            <div class="card-section">
                <form action="/user" method="POST" enctype="multipart/form-data">
                    @include('user.editUserExtra')
                </form>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane @if($tab == 'account') active @endif" id="account">
            <div class="card-section">
                @include('user.editUserAccount')
            </div>
        </div>
        <div role="tabpanel" class="tab-pane @if($tab == 'contact') active @endif" id="contact">
            <div id="userinfo-container" class="card-section">
                @include('user.userInfo')
            </div>
        </div>
    </div>
    </div>
@endsection