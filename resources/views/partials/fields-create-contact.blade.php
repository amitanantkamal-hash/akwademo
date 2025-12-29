@foreach ($fields as $field)
    @if ($field['ftype'] == 'input')
        @include('partials.input-reser-12', $field)
    @endif
    @if ($field['ftype'] == 'select')
        @include('partials.select-reminder-12', $field)
    @endif
    @if ($field['ftype'] == 'image')
        @include('partials.images-modal', [
            'image' => [
                'label' => $field['name'],
                'id' => $field['id'],
                'name' => $field['id'],
                'value' => isset($field['value']) ? $field['value'] : config('global.company_details_image'),
                'style' => isset($field['style']) ? $field['style'] : 'width: 290px; height:200',
                'required' => true 
            ],
        ])
    @endif
@endforeach
