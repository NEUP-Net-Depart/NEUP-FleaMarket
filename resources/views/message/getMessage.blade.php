@extends('layout.master')

@section('title', "私信")

@section('content')

    <a href="/message/editmessage">Edit</a><br/>
    <div class="page-content">
        @foreach($informations as $information)

            {{$information->title}}<br/>
            {{$information->content}}<br/>
            {{$information->created_at}}<br/>
            @if($information->sender_id != 0)
                {{$users[$information->sender_id]->nickname}}<br/>
            @endif
            @if($information->sender_id ==0)
                系统通知<br/>
            @endif

        @endforeach
    </div>

@endsection