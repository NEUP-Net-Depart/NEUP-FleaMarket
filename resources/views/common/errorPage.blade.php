@extends('layout.master')

@section('title', 'QAQ')

@section('content')
@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
        {!! $errors->first() !!}
    </div>
@endif
@endsection