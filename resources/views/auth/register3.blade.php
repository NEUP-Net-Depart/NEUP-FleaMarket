@extends('layout.master')

@section('title', "即将打开新的大门")

@section('asset')
    <style>
        @media (min-width: 768px) {
            .register-card {
                width:768px;
            }
            #modify_user_info_form {
                width:300px;
            }
        }
        @media (max-width: 767px) {
            .address-th {
                max-width: 200px;
            }
        }
        .table {
            table-layout: fixed;
        }
        .table td {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
    <script>
        function WidthChange(mq) {
            if (mq.matches) {
                $('.row-first').attr('class','row row-first');
                $('.table').attr('class','table table-hover');
                $('.row-form').attr('class','row row-form');
            } else {
                $('.row-first').attr('class','row-first');
                $('.table').attr('class','table table-hover table-responsive');
                $('.row-form').attr('class','row-form');
            }
        }

        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
@endsection

@section('content')
<div class="row row-first" style="margin-top:20px">
    <div class="mx-auto">
        <div class="card register-card">
            <div class="card-block">
                @if(true || $user->email=='' && $user->wechat_open_id=='')
                    <div class="alert alert-warning" role="alert">
                        绑定邮箱{{--或微信--}}，系统将会在买家或卖家发来消息时利用它们来通知你！
                    </div>
                @endif
                <div class="col col-xs-12 col-md-6 col-centered">
                    <p>
                    @if($user->email=='')
                        <form action="/user/edit/email" method="POST" class="password-form">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="邮箱" required>
                                <span class="input-group-btn"><input type="submit" class="btn btn-primary" name="email_submit" value="绑定"></span>
                            </div>
                        </form>
                    @else
                        <form action="/user/edit/email" method="POST" class="password-form">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="email" id="email" class="form-control" value="@if(!$user->havecheckedemail)[未验证]@endif{{$user->email}}" disabled>
                                <input type="hidden" name="email" id="email" class="form-control" value="{{$user->email}}">
                                <span class="input-group-btn"><input type="submit" class="btn btn-warning" name="email_submit" value="解绑"></span>
                            </div>
                        </form>
                        @endif
                        </p>
                        <p>
                        @if($user->wechat_open_id=='')
                            {{--<div class="password-form">
                                <div class="input-group">
                                    <label>微信：请在东大小秘书中点击“闲置市场”链接来关联微信。</label>
                                </div>
                            </div>--}}
                        @else
                            <div class="password-form">
                                <div class="input-group">
                                    <label>微信：已关联 <span class="nickname">{{$user->wechat->nick_name}}</span></label>
                                </div>
                                <div class="input-group">
                                    <img class="head-img col-centered" src="{{$user->wechat->head_img_url}}" width="64px" height="64px">
                                </div>
                            </div>
                            @endif
                            </p>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="ml-auto" style="margin-right:5px">
                        <button onclick="window.location.href='/register/4'" class="btn btn-success">下一步</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection