Vue.component('tag', {
    template: '#tag',
    props: [
        'good_cat_id'
    ],
    data: function () {
        return {
            tags: [],
            newTag: {
                tag_name: "",
                good_cat_id: this.good_cat_id,
                _token: this.token
            },
            checkedTag: {
                tags: [],
                tag_name: "",
                good_cat_id: this.good_cat_id,
                _method: "",
                _token: this.token
            },
            token: ""
        }
    },
    methods: {
        loadTag: function () {
            var vm = this;
            axios.get('/tag/get' + "?good_cat_id=" + vm.good_cat_id)
                .then(function (response) {
                    vm.tags = response.data.tags;
                })
        },
        addTag: function () {
            var vm = this;
            vm.token = $('#token').val();
            axios.post('/tag/add', vm.newTag)
                .then(function (response) {
                    if(response.data.result) {
                        vm.tags.push(response.data.data);
                        vm.newTag.tag_name = ""
                    } else {
                        alert("操作失败！")
                    }
                })
                .catch(function () {
                    alert("出错啦！")
                })
        },
        editTag: function () {
            var vm = this;
            vm.token = $('#token').val();
            vm.checkedTag._method = "PUT";
            axios.post('/tag/edit', vm.checkedTag)
                .then(function (response) {
                    if(response.data.result) {
                        vm.loadTag();
                        vm.checkedTag.tags = [];
                        vm.checkedTag.tag_name = ""
                    } else {
                        alert("操作失败！")
                    }
                })
                .catch(function () {
                    alert("出错啦！")
                });
        }
    },
    mounted: function () {
        this.loadTag()
    }
});

var app = new Vue({
    el: '#classify',
    data: {
        cats: [],
        newCat: {
            cat_name: "",
            _token: this.token
        },
        checkedCat: {
            cats: [],
            cat_name: "",
            _method: "",
            _token: this.token
        },
        token: ""
    },
    methods: {
        loadCat: function () {
            var vm = this;
            axios.get('/cat/get')
                .then(function (response) {
                    vm.cats = response.data.cats;
                    vm.checkedCat.cats = []
                })
        },
        addCat: function () {
            var vm = this;
            vm.token = $('#token').val();
            axios.post('/cat/add', vm.newCat)
                .then(function (response) {
                    if(response.data.result) {
                        vm.cats.push(response.data.data);
                        vm.newCat.cat_name = ""
                    } else {
                        alert("操作失败！")
                    }
                })
                .catch(function () {
                    alert("出错啦！")
                })
        },
        editCat: function () {
            var vm = this;
            vm.token = $('#token').val();
            vm.checkedCat._method = "PUT";
            axios.post('/cat/edit', vm.checkedCat)
                .then(function (response) {
                    if(response.data.result) {
                        vm.loadCat();
                        vm.checkedCat.cats = [];
                        vm.checkedCat.cat_name = ""
                    } else {
                        alert("操作失败！")
                    }
                })
                .catch(function () {
                    alert("出错啦！")
                });
        }
    },
    created: function () {
        this.loadCat();
    }
})

