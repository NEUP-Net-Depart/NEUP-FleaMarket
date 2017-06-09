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
            last_page: null
        }
    },
    computed: {
        hasMore: function () {
            return this.current_page < this.last_page;
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.$on('getContactEvent', function () {
                this.getContact();
            })
        })
    },
    methods: {
        getContact: function () {
            var vm = this;
            axios.get('/message/contacts?page=' + (this.current_page + 1).toString())
                .then(function (response) {
                    vm.current_page = response.data.current_page;
                    vm.last_page = response.data.last_page;
                    for (var i in response.data.data)
                        vm.contacts.push(response.data.data[i]);
                })
                .catch(function (error) {
                    vm.errorMessage = error;
                })
        },
        loadDialog: function (id) {
            this.$emit('load-dialog', id);
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
            isHidden: true
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.$on('loadDialogHandler', function (id) {
                this.current_page = 0;
                this.last_page = null;
                this.getMessage(id);
            })
        })
    },
    computed: {
        hasMore: function () {
            return this.current_page < this.last_page;
        }
    },
    methods: {
        getMessage: function (contact_id) {
            var vm = this;
            if (contact_id === 0 || this.contact_id === contact_id) {
                contact_id = this.contact_id;
                axios.get('/message/getMessage?contact_id=' + contact_id.toString() + '&page=' + (this.current_page + 1).toString())
                    .then(function (response) {
                        vm.current_page = response.data.current_page;
                        vm.last_page = response.data.last_page;
                        for (var i in response.data.data)
                            vm.messages.unshift(response.data.data[i]);
                        vm.isHidden = false;
                    })
                    .catch(function (error) {
                        vm.errorMessage = error;
                    })
            }
            else {
                axios.get('/message/getMessage?contact_id=' + contact_id.toString())
                    .then(function (response) {
                        vm.current_page = response.data.current_page;
                        vm.last_page = response.data.last_page;
                        vm.messages = response.data.data.reverse();
                        vm.isHidden = false;
                    })
                    .catch(function (error) {
                        vm.errorMessage = error;
                    })
                this.contact_id = contact_id;
            }
        }
    }
});

// 创建根实例
var Message = new Vue({
    el: '#message',
    methods: {
        refreshContact: function () {
            this.$refs.contactList.$emit('getContactEvent')
        },
        loadDialogCallback: function (id) {
            this.$refs.messageDialog.$emit('loadDialogHandler', id)
        }
    }
});