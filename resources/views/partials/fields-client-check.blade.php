@foreach ($fields as $field)
    @if ($field['ftype']=="bool")
        @include('partials.bool-mt-check',$field)
    @endif
@endforeach
