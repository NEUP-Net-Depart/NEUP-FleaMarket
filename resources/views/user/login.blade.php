@include('includes.head')
    <title>登录 - 先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    <div class="row">
        <div class="small-4 small-centered columns">
    		@if (count($errors) > 0)
        		<label>
		            <span class="form-error is-visible">{!! $errors->first() !!}</span>
		        </label>
    		@endif
    		<form action="/login" method="POST" data-abide novalidate>
		        <input type="text" name="username" placeholder="用户名">
		        <input type="password" id="password" name="password" placeholder="密码">
		        {!! csrf_field() !!}
                <div class="row"><div class="small-3 small-centered columns"><input type="submit" class="button" value="登录"></div></div>
		    </form>
		</div>
	</div>
</div>
@include('layout.footer')
@include('includes.foot')