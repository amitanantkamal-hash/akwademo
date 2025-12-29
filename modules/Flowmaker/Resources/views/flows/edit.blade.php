@extends('general.index', $setup)

@section('cardbody')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            @isset($setup['isupdate'])
                {{ __('Update Record') }}
            @else
                {{ __('Create New Record') }}
            @endisset
        </h3>
    </div>
    
    <div class="card-body">
        <form action="{{ $setup['action'] }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @isset($setup['isupdate'])
                @method('PUT')
            @endisset
            
            @isset($setup['inrow'])
                <div class="row">
            @endisset
            
            @include('partials.fields',['fields'=>$fields])
            
            @isset($setup['inrow'])
                </div>
            @endisset
            
            <div class="form-group row mt-5">
                <div class="col-lg-12 text-right">
                    @if (isset($setup['isupdate']))
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="la la-check"></i> {{ __('Update record') }}
                        </button>  
                    @else
                        <button type="submit" class="btn btn-primary">
                            <i class="la la-save"></i> {{ __('Create') }}
                        </button>  
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
