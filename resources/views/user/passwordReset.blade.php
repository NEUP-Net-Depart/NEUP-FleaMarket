@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    @if($method=="GET")
    <form action="/iforgotit" method="POST">
        Username: <input type="text" name="username"></input>
        Email: <input type="email" name="email"></input>
        {!! csrf_field() !!}
        <input type="submit" class="button"></input>
    </form>
    @else
    {{$sentence}}
    <a href="/iforgotit">Back</a>
    @endif
</div>
@include('layout.footer')
@include('includes.foot')