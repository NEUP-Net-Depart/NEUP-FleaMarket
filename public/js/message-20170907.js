/**
 * Created by zhouz on 2017/6/10.
 * Fixed by NightSiesta on 2017/7/24
 * Fixed by NightSiesta on 2017/9/7
 */

// 联系人列表
var bus = new Vue();
Vue.component('contact-list', {
    template: '#contact_list',
    data: function () {
        return {
            isHidden:true,
            contacts: [],
            errorMessage: '',
            current_page: 0,
            last_page: null,
            current_contact_id: null,
            current_index: null
        }
    },
    computed: {
        hasMore: function () {
            return this.current_page < this.last_page;
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.$on('loadContactEvent', function () {
                this.clearContact();
                this.getHistoryContact(true);
            });
            this.$on('refreshContactEvent', function () {
                this.getNewContact();
            });
            this.$on('topContactHandler', function (contact_id) {
                this.setTop(this.contacts.filter(t => t.contact_id === contact_id));
            });
        })
    },
    methods: {
        clearContact: function () {
            this.current_page = 0;
            this.last_page = null;
            this.contacts = [];
            this.current_contact_id = null;
            this.current_index = null;
        },
        getHistoryContact: function (initialize) {
            var vm = this;
            axios.get('/message/getHistoryMessageContact?page=' + (this.current_page + 1).toString())
                .then(function (response) {
                    vm.isHidden = false;
                    vm.current_page = response.data.current_page;
                    vm.last_page = response.data.last_page;
                    for (var i in response.data.data)
                        vm.contacts.push(response.data.data[i]);
                    if (initialize && vm.contacts.length > 0)
                        {vm.loadDialog(0);}
                    else{
                        console.log('123');
                        bus.$emit('loadingHide','123');
                    }
                })
                .catch(function (error) {
                    vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                    vm.$emit('network-error');
                })
        },
        setTop: function (tops) {
            var vm = this;
            for (var i in tops)
            {
                vm.contacts = vm.contacts.filter(t => t.contact_id !== tops[i].contact_id);
                if (tops[i].contact_id === vm.current_contact_id)
                    tops[i].unread_count = 0;
                vm.contacts.unshift(tops[i]);
            }
        },
        getNewContact:  function () {
            var vm = this;
            axios.get('/message/getNewMessageContact')
                .then(function (response) {
                    vm.setTop(response.data);
                })
                .catch(function (error) {
                    vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                    vm.$emit('network-error');
                })
        },
        loadDialog: function (index) {
            var vm = this;
            this.$emit('load-dialog', vm.contacts[index].contact_id);
            var c = vm.contacts[index];
            c.unread_count = 0;
            Vue.set(vm.contacts, index, c);
            vm.current_contact_id = vm.contacts[index].contact_id;
            vm.current_index = index;
        },
        closeContact: function (index) {
            var vm = this;
            //console.log(contact_id);
            //console.log(index);
            axios.get('/message/closeConversation/' + vm.contacts[index].contact_id)
                .then(function (response) {
                    if (vm.contacts.length === 1)   //Hide dialog
                    {
                        vm.clearContact();
                        vm.$emit('load-dialog', -2);
                    }
                    else
                    {
                        if (index === vm.current_index)   //Need autoload
                        {
                            var len = vm.contacts.length;
                            if (parseInt(vm.current_index) + 1 < len)   //Load next contact
                            {
                                vm.contacts.splice(index, 1);
                                vm.current_contact_id = vm.contacts[vm.current_index].contact_id;
                                vm.$emit('load-dialog', vm.current_contact_id);
                            }
                            else   //Load last contact
                            {
                                vm.contacts.splice(index, 1);
                                vm.current_index = parseInt(vm.current_index) - 1;
                                vm.current_contact_id = vm.contacts[vm.current_index].contact_id;
                                vm.$emit('load-dialog', vm.current_contact_id);
                            }
                        }
                        else    //Just close it
                            vm.contacts.splice(index, 1);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                    vm.$emit('network-error');
                })
            event.stopPropagation();
        }
    }
});

// 对话窗格
/*
 contact_id = -1 : 初始化对话窗格
 contact_id = -2 : 隐藏对话窗格
 其他 : 加载历史消息
 */
