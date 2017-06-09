@extends('layout.master')

@section('title', "编辑私信")

@section('content')

    <div id="message">
        <a v-on:click="refreshContact">???</a>
        <contact-list ref="child"></contact-list>
    </div>
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

    <script type="text/x-template" id="contact_list">
        <div>
            <p v-if="errorMessage">@{{ errorMessage }}</p>
            <ul>
                <li v-for="contact in contacts">
                    <img :src="'/avatar/' + contact.contact_id + '/64/64'"/>
                    @{{ contact.contact.nickname }}&nbsp;@{{ contact.unread_count }}
                </li>
            </ul>
        </div>
    </script>
    <script src="https://unpkg.com/vue@2.3.4/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/message.js"></script>

@endsection