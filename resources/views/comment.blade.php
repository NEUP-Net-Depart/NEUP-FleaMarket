@extends('layout.master')

@section('title', "评价")

@section('content')

<div class="row">
	<form action="/sendComment/{{ $trans_id }}" method="POST">
		{!! csrf_field() !!}
		<label class="right-inline">评价:</label>
		<textarea name="comment"></textarea>
		<input type="submit" class="button" value="确认">
	</form>
</div>

@endsection
