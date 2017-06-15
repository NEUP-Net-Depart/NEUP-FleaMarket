@extends('layout.master')

@section('title', "重置密码")

@section('asset')
    <style>
        @media (min-width: 992px) {
            .reset-card {
                width:400px;
            }
        }
    </style>
    <script>
        if (matchMedia) {
            var mq = window.matchMedia("(min-width: 992px)");
            mq.addListener(WidthChange);
            WidthChange(mq);
        }

        function WidthChange(mq) {
            if (mq.matches) {
                $('.row-first').attr('class','row row-first');
            } else {
                $('.row-first').attr('class','row-first');
            }
        }
    </script>
@endsection

@section('content')
    <div class="row row-first">
        <div class="mx-auto">
            <div class="card reset-card">
                <div class="card-header">重置密码</div>
                    <div class="card-block">
                        @if($method=="GET")
                        <form action="/iforgotit" method="POST">
                            <div class="form-group">
                                <label for="email">邮箱</label>
                                <input type="email" name="email" id="email" placeholder="你账号绑定的邮箱" class="form-control">
                            </div>
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="mx-auto">
                                    <input type="submit" class="btn btn-primary" value="确定">
                                </div>
                            </div>
                        </form>
                        @else
                            <div class="alert alert-{{$alert}}" role="alert">
                                <span class="fa fa-{{$fa}}" aria-hidden="true"></span>
                                {{$sentence}}
                            </div>
                            <div class="row">
                                <div class="mx-auto">
                                    <a href="/iforgotit" class="btn btn-primary">返回</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection