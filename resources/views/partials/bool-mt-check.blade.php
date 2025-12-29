@if ($id == 'custom[agent_enable]' || ($id == 'custom[translation_enabled]' || $id == 'custom[enable_voiceflow]'))
    <form id="form-{{ $id }}" method="post" autocomplete="off" enctype="multipart/form-data"
        action="{{ route('admin.owner.updateApps', $company) }}">
        @csrf
        @method('put')
        <input type='hidden' value='false' name="{{ $id }}" id="{{ $id }}hid">
        <input class="form-check-input w-30px h-20px" type="checkbox" value="true" id="{{ $id }}"
            @if (isset($value) && ($value == 'true' || $value == '1')) checked @endif name="{{ $module->slider }}">
        <label class="form-check-label" for="allowmarketing"></label>
    </form>
@endif
