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
    <ul class="tabs" data-tabs id="editinfo">
        <li class="tabs-title @if($tab == "profile") is-active @endif"><a href="#extra" aria-selected="true">个人信息</a></li>
        <li class="tabs-title @if($tab == "account") is-active @endif"><a href="#account">用户帐户</a></li>
        <li class="tabs-title @if($tab == "contact") is-active @endif"><a href="#userinfo">联系方式</a></li>
    </ul>
    <div class="tabs-content" data-tabs-content="editinfo">
        <div class="tabs-panel" id="extra">
            <div class="card-section">
                <form action="/user" method="POST" enctype="multipart/form-data">
                    @include('user.editUserExtra')
                </form>
            </div>
        </div>
        <div class="tabs-panel" id="account">
            <div class="card-section">
                @include('user.editUserAccount')
            </div>
        </div>
        <div class="tabs-panel" id="userinfo">
            <div id="userinfo-container" class="card-section">
                @include('user.userInfo')
            </div>
        </div>
    </div>
@endsection