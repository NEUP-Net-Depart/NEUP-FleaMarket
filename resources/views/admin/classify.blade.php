@extends('admin.master')

@section('asset')
    <style>
        .input-default-len {
            width: 300px;
        }

        .row {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('tab-list')
    <li class="nav-item"><a class="nav-link" href="/admin">公告管理</a></li>
    <li class="nav-item"><a class="nav-link active" href="/admin/classify">分类管理</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/report">查看举报记录</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/userlist">查看所有用户</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/translist">交易列表</a></li>
@endsection

@section('tab-classify')
    <div class="tab-pane active" id="classify" role="tabpanel">
        <template v-for="cat in cats">
            <div class="container form-control">
                <div class="row">
                    <div class="col">
                        <h3><input type="checkbox" name="tag" v-bind:value="cat.id" v-model="checkedCat.cats">@{{ cat.cat_name }}</h3>
                    </div>
                </div>
                <hr>
                <tag ref="tag" v-bind:good_cat_id="cat.id"></tag>
            </div>
            <p></p>
        </template>

        <div class="container form-control">

            <div class="form-inline">
                <div class="mx-sm-1">
                    <input class="form-control" placeholder="新分类名" v-model="newCat.cat_name">
                </div>
                <div class="mx-sm-3">
                    <button class="btn btn-primary" v-on:click="addCat">新建</button>
                </div>
                <div class="mx-sm-1">
                    <input class="form-control" v-bind:placeholder="checkedCat.cats.length <= 1 ? '重命名' : '合并并更名'" v-model="checkedCat.cat_name">
                </div>
                <div class="mx-sm-3">
                    <button class="btn btn-primary" v-on:click="editCat">@{{ checkedCat.cats.length <= 1 ? '修改' : '合并分类' }}</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/x-template" id="tag">
        <div>
            <div class="row">
                <div class="col">
                    <template v-for="tag in tags">
                        <input type="checkbox" name="tag" v-bind:value="tag.id" v-model="checkedTag.tags">@{{ tag.tag_name }}
                    </template>
                </div>
            </div>
            <hr>

            <div class="form-inline">
                <div class="mx-sm-1">
                    <input class="form-control" placeholder="新 Tag 名" v-model="newTag.tag_name">
                </div>
                <div class="mx-sm-3">
                    <button class="btn btn-primary" v-on:click="addTag">新建</button>
                </div>
                <div class="mx-sm-1">
                    <input class="form-control" v-bind:placeholder="checkedTag.tags.length <= 1 ? '重命名' : '合并并更名'" v-model="checkedTag.tag_name">
                </div>
                <div class="mx-sm-3">
                    <button class="btn btn-primary" v-on:click="editTag">@{{ checkedTag.tags.length <= 1 ? '修改' : '合并 Tag' }}</button>
                </div>
            </div>
        </div>
    </script>
    <script src="/js/axios.min.js"></script>
    <script src="https://unpkg.com/vue@2.3.4/dist/vue.js"></script>
    <script src="/js/admin/classify.js"></script>
    <input id="token" type="hidden" value="{{ csrf_token() }}"/>
@endsection