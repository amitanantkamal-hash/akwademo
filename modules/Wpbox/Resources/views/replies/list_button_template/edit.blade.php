@extends('general.index', $setup)
@section('cardbody')
    <form action="{{ $setup['action'] }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($setup['isupdate'])
            @method('PUT')
        @endisset
        @isset($setup['inrow'])
            <div class="row">
            @endisset
            @include('partials.fields', ['fiedls' => $fields])
            @isset($setup['inrow'])
            </div>
        @endisset
        @if (isset($setup['isupdate']))
            <button type="submit" class="btn btn-info ml-3 mt-2">{{ __('Update') }}</button>
        @else
            <button type="submit" class="btn btn-info ml-3 mt-2">{{ __('Submit') }}</button>
        @endif
    </form>
@endsection
