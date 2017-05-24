@extends('layout.master')

@section('title', "编辑私信")

@section('content')

    <div class="page-content">
        @foreach($informations as $information)
            <form action="/message/{{$information->id}}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('delete') !!}
                {{$information->id}}<br/>
                {{$information->title}}<br/>
                {{$information->content}}<br/>
                {{$information->created_at}}<br/>
                {{$information->is_read}}<br/>
                @if($information->sender_id != 0)
                    {{$information->receiver->nickname}}<br/>
                @else
                    系统通知<br/>
                @endif
                <input type="submit" value="Delete"><br/>
                <br/>
            </form>
        @endforeach
            {{ $informations->links() }}
    </div>

@endsection