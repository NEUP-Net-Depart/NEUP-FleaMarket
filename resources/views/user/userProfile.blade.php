@extends('layout.master')

@section('title', "用户")

@section('asset')

@endsection

@section('content')

        <div class="row">
            @if(isset($user->nickname))
                <h2>{{ $user->nickname }}</h2>
            @else
                <h2>还没有昵称>_<</h2>
            @endif
        </div>
        <div class="row">
            <img src="/avatar/{{ $user->id }}/256/256"/>
        </div>
@endsection