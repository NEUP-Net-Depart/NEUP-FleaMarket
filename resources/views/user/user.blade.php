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

    <div class="page-content">
        <ul class="tabs" data-tabs id="editinfo">
            <li class="tabs-title is-active"><a href="#extra" aria-selected="true">个人信息</a></li>
            <li class="tabs-title"><a href="#account">用户帐户</a></li>
            <li class="tabs-title"><a href="#userinfo">联系方式</a></li>
        </ul>
        <div class="tabs-content" data-tabs-content="editinfo">
            <div class="tabs-panel" id="extra">
                <div class="card-section">
                    <form action="/user/{{$user->id}}/edit/middle" method="POST" enctype="multipart/form-data">
                        @include('user.editUserExtra')
                    </form>
                </div>
            </div>
            <div class="tabs-panel" id="account">
            </div>
            <div class="tabs-panel" id="userinfo">
                <div class="card-section">
                    @include('user.userInfo')
            </div>
        </div>
    </div>

@endsection