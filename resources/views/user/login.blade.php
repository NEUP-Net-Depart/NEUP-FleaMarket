@include('includes.head')
    <title>登陆</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <label>
                <span class="form-error is-visible">{{ $error }}</span>
            </label>
        @endforeach
    @endif
<div class="show">
	<form action="/login" method="POST">
    {{ csrf_field() }}
	<div class="show1">
		<input type="text" name="username" placeholder="Username" style="height:60%;font-size:22px;font-family: 'Microsoft YaHei'";>
	</div>
	<div class="show2">
		<input type="password" name="password" placeholder="Password" style="height:60%;font-size:22px;font-family: 'Microsoft YaHei'";>
	</div>
	<div class="show3">
		<div class="show3a">
			<label>
				<input type="checkbox">
				Remember me
			</label>
			
		</div>
		<div class="show3b">
			<a href='/iforgotit' target="_blank" style="font-weight:bold;font-size:15px;color:black;font-family: 'Microsoft YaHei';text-decoration:underline";>Forgot your password?</a>
		</div>
	</div>
	<div class="show4">
		<input type="submit" name="submit" value="LOGIN" style="width:100%;background-color:#CCCCFF;font-weight:bold;font-size:22px;height:60%;font-family: 'Microsoft YaHei'";>
	</div>
	</form>
</div>
@include('layout.footer')
@include('includes.foot')
