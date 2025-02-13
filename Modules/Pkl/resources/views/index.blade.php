@extends('pkl::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('pkl.name') !!}</p>
@endsection
