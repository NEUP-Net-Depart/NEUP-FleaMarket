@extends('layout.master')

@section('title', "举报")

@section('content')

<div class="row">
	<form action="/sendRepo/{{ $seller_id }}" method="POST">
	{!! csrf_field() !!}
		<label class="right inline">举报理由：</label>
		<textarea name="reason"></textarea>
		<input class="button" type="submit" name="submit1"
			   value="确认举报"/>
	</form>
</div>

@endsection
