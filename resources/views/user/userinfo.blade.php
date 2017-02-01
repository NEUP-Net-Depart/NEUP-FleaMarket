@include('includes.head')
<title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <div>性别:{{$user->gender}}</div>
    <div>真实姓名:{{$user->realname}}</div>
    <div>手机号:{{$user->tel_num}}</div>
    <div>地址:{{$user->address}}</div>
    <a class="button" href='/user/{{$user->id}}/edit'>编辑</a><br/>
    <a class="button" href='/good/my'>MyGood</a><br/>
    <a class="button" href='/good/check'>Check</a><br/>
    <a class="button" href='/logout'>登出</a><br/>
</div>
@include('layout.footer')
@include('includes.foot')
