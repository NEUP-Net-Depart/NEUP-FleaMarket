/**
 * Created by zhouz on 2017/6/10.
 */

// 联系人列表
Vue.component('contact-list', {
    template: '#contact_list',
    data: function () {
        return {
            contacts: [],
            errorMessage: '',
            current_page: 0,
            last_page: null,
            current_contact_id: null
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
        },
        getHistoryContact: function (initialize) {
            var vm = this;
            axios.get('/message/getHistoryMessageContact?page=' + (this.current_page + 1).toString())
                .then(function (response) {
                    vm.current_page = response.data.current_page;
                    vm.last_page = response.data.last_page;
                    for (var i in response.data.data)
                        vm.contacts.push(response.data.data[i]);
                    if (initialize && vm.contacts.length > 0)
                        vm.loadDialog(0);
                })
                .catch(function (error) {
                    vm.errorMessage = "服务器连接失败，请检查网络QAQ";
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
                })
        },
        loadDialog: function (index) {
            var vm = this;
            this.$emit('load-dialog', vm.contacts[index].contact_id);
            var c = vm.contacts[index];
            c.unread_count = 0;
            Vue.set(vm.contacts, index, c);
            vm.current_contact_id = vm.contacts[index].contact_id;
        }
    }
});

// 对话窗格
Vue.component('message-dialog', {
    template: '#message_dialog',
    data: function () {
        return {
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
        this.$nextTick(function () {
            this.$on('loadDialogHandler', function (id) {
                this.clearMessage();
                this.getHistoryMessage(id);
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
            if (contact_id === 0 || this.contact_id === contact_id) {
                contact_id = this.contact_id;
                axios.get('/message/getHistoryMessage?contact_id=' + contact_id.toString() + '&page=' + (this.current_page + 1).toString())
                    .then(function (response) {
                        vm.isLockScroll = true;
                        vm.current_page = response.data.current_page;
                        vm.last_page = response.data.last_page;
                        for (var i in response.data.data)
                            vm.messages.unshift(response.data.data[i]);
                        vm.isHidden = false;
                    })
                    .catch(function (error) {
                        vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                    })
            }
            else {
                axios.get('/message/getHistoryMessage?contact_id=' + contact_id.toString())
                    .then(function (response) {
                        vm.current_page = response.data.current_page;
                        vm.last_page = response.data.last_page;
                        vm.messages = response.data.data.reverse();
                        vm.isHidden = false;
                    })
                    .catch(function (error) {
                        vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                    })
                this.contact_id = contact_id;
            }
        },
        clearMessage: function() {
            this.current_page = 0;
            this.last_page = null;
            this.messages = [];
            this.isLockScroll = false;
        },
        sendMessage: function () {
            var vm = this;
            vm.token = $('#token').val();
            axios.post('/message', this.postData)
                .then(function (response) {
                    vm.isLockScroll = false;
                    vm.messages.push(response.data.msg);
                    vm.inputMessage = '';
                    vm.$emit('top-contact', vm.contact_id);
                })
                .catch(function (error) {
                    vm.errorMessage = error;
                })
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
                    })
                    .catch(function (error) {
                        vm.errorMessage = "服务器连接失败，请检查网络QAQ";
                    })
            }
        },
        scrollToButtom: function () {
            var c = $('#message-container');
            //console.log(c[0].scrollHeight);
            c.scrollTop(c[0].scrollHeight + 1000);
        }
    }
});

// 创建根实例
var Message = new Vue({
    el: '#message',
    methods: {
        startLoop: function () {
            var vm = this;
            vm.loadContact();
            window.setInterval(function() {
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
        }
    }
});

$(function () {
    Message.startLoop();
});