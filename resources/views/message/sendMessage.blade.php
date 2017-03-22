@extends('layout.master')

@section('title', "发送消息")

@section('content')

    <div class="page-content">
        <form action="/message/send" method="post">
            Title:<input type="text" name="title"><br/>
            Content:<textarea name="content" row="15" cols="45"></textarea><br/>
            Receiver:<input type="text" name="receiver"><br/>
            {!! csrf_field() !!}
            <input type="submit" value="Send"><br/>
        </form>
    </div>

@endsection