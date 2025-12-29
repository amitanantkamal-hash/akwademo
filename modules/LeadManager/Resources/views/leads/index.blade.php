@extends('layouts.app-client')

@section('content')
    <div id="app">
        <lead-index></lead-index>
    </div>
@endsection

@vite(['resources/css/app.css', 'resources/js/app.js'])