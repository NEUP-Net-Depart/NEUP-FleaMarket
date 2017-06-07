@extends('layout.master')

@section('title', "首页")

@section('content')

    {{ json_encode($tran) }}
    {{ json_encode($seller) }}
    {{ json_encode($buyer) }}

@endsection
