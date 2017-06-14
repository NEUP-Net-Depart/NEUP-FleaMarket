@extends('layout.master')

@section('title', "消息中心")

@section('content')

    <div id="message">
        {{--<a v-on:click="refreshContact">???</a>--}}
        <div class="row">
            <div class="column large-8 small-12">
                <message-dialog ref="messageDialog" v-on:top-contact="topContactCallback"
                                v-on:network-error="stopTimerCallback"></message-dialog>
            </div>
            <div class="column large-4 small-12">
                <contact-list ref="contactList" v-on:load-dialog="loadDialogCallback"
                              v-on:network-error="stopTimerCallback"></contact-list>
            </div>
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
                            v-bind:key="contact.contact_id" v-for="(contact, index) in contacts"
                            v-on:click="loadDialog(index)">
                            <tr>
                                <td>
                                <span>
                                    <img class="mavatar" :src="'/avatar/' + contact.contact_id + '/64/64'"/>
                                    <i v-if="contact.unread_count > 0"
                                       class="balloon-tip">@{{ contact.unread_count }}</i>
                                </span>
                                </td>
                                <td>
                                    <p class="con-name">@{{ contact.contact_id == 0 ? "系统消息" :
                                    (contact.contact.baned == 0 ? contact.contact.nickname :
                                    contact.contact.nickname + '【已封禁】') }}</p>
                                </td>
                            </tr>
                            <span id="contact-closer" class="badge secondary"
                                  v-on:click="closeContact(index)">X</span>
                        </li>
                    </transition-group>
                </table>
            </ul>
            <a v-if="hasMore" v-on:click="getHistoryContact(false)">加载更多</a>
        </div>
    </script>

    <script type="text/x-template" id="message_dialog">
        <div>
            <p v-if="messages.length == 0" style="text-align: center">暂无消息</p>
            <div :class="{ hide: isHidden }">
                <a v-if="hasMore" v-on:click="getHistoryMessage(-1)">加载更多</a>
                <p v-else>没有更多了</p>
                <ul id="message-container" class="message-container">
                    <transition-group name="message-list" tag="ul">
                        <li :class="{ box: message.type !== 'history-info' }" class="msg message-list-item"
                            v-for="message in messages" v-bind:key="message.id">
                        <span v-if="message.type !== 'history-info'">
                        <img class="mavatar" :src="'/avatar/' + message.sender_id + '/64/64'"/>
                            <p v-if="contact_id == 0" class="message-content" v-html="message.content"></p>
                            <p v-else class="message-content">@{{ message.content }}</p>
                            <br/><br/>
                        <i class="time-tag">@{{ message.updated_at }}</i>
                        </span>
                            <span v-else>
                            <i class="history-text">以上是历史消息</i>
                            <hr/>
                        </span>
                        </li>
                    </transition-group>
                </ul>
                <p class="err-msg" v-if="errorMessage">@{{ errorMessage }}</p>
                <textarea placeholder="键入要发送的内容:" v-model="inputMessage"></textarea>
                <input type="button" class="button" value="发送" v-on:click="sendMessage"/>
                <input id="token" type="hidden" value="{{ csrf_token() }}"/>
            </div>
        </div>
    </script>

    <script src="https://unpkg.com/vue@2.3.4/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/message.js"></script>
    <link rel="stylesheet" href="/css/message.css">

@endsection