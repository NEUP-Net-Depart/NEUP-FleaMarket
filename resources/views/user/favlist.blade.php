@include('includes.head')
<title>先锋市场</title>
<style>
	h5 {
		color: #ffffff;
	}
</style>
</head>
<body>
@include('layout.header')
<div class="page-content">
	<div class="row">
		<h5>收藏商品</h5>
		<table class="table">
			<tr>
				<td>#</td>
				<td>商品名称</td>
				<td>最低价格</td>
				<td>最高价格</td>
			</tr>
			@foreach($goods as $good)
				<tr>
					<td>{{ $good->good_id }}</td>
					<td><a href="/good/{{$good->good_id}}">{{ $good_info[$good->good_id]->good_name }}</a></td>
					<td>{{ $good_info[$good->good_id]->pricemin }}</td>
					<td>{{ $good_info[$good->good_id]->pricemax }}</td>
				</tr>
			@endforeach
		</table>
		<a href="/user/edit_favlist" class="button">编辑收藏夹</a>
	</div>
</div>
@include('layout.footer')
@include('includes.foot')
