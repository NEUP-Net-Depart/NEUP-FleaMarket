@include('includes.head')
    <title>出错辣！！！ - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    @if(count($errors) > 0)
        <label>
            <span class="form-error is-visible">{!! $errors->first() !!}</span>
        </label>
    @endif
</div>
@include('layout.footer')
@include('includes.foot')
