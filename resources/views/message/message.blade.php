@extends('layout.master')

@section('title', "消息中心")

@section('content')

    <div id="message">
        {{--<a v-on:click="refreshContact">???</a>--}}
            <div class="col-md-8 col-xs-12">
                <message-dialog ref="messageDialog" v-on:top-contact="topContactCallback"></message-dialog>
            </div>
            <div class="col-md-4 col-xs-12">
                <contact-list ref="contactList" v-on:load-dialog="loadDialogCallback"></contact-list>
            </div>
    </div>

    <script type="text/x-template" id="contact_list">
        <div>
            {{--<a v-on:click="getNewContact">###</a>--}}
            <p class="err-msg" v-if="errorMessage">@{{ errorMessage }}</p>
            <ul>
                <table class="con-wrapper">
                    <transition-group name="contact-list" tag="ul">
                    <li :class="{ con: true, active: current_contact_id === contact.contact_id }"
                        v-bind:key="contact.contact_id" v-for="(contact, index) in contacts" v-on:click="loadDialog(index)">
                        <tr>
                            <td>
                                <span>
                                    <img class="mavatar" :src="'/avatar/' + contact.contact_id + '/64/64'"/>
                                    <i v-if="contact.unread_count > 0" class="balloon-tip">@{{ contact.unread_count }}</i>
                                </span>
                            </td>
                            <td><p class="con-name">@{{ contact.contact_id == 0 ? "系统消息" : contact.contact.nickname }}</p></td>
                        </tr>
                    </li>
                    </transition-group>
                </table>
            </ul>
            <a v-if="hasMore" v-on:click="getHistoryContact(false)">加载更多</a>
        </div>
    </script>

    <script type="text/x-template" id="message_dialog">
        <div :class="{ hide: isHidden }">
            <a href="#" v-if="hasMore" v-on:click="getHistoryMessage(-1)">加载更多</a>
            <p v-else>没有更多了</p>
            <ul id="message-container" class="message-container">
                <transition-group name="message-list" tag="ul">
                <li class="msg message-list-item" v-for="message in messages" v-bind:key="message.id">
                    <img class="mavatar" :src="'/avatar/' + message.sender_id + '/64/64'"/>
                    @{{ message.content }}
                </li>
                </transition-group>
            </ul>
            <p class="err-msg" v-if="errorMessage">@{{ errorMessage }}</p>
            <textarea placeholder="键入要发送的内容:" v-model="inputMessage" class="form-control"></textarea><br/>
            <input type="button" class="btn btn-primary" value="发送" v-on:click="sendMessage"/>
            <input id="token" type="hidden" value="{{ csrf_token() }}"/>
            {{--<a v-on:click="getNewMessage">!!!</a>--}}
        </div>
    </script>

    <script src="https://unpkg.com/vue@2.3.4/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/message.js"></script>
    <link rel="stylesheet" href="/css/message.css">

@endsection