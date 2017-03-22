@extends('layout.master')

@section('title', "商品列表")

@section('content')

    <h2>{{ $announcement->title }}</h2>
    {{ $announcement->content }}

@endsection