Vue.component('message-dialog', {
    template: '#message_dialog',
    data: function () {
        return {
            messagesHidden:true,
            messageHidden:true,
            loadingHidden:false,
            messages: [],
            errorMessage: '',
            current_page: 0,
            last_page: null,
            contact_id: null,
            isHidden: true,
            inputMessage: '',
            token: '',
            isLockScroll: false
        }
    },
    mounted: function () {
          const that = this;
        bus.$on('loadingHide',function(user){
          that.loadingHidden = true;
        })
        this.$nextTick(function () {
            this.$on('loadDialogHandler', function (id) {
                var vm = this;
                if (vm.contact_id != id)
                {
                    this.clearMessage(id);
                    this.getHistoryMessage(id);
                }
            });
            this.$on('refreshMessageEvent', function () {
                this.getNewMessage();
            })
        })
    },
    computed: {
        hasMore: function () {
            return this.current_page < this.last_page;
        },
        postData: function () {
            return {
                content: this.inputMessage,
                receiver: this.contact_id,
                _token: this.token
            }
        }
    },
    updated: function () {
        if (!this.isLockScroll)
            this.scrollToButtom();
    },
    methods: {
        getHistoryMessage: function (contact_id) {
            var vm = this;
            if (contact_id === -2){
                vm.loadingHidden = true;
                return;}
            if (contact_id === -1 || this.contact_id === contact_id) {
                contact_id = this.contact_id;
                axios.get('/message/getHistoryMessage?contact_id=' + contact_id.toString() + '&page=' + (this.current_page + 1).toString())
                    .then(function (response) {
                        vm.isLockScroll = true;
                        vm.current_page = response.data.current_page;
                        vm.last_page = response.data.last_page;
                        for (var i in response.data.data)
                        {
                            vm.messages.unshift(response.data.data[i]);
                            if (parseInt(i) + 1 < response.data.data.length &&
                                response.data.data[i].is_read !== response.data.data[parseInt(i) + 1].is_read)
                                vm.messages.unshift({
                                    id: -1,
                                    type: 'history-info'
                                });
                        }
                        vm.loadingHidden = true;
                        vm.isHidden = false;
                    })
                    .catch(function (error) {
                        vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                        vm.$emit('network-error');
                    })
            }
            else {
                axios.get('/message/getHistoryMessage?contact_id=' + contact_id.toString())
                    .then(function (response) {
                        vm.current_page = response.data.current_page;
                        vm.last_page = response.data.last_page;
                        vm.messages = [];
                        for (var i in response.data.data)
                        {
                            vm.messages.unshift(response.data.data[i]);
                            if (parseInt(i) + 1 < response.data.data.length &&
                                response.data.data[i].is_read !== response.data.data[parseInt(i) + 1].is_read)
                                vm.messages.unshift({
                                    id: -1,
                                    type: 'history-info'
                                });
                        }
                        vm.loadingHidden = true;
                        vm.isHidden = false;
                    })
                    .catch(function (error) {
                        vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                        vm.$emit('network-error');
                    })
                this.contact_id = contact_id;
            }
        },
        clearMessage: function(id) {
            this.current_page = 0;
            this.last_page = null;
            this.messages = [];
            this.isLockScroll = false;
            if (id === -2)
            {
                this.contact_id = null;
                this.isHidden = true;
                this.loadingHidden = true;
            }
        },
        sendMessage: function () {
            var vm = this;
            vm.token = $('#token').val();
            vm.content = $('#textArea').val();
            console.log(vm.content);
            if(vm.content!==""){
              vm.messageHidden = false;
            axios.post('/message', this.postData)
                .then(function (response) {
                    vm.messagesHidden = true;
                    vm.messageHidden = true;
                    vm.isLockScroll = false;
                    vm.inputMessage = '';
                    vm.messages.push(response.data.msg);
                    vm.$emit('top-contact', vm.contact_id);
                })
                .catch(function (error) {
                    vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                    vm.$emit('network-error');
                })
                vm.content = '';
              }
              else {
                vm.messagesHidden = false;
              }
        },
        getNewMessage: function () {
            var vm = this;
            if (vm.contact_id)
            {
                axios.get('/message/getNewMessage?contact_id=' + vm.contact_id.toString())
                    .then(function (response) {
                        vm.isLockScroll = false;
                        for (var i in response.data)
                        {
                            vm.messages.push(response.data[i]);
                        }
                        vm.loadingHidden = true;
                        vm.isHidden = false;
                    })
                    .catch(function (error) {
                        vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                        vm.$emit('network-error');
                    })
            }
        },
        scrollToButtom: function () {
            var c = $('#message-container');
            c.scrollTop(c[0].scrollHeight + 1000);
        }
    }
});

// 创建根实例
var Message = new Vue({
    el: '#message',
    data: {
        timer: null
    },
    methods: {
        startLoop: function () {
            $("#vue-error-msg").remove();
            var vm = this;
            vm.loadContact();
            vm.timer = window.setInterval(function() {
                vm.refreshContact();
                vm.refreshMessage();
            }, 5000);
            window.setTimeout(function () {
                vm.$refs.messageDialog.scrollToButtom();
            }, 3000);
        },
        loadContact: function () {
            this.$refs.contactList.$emit('loadContactEvent')
        },
        refreshContact: function () {
            this.$refs.contactList.$emit('refreshContactEvent')
        },
        refreshMessage: function () {
            this.$refs.messageDialog.$emit('refreshMessageEvent')
        },
        loadDialogCallback: function (id) {
            this.$refs.messageDialog.$emit('loadDialogHandler', id)
        },
        topContactCallback: function (contact_id) {
            this.$refs.contactList.$emit('topContactHandler', contact_id)
        },
        stopTimerCallback: function () {
            var vm = this;
            vm.timer = window.clearInterval(vm.timer);
        }
    }
});

$(function () {
    Message.startLoop();
});
