@extends('layout.master')

@section('title', "举报")

@section('content')

	<div class="card">
		<div class="card-header">
			<h3>举报</h3>
		</div>
		<div class="card-body">
			<form action="/sendRepo/{{ $seller_id }}" method="POST">
				{!! csrf_field() !!}
				<div class="row">
					<div class="col-12 col-md-7 offset-md-1">
						<label for="reason">举报理由</label>
						<textarea class="form-control" name="reason" placeholder="详细说明有助于解决问题哦" style="margin-bottom: 5px;height:150px"></textarea>
						<input class="btn btn-danger" type="submit" value="确认举报"/>
					</div>
					<div class="col-12 col-md-3">
						<a href="/user/{{ $seller_id }}">
							<figure class="figure">
								<img src="/avatar/{{ $seller_id }}/150/150"  style="width:150px; height:150px; border-radius:50%; overflow:hidden;margin-bottom:10px" />
								<figcaption class="figure-caption text-center">被举报人</figcaption>
							</figure>
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection
