@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
<ul>
@foreach($cats as $cat)
    <li>{{ $cat->cat_name  }}</li>
@endforeach
</ul>
<br/>
@foreach($goods as $good)
    <div class="cat{{ $good->cat_id }}"><a href="/good/{{ $good->id }}">{{ $good->good_name }}</a></div>
@endforeach
<br/>
<br/>
<br/>
@if($user_id != NULL)
    <a href='/good/add'>Add</a>
@endif
</div>
@include('layout.footer')
@include('includes.foot')