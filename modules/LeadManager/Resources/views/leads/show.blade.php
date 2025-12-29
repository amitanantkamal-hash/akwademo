@extends('layouts.app')

@section('content')
    <div id="app">
        <lead-detail :lead-id="{{ $id }}"></lead-detail>
    </div>
@endsection