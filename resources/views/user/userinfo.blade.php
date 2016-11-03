@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
性别：{{$user->gender}}
</br>
</br>
真实姓名：{{$user->realname}}
</br>
</br>
手机号：{{$user->tel_num}}
</br>
</br>
地址：{{$user->address}}
</br>
</br>
<a href='/user/{{$user->id}}/edit'>Edit</a><br/>
<a href='/logout'>Log Out</a><br/>
<a href='/good/check'>Check</a><br/>
</div>
@include('layout.footer')
@include('includes.foot')