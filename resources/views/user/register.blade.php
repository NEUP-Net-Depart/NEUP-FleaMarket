@extends('layout.master')

@section('title', "注册")

@section('content')

    <div class="row card">
        <div class="medium-4 medium-centered small-8 small-centered columns card-section">
            @if (count($errors) > 0)
                <label>
                    <span class="form-error is-visible">{!! $errors->first() !!}</span>
                </label>
            @endif
            <form action="/register" method="POST" data-abide novalidate>
                <label>用户名<input type="text" name="username" placeholder="必填，3-64"></label>
                <label>密码<input type="password" id="password" name="password" placeholder="必填，6-128"></label>
                <label>确认密码<input type="password" name="password_confirmation" placeholder="必填"></label>
                <label>邮箱<input type="text" name="email" placeholder="必填"></label>
                <label>昵称<input type="text" name="nickname" placeholder="<=128"></label>
                {!! csrf_field() !!}
                <input type="submit" class="hollow button" value="注册">
            </form>
        </div>
    </div>

@endsection