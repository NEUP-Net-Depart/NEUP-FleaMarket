@extends('layout.master')

@section('title', "编辑私信")

@section('content')

    <div class="page-content">
        @foreach($informations as $information)
            <form action="/message/deletemessage/{{$information->id}}" method="POST">
                {!! csrf_field() !!}
                {{$information->title}}<br/>
                {{$information->content}}<br/>
                {{$information->created_at}}<br/>
                @if($information->sender_id != 0)
                    {{$users[$information->sender_id]->nickname}}<br/>
                @endif
                @if($information->sender_id ==0)
                    系统通知<br/>
                    <br/>
                @endif
                <input type="submit" value="Delete"><br/>
            </form>
        @endforeach
    </div>
    @include('layout.footer')
    @include('includes.foot')

@endsection