@extends('layout.master')

@section('title', "用户")

@section('asset')
    <style>
        #preview, #avatarpreview {
            max-width: 100%;
            height: 230px;
        }
        @media (min-width: 992px) {
            .nickname-input {
                width:300px;
            }
            .main-card {
                width: 992px;
            }
            .col-card {
                 max-width:130px;
            }
            .nav-pills {
                 width:100px;
            }
        }
    </style>
    <script>
        match_media = "(min-width:992px)";

        function WidthChange(mq) {
            if (mq.matches) {
                $('.row-first').attr('class','row row-first');
                $('.row-card').attr('class','row row-card');
                $('.nickname-form').attr('class','nickname-form row');
                $('.nav-pills').attr('class','nav nav-pills flex-column');
                $('.paowa').attr('class','paowa');
            } else {
                $('.row-first').attr('class','row-first');
                $('.row-card').attr('class','row-card');
                $('.nickname-form').attr('class','nickname-form');
                $('.nav-pills').attr('class','nav nav-pills');
                $('.paowa').attr('class','row paowa');
            }
        }
    </script>
@endsection

@section('content')

    @if (count($errors) > 0)
        <label>
            <span class="form-error is-visible">{{$errors->first()}}</span>
        </label>
    @endif
<div class="row-first" style="margin-top:20px">
    <div class="mx-auto">
    <div class="card main-card">
        <div class="card-block">
            <div class="row-card">
                <div class="col col-card">
                    <div class="row paowa">
                        <div class="mx-auto">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link @if(!isset($tab) || ($tab != 'account') && ($tab != 'contact')) active @endif" href="/user">个人信息</a></li>
                                <li class="nav-item"><a class="nav-link @if($tab == 'account') active @endif" href="/user?tab=account">用户帐户</a></li>
                                <li class="nav-item"><a class="nav-link @if($tab == 'contact') active @endif" href="/user?tab=contact">联系方式</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <p>
                <div class="col">
                    @if(!isset($tab) || $tab == 'profile')
                    <div id="profile">                
                        <form action="/user" method="POST" enctype="multipart/form-data">
                            @include('user.editUserExtra')
                            <div class="row">
                                <div class="ml-auto" style="margin-right:5px">
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
                </p>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection