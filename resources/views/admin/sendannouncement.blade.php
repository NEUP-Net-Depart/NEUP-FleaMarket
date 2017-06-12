@extends('layout.master')

@section('title', "发布通知")

@section('content')

<div class="page-content">
    <form action="/sendannouncement" method="POST">
        Title:<input type="text" name="title"><br/>
        Content:<textarea name="content" row="15" cols="45"></textarea><br/>
        {!! csrf_field() !!}
        <input type="submit" value="Send"><br/>        
    </form>
</div>


@endsection
