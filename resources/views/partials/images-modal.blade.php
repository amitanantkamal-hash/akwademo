<div class="form-group text-center d-flex justify-content-center flex-column py-4">
    
    {{-- @isset($image['help'])
        <br /> <span class="small">{{ $image['help'] }}</span>
    @endisset --}}
    @php
        // Asignar la imagen de avatar o una imagen por defecto
        $avatar = asset('Metronic/assets/media/avatars/blank.png');
        
    @endphp
    <style>
        .image-input-placeholder {
            background-image: url('{{ $avatar }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ $avatar }}');
        }
    </style>
    <div>
    <div class="image-input image-input-outline" data-kt-image-input="true"
        style="background-image: url('{{ $avatar }}')">
        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ $avatar }}')">
        </div>
        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
            data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
            <input type="file" name="{{ $image['name'] }}" accept=".png, .jpg, .jpeg"
                onchange="previewImage(event)"/> 
                {{-- @isset($image['required']) {{ 'required' }} @endisset --}}
            <input type="hidden" name="image_remove" id='image_remove' />
        </label>
        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel image"
            onclick="cancelImage()">
            <i class="ki-outline ki-cross fs-3"></i>
        </span>
        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
            data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove image"
            onclick="removeImage()">
            <i class="ki-outline ki-cross fs-3"></i>
        </span>
    </div>
</div>
    <label class="fs-6 form-label fw-bold text-gray-900 mt-4" for="input-name">Select a {{ $image['label'] }}</label>
    @if ($errors->has($image['name']))
        <span class="text-danger"><strong>{{ $errors->first($image['name']) }}</strong></span>
    @endif
</div>
