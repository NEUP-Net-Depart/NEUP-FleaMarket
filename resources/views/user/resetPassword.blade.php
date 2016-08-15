@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    @if($method=="GET")
    <form action="/passwordReset/{{$token}}" method="POST">
        Password: <input type="password" name="password"></input>
        Again: <input type="password"></input>
        {!! csrf_field() !!}
        <input type="submit" class="button"></input>
    </form>
    @else
    {{$sentence}}
    @endif
</div>
@include('layout.footer')
@include('includes.foot')