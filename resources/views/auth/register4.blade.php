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
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                    添加额外的联系方式：除了刚才设置的，这些联系方式也会在你的交易成立时传达给对方。
                </div>
                <div id="userinfo-container">
                    @include('user.userInfo')
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="ml-auto" style="margin-right:5px">
                        <button onclick="window.location.href='/'" class="btn btn-success">完成</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection