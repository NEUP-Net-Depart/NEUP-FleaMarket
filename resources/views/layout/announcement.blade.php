@extends('layout.master')

@section('title', "公告")

@section('content')

  <h2>{{ $announcement->title }}</h2>
  {!! $announcement->content !!}

@endsection
