@extends('layout.master')

@section('title', "忘记密码")

@section('content')
<div class="row">
    <div class="col-12 col-md-7 col-lg-6 col-xl-5 mx-auto">
        <div class="card">
            <div class="card-header">忘记密码</div>
                <div class="card-body">
                    @if($method == "GET")
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
                        <div class="alert alert-{{ $alert }}" role="alert">
                            <span class="fa fa-{{ $fa }}" aria-hidden="true"></span>
                            {{ $sentence }}
                        </div>
                        <div class="row">
                            <div class="mx-auto">
                                <a href="/login" class="btn btn-primary">返回</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection