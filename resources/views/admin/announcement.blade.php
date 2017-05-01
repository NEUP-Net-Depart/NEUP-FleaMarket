@extends('layout.master')

@section('title', "通知")

@section('content')

<div class="page-content">
    @foreach($announcements as $announcement)
    {{$announcement->title}}<br>
    {{$announcement->content}}<br>
    {{$announcement->created_at}}<br>
    @endforeach
</div>

@endsection