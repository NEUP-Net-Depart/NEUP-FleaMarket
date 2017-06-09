@extends('layout.master')

@section('title', "登录")

@section('content')

    <div class="row align-middle">
        <div class="hide-for-small-only medium-6 columns thumbnail">
            <img src="/img/loginpic.jpg"/>
        </div>
        <div class="small-10 small-pull-1 medium-4 medium-offset-1 columns card">
            <div class="card-section">
                @if (count($errors) > 0)
                    <label>
                        <span class="form-error is-visible">{!! $errors->first() !!}</span>
                    </label>
                @endif
                <form action="/login" method="POST" data-abide novalidate>
                    <label>用户名/邮箱<input type="text" name="username"></label>
                    <label>密码<input type="password" id="password" name="password"></label>
                    {!! csrf_field() !!}
                    <input type="submit" class="hollow button" value="登录">
                </form>
            </div>
        </div>
    </div>

@endsection