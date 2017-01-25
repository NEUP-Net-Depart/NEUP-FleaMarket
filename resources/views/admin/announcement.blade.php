@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    @foreach($announcements as $announcement)
    {{$announcement->title}}</br>
    {{$announcement->content}}</br>
    {{$announcement->created_at}}<br>
    @endforeach
</div>
@include('layout.footer')
@include('includes.foot')