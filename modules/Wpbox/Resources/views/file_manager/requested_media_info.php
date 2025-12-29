<!-- Brij MOhan Negi Update -->
@if (!empty($media_info['result']))
@php
$items = json_decode($image_data['result'])
@endphp
@foreach ($items as $key => $value)

@php
$detect = detect_file_type($value->extension);
$file_url = get_file_url($value->file);

if (config('settings.use_do_as_storage', false)) {
$file_url = str_replace(
config('settings.use_do_endpoint'),
config('settings.use_do_cdn_endpoint'),
$file_url,
);
}

$detect_icon = detect_file_icon($detect);
$text = $detect_icon['text'];
$icon = $detect_icon['icon'];
@endphp

<div class="offcanvas offcanvas-end p-20" tabindex="-1" id="offcanvasMediaInfo">
    <div class="offcanvas-header">
        <h4 id="offcanvasRightLabel" class="text-primary">{{ __("Media info")}}</h4>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body n-scroll">
        <div class="row mb-3">
            <div class="col">
                @if ($result->is_image)
                <img class="w-100 border b-r-6" src="'{{ $file_url }}'">
                @else
                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-center text-{{ $text }} fs-90">
                            <i class="{{ $icon }}"></i>
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <table class="table m-b-0">
            <tbody>
                <tr>
                    <th class="fw-6">{{__('File name')}}</th>
                    <td>{{ $value->name }}</td>
                </tr>
                <tr>
                    <th class="fw-6">{{__('Upload date')}}</th>
                    <td>{{ datetime_show($value->created)}}</td>
                </tr>
                @if ($value->is_image)
                <tr>
                    <th class="fw-6">{{__('Dimensions')}}</th>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <th class="fw-6">{{__('File size')}}</th>
                    <td>{{ format_bytes($value->size)) }}</td>
                </tr>
                <tr>
                    <th class="fw-6">{{__('File type')}}</th>
                    <td>{{$value->extension) }}</td>
                </tr>
                <tr class="border-none">
                    <th class="fw-6">{{__('Caption')}}</th>
                    <td>
                        <form class="actionForm" action="" data-loading="false" method="POST">
                            <div class="mb-3">
                                <textarea class="form-control form-control-solid" name="caption"></textarea>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-info btn-sm">{{ __('Save')}}</button>
                            </div>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endforeach
@endif