@extends('layout.master')

@section('title', "重置密码")

@section('content')

    <div class="page-content">
        @if($method=="GET")
            <form action="/iforgotit" method="POST">
                Email: <input type="email" name="email">
                {!! csrf_field() !!}
                <input type="submit" class="button">
            </form>
        @else
            {{$sentence}}
            <a href="/iforgotit">Back</a>
        @endif
    </div>

@endsection