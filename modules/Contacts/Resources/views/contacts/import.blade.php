@extends('layouts.app-client', ['title' => __('CSV Contacts Import')])
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">{{ __('CSV Contacts Import') }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    @include('partials.flash')
                    <form action="{{ route('contacts.import.store') }}" method="POST" enctype="multipart/form-data"
                        class="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-5">
                                    <label class="form-label required">CSV File</label>
                                    <input type="file" class="form-control" name="csv" id="csv" accept=".csv"
                                        required>
                                    <div class="form-text">Headers: phone, name, custom_field_name_1, custom_field_name_2
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Group to Insert Into</label>
                                    <select class="form-select" name="group" id="group">
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-success">{{ __('Import Contact') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
