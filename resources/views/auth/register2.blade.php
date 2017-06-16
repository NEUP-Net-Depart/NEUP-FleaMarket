@extends('layout.master')

@section('title', "欢迎")

@section('asset')
    <style>
        #preview, #avatarpreview {
            max-width: 100%;
            height:230px;
        }
        @media (min-width: 768px) {
            .register-card {
                width:768px;
            }
            .register-input {
                width:300px;
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.nickname-input').attr('placeholder','你可以随时修改你的昵称');
        });

        function WidthChange(mq) {
            if (mq.matches) {
                $('.row-first').attr('class','row row-first');
                $('.nickname-form').attr('class','nickname-form row');
            } else {
                $('.row-first').attr('class','row-first');
                $('.nickname-form').attr('class','nickname-form');
            }
        }
    </script>
@endsection

@section('content')
<div class="row-first" style="margin-top:20px">
    <div class="mx-auto">
        <div class="card register-card">
            <form action="/register/2" method="POST" enctype="multipart/form-data">
                <div class="card-block">
                    <div class="alert alert-success" role="alert">
                        <span class="fa fa-check" aria-hidden="true"></span>
                        你已经成为了先锋市场的一份子啦！现在你可以为自己上传一个头像，以及取一个昵称。
                    </div>
                    <div class="container">
                        @include('user.editUserExtra')
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="ml-auto" style="margin-right:5px">
                            <input class="btn btn-success" type="submit" name="submit" value="下一步">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection