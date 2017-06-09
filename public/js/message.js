/**
 * Created by zhouz on 2017/6/10.
 */

// 联系人列表
Vue.component('contact-list', {
    template: '#contact_list',
    data: function() {
        return {
            contacts: null,
            errorMessage: ''
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
            axios.get('/message/contacts')
                .then(function (response) {
                    vm.contacts = response.data.data;
                })
                .catch(function (error) {
                    vm.errorMessage = error
                })
        }
    }
});

// 创建根实例
var Message = new Vue({
    el: '#message',
    methods: {
        refreshContact: function() {
            this.$refs.child.$emit('getContactEvent')
        }
    }
});