@extends('layouts.app-client')

@section('content')


@push('styles')
<link rel="stylesheet" href="{{ asset('location/leaflet.css') }}" crossorigin="" />
<link rel="stylesheet" href="{{ asset('location/fullscreen.css') }}" />
@endpush
<x-slot:title>
  {{ __('create_flow') }}
</x-slot:title>
<div class="mx-auto h-full">
  <div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto bg-white dark:bg-gray-800">
      <div id="bot-flow-builder" data-flow-id="{{ $flow->id }}" class="w-full">
        <bot-flow-builder></bot-flow-builder>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="{{ asset('location/leaflet.js') }}" crossorigin=""></script>
<script src="{{ asset('location/fullscreen.js') }}"></script>
<script>
    window.personalAssistant = @json($personalAssistant);
    window.isAiAssistantModuleEnabled = @json($isAiAssistantModuleEnabled);
    window.metaAllowedExtensions = @json(get_meta_allowed_extension());
</script>
@endpush

@endsection