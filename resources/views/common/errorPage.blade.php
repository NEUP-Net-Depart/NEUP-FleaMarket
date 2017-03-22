@extends('layout.master')

@section('title', "出错辣！！！")

@section('content')

    <div class="page-content">
        @if(count($errors) > 0)
            <label>
                <span class="form-error is-visible">{!! $errors->first() !!}</span>
            </label>
        @endif
    </div>

@endsection