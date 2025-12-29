@extends('layouts.app')

@section('content')
    <div id="app">
        <lead-edit :lead-id="{{ $id }}"></lead-edit>
    </div>
@endsection