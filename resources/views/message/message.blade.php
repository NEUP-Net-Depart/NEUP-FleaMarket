@extends('layout.master')

@section('title', "消息中心")

@section('content')

<div id="vue-error-msg" class="container hide">
    <div class="row col-xl-12 alert alert-danger" role="alert">
        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
        <p>
            如果您看到了这条消息，说明您使用的浏览器不兼容消息页面。建议您更换<strong>最新版Chrome浏览器</strong>
            以获得最佳浏览体验，给您带来的不便敬请谅解。
        </p>
        <img src="/img/sorry.png" class="img-responsive center-block"/>
    </div>
</div>

<div id="message" class="container">
    <div class="row">
        <div class="col-lg-8 col-12">
            <message-dialog ref="messageDialog" v-on:top-contact="topContactCallback" v-on:network-error="stopTimerCallback"></message-dialog>
        </div>
        <div class="col-lg-4 col-12">
            <contact-list ref="contactList" v-on:load-dialog="loadDialogCallback" v-on:network-error="stopTimerCallback"></contact-list>
        </div>
    </div>
</div>

<script type="text/x-template" id="contact_list">
    <div>
      <div :class="{ hide: !isHidden }">
          <span class="fa fa-spinner fa-spin" style="font-size:0.8em"></span>
          <span style="font-size:0.8em">Loading...</span>
      </div>
        {{--<a v-on:click="getNewContact">###</a>--}}
        <p class="err-msg" v-if="errorMessage">@{{ errorMessage }}</p>
        <ul id="contact-container" class="contact-container">
            <table class="con-wrapper">
                <transition-group name="contact-list" tag="ul">
                    <li :class="{ con: true, active: current_contact_id === contact.contact_id }"
                        v-bind:key="contact.contact_id" v-for="(contact, index) in contacts"
                        v-on:click="loadDialog(index)">
                        <i v-if="contact.unread_count > 0"
                           class="balloon-tip">@{{ contact.unread_count }}</i>
                        <tr>
                            <td>
                            <span>
                                <img class="mavatar" :src="'/avatar/' + contact.contact_id + '/64/64'"/>
                            </span>
                            </td>
                            <td>
                              <div :class="{ hide: isHidden }">
                                <p class="con-name"> @{{ contact.contact_id == 0 ? "系统消息" :
                                (contact.contact.baned == 0 ? contact.contact.nickname :
                                contact.contact.nickname + '【已封禁】') }}
                                    <img v-if="contact.contact_id != 0 && contact.contact.privilege == 1" src="https://img.shields.io/badge/%E5%85%88%E9%94%8B%E5%B8%82%E5%9C%BA-%E7%AE%A1%E7%90%86%E5%91%98-9300dd.svg">
                                    <img v-if="contact.contact_id != 0 && contact.contact.privilege == 2" src="https://img.shields.io/badge/%E5%85%88%E9%94%8B%E5%B8%82%E5%9C%BA-%E7%AE%A1%E7%90%86%E5%91%98-ee0000.svg">
                                </p>
                              </div>
                            </td>
                        </tr>
                        <span id="contact-closer" class="badge secondary" v-on:click="closeContact(index)">
                            X
                        </span>
                    </li>
                </transition-group>
            </table>
        </ul>
        <a href="javascript:void(0)" v-if="hasMore" v-on:click="getHistoryContact(false)">加载更多</a>
    </div>
</script>


<script type="text/x-template" id="message_dialog">
  <div>
    <div :class="{ hide: !isHidden }">
      <span class="fa fa-spinner fa-spin" style="font-size:1.5em"></span>
      <span style="font-size:1.5em">Loading...</span>
    </div>
      <div>
        <p v-if="messages.length == 0" style="text-align: center">暂无消息</p>
        <div :class="{ hide: isHidden }">
            <a href="javascript:void(0)" v-if="hasMore" v-on:click="getHistoryMessage(-1)">加载更多</a>
            <ul id="message-container" class="message-container">
                <transition-group name="message-list" tag="ul">
                    <li :class="{ box: message.type !== 'history-info' }" class="msg message-list-item"
                        v-for="message in messages" v-bind:key="message.id">
                    <span v-if="message.type !== 'history-info'">
                    <img class="mavatar" :src="'/avatar/' + message.sender_id + '/64/64'"/>
                        <p class="message-content" v-html="message.content"></p>
                        <br/><br/>
                    <i class="time-tag">@{{ message.created_at }}</i>
                    </span>
                        <span v-else>
                        <i class="history-text">以上是历史消息</i>
                        <hr/>
                    </span>
                </li>
            </transition-group>
        </ul>
        <p class="err-msg" v-if="errorMessage">@{{ errorMessage }}</p>
        <p><textarea placeholder="键入要发送的内容:" v-model="inputMessage" class="form-control"></textarea></p>
        <input type="button" class="btn btn-primary" value="发送" v-on:click="sendMessage"/>
        <input id="token" type="hidden" value="{{ csrf_token() }}"/>
        {{--<a v-on:click="getNewMessage">!!!</a>--}}
        </div>
    </div>
  </div>
</script>

{{--<script src="https://unpkg.com/vue@2.3.4/dist/vue.min.js"></script>--}}
<script src="/js/vue.min.js"></script>
{{--<script src="https://unpkg.com/axios/dist/axios.min.js"></script>--}}
<script src="/js/axios.min.js"></script>
<script src="/js/message-20170724.js"></script>
<script>
    window.onload = function () {
        setTimeout("$('#vue-error-msg').removeClass('hide')", 3000);
    }
</script>
<link rel="stylesheet" href="/css/message.css">

@endsection
