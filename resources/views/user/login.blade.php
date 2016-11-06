@include('includes.head')
    <title>登录 - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <div class="row">
        <div class="small-8 small-centered medium-4 medium-centered columns">
    		@if (count($errors) > 0)
        		<label>
		            <span class="form-error is-visible">{!! $errors->first() !!}</span>
		        </label>
    		@endif
    		<form action="/login" method="POST" data-abide novalidate>
		        <input type="text" name="username" placeholder="用户名">
		        <input type="password" id="password" name="password" placeholder="密码">
		        {!! csrf_field() !!}
                <input type="submit" class="button" value="登录">
		    </form>
		</div>
	</div>
</div>
@include('layout.footer')
@include('includes.foot')
