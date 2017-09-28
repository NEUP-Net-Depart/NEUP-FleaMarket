@extends('layout.master')

@section('title', "重置密码")

@section('content')
<div class="row">
    <div class="col-12 col-md-7 col-lg-6 col-xl-5 mx-auto">
        <div class="card">
            <div class="card-header">重置密码</div>
                <div class="card-body">
                    @if($method == "GET")
                        <form action="/passwordReset/{{ $token }}" method="POST">
                            <div class="form-group">
                                <label for="password">新密码</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">确认密码</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
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
                                <a href="/" class="btn btn-primary">返回</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection