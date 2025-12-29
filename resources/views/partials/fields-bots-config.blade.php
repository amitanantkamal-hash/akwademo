@foreach ($fields as $field)
    @if ($field['ftype'] == 'input')
        @include('partials.input-bots-config', $field)
    @endif
    @if ($field['ftype'] == 'bool')
        @include('partials.bool-bots-config', $field)
    @endif
@endforeach

