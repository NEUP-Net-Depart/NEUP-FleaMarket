@extends('layout.master')

@section('title', "用户")

@section('asset')
    <script src="/js/avatar_crop.js"></script>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="d-none d-md-block col-auto" style="width:130px">
                <ul class="nav nav-pills flex-column" style="width:100px">
                    <li class="nav-item"><a class="nav-link @if(!isset($tab) || ($tab != 'account') && ($tab != 'contact')) active @endif" href="/user">个人信息</a></li>
                    <li class="nav-item"><a class="nav-link @if($tab == 'account') active @endif" href="/user?tab=account">用户帐户</a></li>
                    <li class="nav-item"><a class="nav-link @if($tab == 'contact') active @endif" href="/user?tab=contact">联系方式</a></li>
                </ul>
            </div>
            <div class="d-md-none col-12">
                <div class="row">
                    <div class="mx-auto">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link @if(!isset($tab) || ($tab != 'account') && ($tab != 'contact')) active @endif" href="/user">个人信息</a></li>
                            <li class="nav-item"><a class="nav-link @if($tab == 'account') active @endif" href="/user?tab=account">用户帐户</a></li>
                            <li class="nav-item"><a class="nav-link @if($tab == 'contact') active @endif" href="/user?tab=contact">联系方式</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="mx-auto">
                        @if(!isset($tab) || $tab == 'profile')
                            <div id="profile">
                                <form action="/user" method="POST" enctype="multipart/form-data">
                                    @include('user.editUserExtra')
                                    <div class="row">
                                        <div class="mx-auto">
                                            <input class="btn btn-success" type="submit" name="submit" value="保存">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if($tab == 'account')
                            <div id="account">
                                @include('user.editUserAccount')
                            </div>
                        @endif
                        @if($tab == 'contact')
                            <div id="contact">
                                @include('user.userInfo')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection