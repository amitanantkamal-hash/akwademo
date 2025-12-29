<div class="card-body"
    style="justify-content: flex-end; text-align: right; background: url('{{ asset('uploads/default/dotflo/bg.png') }}');">

    @if ($selectedTemplate)

        <div class="card" id="previewElement" style="min-width: 18rem; text-align: left; border-radius:10;">
            @foreach ($selectedTemplateComponents as $component)
                @if ($component['type'] == 'HEADER' && $component['format'] == 'DOCUMENT')
                    <img class="card-img-top" style="" src="{{ asset('uploads/default/dotflo/pdf.png') }}"
                        alt="Card image cap">
                    <input type="hidden" name="pdfPreview" :value="pdfPreview">
                @endif
                @if ($component['type'] == 'HEADER' && $component['format'] == 'IMAGE')
                    <img :src="imagePreview || '{{ $component['example']['header_handle'][0] }}'" 
                        class="card-img-top" style="">
                    <input type="hidden" name="imagePreview" :value="imagePreview">
                @endif
                @if ($component['type'] == 'HEADER' && $component['format'] == 'VIDEO')
                    <video width="100%" height="200" controls>
                        <source :src="videoPreview || '{{ $component['example']['header_handle'][0] }}'" type="video/mp4">
                    </video>
                    <input type="hidden" name="videoPreview" :value="videoPreview">
                @endif
            @endforeach
            <div class="card-body" style="">
                @foreach ($selectedTemplateComponents as $component)
                    @if ($component['type'] == 'HEADER' && $component['format'] == 'TEXT')
                        <h4 class="card-title mb-2">{{ str_replace('{{', '{{header_', $component['text']) }}</h4>
                    @elseif ($component['type'] == 'FOOTER')
                        <span class="text-muted text-xs">{{ $component['text'] }}</span>
                    @endif
                @if ($component['type'] == 'BODY')
                <p class="card-text text-dark-50 font-weight-normal fs-13"> 
                    <span class="" dir="auto" style="overflow-wrap: break-word; text-align: initial; white-space: pre-line;">
                        @php
                            // Process placeholders
                            $formattedText = str_replace('{{', '{{body_', $component['text']);
                            
                            // Apply precise formatting
                            $formattedText = preg_replace('/\*([^*\n]+?)\*/', '<strong>$1</strong>', $formattedText);
                            $formattedText = preg_replace('/_([^_\n]+?)_/', '<em>$1</em>', $formattedText);
                        @endphp
                        {!! $formattedText !!}
                    </span>
                </p>
                @endif
                @endforeach
                <!-- <a href="#" class="btn btn-info">Download invoice</a> -->
            </div>

        </div>
        @foreach ($selectedTemplateComponents as $component)
            @if ($component['type'] == 'BUTTONS')
                <div class="d-flex flex-column gap-3 mt-4">
                    @foreach ($component['buttons'] as $button)
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div
                                    class="d-flex align-items-center justify-content-center w-100 py-3 px-4 
                                 @if ($button['type'] == 'URL') bg-light-primary @else bg-light-info @endif
                                 rounded">
                                    @if ($button['type'] == 'URL')
                                        <i class="fas fa-external-link-alt fs-5 me-3"></i>
                                    @else
                                        <i class="fas fa-copy fs-5 me-3"></i>
                                    @endif
                                    <span class="fw-semibold fs-6">
                                        {{ $button['text'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    @endif



</div>
