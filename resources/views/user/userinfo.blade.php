@include('includes.head')
<title>先锋市场</title>
<style>
    label {
        text-align: right;
        font-size: medium;
        color: #ffffff;
        min-width: 80px;
        max-width: 100px;
        float: right;
    }
    p {
        color: #ffffff;
    }
</style>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <div class="large-8 large-offset-2 small-10 small-offset-1 columns">
        <div class="row">
            <div class="small-2 columns">
                <label class="right inline">性别:</label>
            </div>
            <div class="small-10 columns">
                <p>{{$user->gender}}</p>
            </div>
        </div>
        <div class="row">
            <div class="small-2 columns">
                <label class="right inline">真实姓名：</label>
            </div>
            <div class="small-10 columns">
                <p>{{$user->realname}}</p>
            </div>
        </div>
        <div class="row">
            <div class="small-2 columns">
                <label class="right inline">手机号：</label>
            </div>
            <div class="small-10 columns">
                <p>{{$user->tel_num}}</p>
            </div>
        </div>
        <div class="row">
            <div class="small-2 columns">
                <label class="right inline">地址：</label>
            </div>
            <div class="small-10 columns">
                <p>{{$user->address}}</p>
            </div>
        </div>
        <div class="row">
            <a class="button" href='/user/{{$user->id}}/edit'>编辑</a><br/>
        </div>
        <div class="row">
            <a class="button" href='/logout'>登出</a><br/>
        </div>
        <div class="row">
            <a class="button" href='/good/check'>Check</a><br/>
        </div>
    </div>
</div>
@include('layout.footer')
@include('includes.foot')