@extends('layout.master')

@section('title', "评价")

@section('content')


    <form action="/sendComment/{{ $trans_id }}" method="POST">
        {!! csrf_field() !!}
        <div class="row form-group">
            <div class="col col-xs-12 col-sm-8 col-md-6">
                <label class="right-inline">评价:</label>
                <textarea name="comment" class="form-control"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col col-xs-12">
                <input type="submit" class="btn btn-primary" value="确认">
            </div>
        </div>
    </form>


@endsection
