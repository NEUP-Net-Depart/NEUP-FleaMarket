@include('includes.head')
@include('layout.header')
<h2>{{ $announcement->title }}</h2>
{{ $announcement->content }}
@include('layout.footer')
@include('includes.foot')
