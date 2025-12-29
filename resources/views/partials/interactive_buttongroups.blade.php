{{-- Brij Mohan Negi Update  --}}
<div class="mb-4">
    <div class="card-body p-0">
        @if (isset($fields[6]['buttons']) && !empty($fields[6]['buttons']))
            @php $data = $fields[6]['buttons']; @endphp

            @if (!empty($interactive_button_id))
                @include('partials.select', [
                    'name' => 'Button templates group',
                    'class' => 'col-md-12',
                    'id' => 'btn_template_group_id',
                    'ftype2' => 'yes',
                    'placeholder' => 'Select a group',
                    'value' => '',
                    'dataSelected' => $interactive_button_id ?? '',
                    'data' => $data,
                    'required' => false,
                ])
            @else
                @include('partials.select', [
                    'name' => 'Button templates group',
                    'class' => 'col-md-12',
                    'id' => 'btn_template_group_id',
                    'ftype2' => 'yes',
                    'placeholder' => 'Select a group',
                    'value' => '',
                    'data' => $data,
                    'required' => false,
                ])
            @endif
        @else
            <div class="d-flex align-items-center align-self-center h-100 py-5">
                <div class="w-100">
                    <div class="text-center px-4">
                        <img class="mh-190 mb-4" alt="" src="{{ asset('backend/Assets/img/empty.png') }}">
                        <div>
                            <a class="btn btn-primary btn-sm b-r-30" href="">
                                <i class="fad fa-plus"></i> {{ __('Add button template') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
