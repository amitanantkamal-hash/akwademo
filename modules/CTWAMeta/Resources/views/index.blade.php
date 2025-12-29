@extends('c-t-w-a-meta::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('c-t-w-a-meta.name') !!}
    </p>
@endsection
