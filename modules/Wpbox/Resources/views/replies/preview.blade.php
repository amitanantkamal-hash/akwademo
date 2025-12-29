@php
    $component['text'] = '{{ 1 }}';
@endphp
<div class="whatsapp-preview-container"
    style="justify-content: flex-end; text-align: right; background: url('{{ asset('backend/Assets/img/bg.png') }}');">

    {{-- Brij Mohan Negi Update 18rem --}}
    <div class="card" id="previewElement" style="min-width: 100%; text-align: left; border-top-left-radius: 0;">
        <img class="card-img-top" id="card-img-top" style="display:none"
            src="{{ asset('backend/Assets/img/no-image.jpg') }}" alt="Card image cap">
        {{-- Brij Mohan Negi Update <span --}}
        <div class="card-body" style="">
            <h4 class="mb-4 py-0 fs-14" id="headerTextPreview">
                @isset($item->header){{ $item->header }}@endisset
            </h4>
            <p class="card-text text-dark-50 font-weight-normal fs-13 mt-8">
                <span dir="auto" style="overflow-wrap: break-word; text-align: initial; white-space: pre-wrap;"
                    id="bodyTextPreview">@isset($item->text){{ $item->text }}@endisset
                </span>
            </p>

            <span class="text-muted fs-11" id="footerTextPreview">
                @isset($item->footer){{ $item->footer }}@endisset
            </span>
            <!-- <a href="#" class="btn btn-primary">Download invoice</a> -->
        </div>

    </div>
    <div id="button_list_template"></div>
</div>
{{-- document.getElementById("imageid").src="../template/save.png"; --}}
