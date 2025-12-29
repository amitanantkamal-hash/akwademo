@extends('layouts.app-client')

@section('title')
    {{ __('Create new template') }}
    <x-button-links />
@endsection

@section('css')

<style>
    .step-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid #d6dce0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #6c757d;
        background: #ffffff;
    }
    .step-item { 
        cursor: pointer; 
    }
    .step-label { 
        font-size: 13px; 
        color: #6c757d; 
    }
    .active-step .step-circle { 
        border-color: #00c292; 
        color: #00c292; 
        background: #eafff4; 
    }
    .step-circle.completed { 
        border-color: #00c292; 
        color: #00c292; 
    }
    .alert-info i { 
        color: #0ea5a4; 
    }
    .wh-message {
        background: #ffffff;
        border-radius: 12px;
        padding: 14px 16px 28px 16px;
        width: 100%;
        box-shadow: 0px 1px 2px rgba(0,0,0,0.15);
        position: relative;
    }

    .wh-header { font-weight: 600; margin-bottom: 8px; }
    .wh-body { font-size: 14px; white-space: pre-wrap; margin-bottom: 10px; }
    .wh-footer { font-size: 13px; color: #666; margin-top: 8px; }

    .wh-time {
        position: absolute;
        bottom: 8px;
        right: 14px;
        font-size: 11px;
        color: #777;
    }

    .wh-divider {
        border-top: 1px solid #eee;
        margin: 10px 0;
    }

    .wh-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 13px;
        color: #283d3b;
        padding: 6px 0;
        cursor: pointer;
    }

    .section-box {
        border: 1px solid #d1e7dd;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 10px;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        color: #1b4332;
    }

    .section-desc {
        font-size: 10px;
        color: #555;
    }

    .section-icon {
        width: 25px;
        height: 25px;
        background: #d1fae5;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
    }
</style>


<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel='stylesheet' type='text/css' href="{{ asset('backend/Assets/File_manager/css/file_manager.css') }}">
    
@endsection
@section('content')
    <form method="POST" action="{{ route('campaigns.store') }}" id="template_creator" enctype="multipart/form-data">
        @include('wpbox::templates.partials.form')
    </form>

    @include('wpbox::templates.wizard_script')
@endsection
@section('topjs')
@endsection