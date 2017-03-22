@extends('layout.master')

@section('title', "重置密码")

@section('content')

    <div class="page-content">
        @if($method=="GET")
            <form action="/passwordReset/{{$token}}" method="POST">
                Password: <input type="password" name="password"></input>
                Again: <input type="password"></input>
                {!! csrf_field() !!}
                <input type="submit" class="button"></input>
            </form>
        @else
            {{$sentence}}
        @endif
    </div>

@endsection