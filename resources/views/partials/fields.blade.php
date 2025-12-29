@foreach ($fields as $field)
    @if ($field['ftype'] == 'input')
        @include('partials.input', $field)
    @endif
    @if ($field['ftype'] == 'multiselect')
        @include('partials.multiselect', $field)
    @endif
    @if ($field['ftype'] == 'select')
        @include('partials.select', $field)
    @endif
    @if ($field['ftype'] == 'info')
        @include('partials.info', $field)
    @endif
    @if ($field['ftype'] == 'image')
        @include('partials.images', [
            'image' => [
                'label' => $field['name'],
                'id' => $field['id'],
                'name' => $field['id'],
                'value' => isset($field['value']) ? $field['value'] : config('global.company_details_image'),
                'style' => isset($field['style']) ? $field['style'] : 'width: 290px; height:200',
            ],
        ])
    @endif
    @if ($field['ftype'] == 'bool')
        @include('partials.bool', $field)
    @endif
    @if ($field['ftype'] == 'textarea')
        @include('partials.textarea', $field)
    @endif
    @if ($field['ftype'] == 'map')
        @include('partials.map', $field)
    @endif
    @if ($field['ftype'] == 'TemplateButton')
        @include('partials.template_interactive_button', $field)
    @endif
    @if ($field['ftype'] == 'TemplateListButton')
        @include('partials.template_interactive_listbutton', $field)
    @endif
    @if ($field['ftype'] == 'InteractiveGroup')
        @include('partials.interactive_groups', $field)
    @endif
    @if ($field['ftype'] == 'HeaderInputSelection')
        @include('partials.header_input_selection', $field)
    @endif
@endforeach
