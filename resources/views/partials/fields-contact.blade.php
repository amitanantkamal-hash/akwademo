
@foreach ($fields as $field)
    @if ($field['ftype'] == 'input')
        @include('partials.input-reser-6', $field)
    @endif
    @if ($field['ftype'] == 'select')
        @include('partials.select-4', $field)
    @endif
@endforeach
