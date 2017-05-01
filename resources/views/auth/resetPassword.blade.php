@extends('layout.master')

@section('title', "重置密码")

@section('content')

    <div class="page-content">
        @if($method=="GET")
            <form action="/passwordReset/{{$token}}" method="POST">
                Password: <input type="password" name="password">
                Again: <input type="password" name="password_confirmation">
                {!! csrf_field() !!}
                <input type="submit" class="button">
            </form>
        @else
            {{$sentence}}
        @endif
    </div>

@endsection