@extends('layouts.app', ['title' => __('Edit Partner')])
@section('content')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <div class="header pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <h1 class="mb-3 mt--3"><i class="ni ni-circle-08 text-red"></i> {{ __('Edit Partner') }}</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <form action="{{ route('partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- User Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Partner Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="user_id">User</label>
                            <select class="form-control select2" id="user_id" name="user_id" required disabled>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $partner->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $partner->name }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone">WhatsApp Number</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $partner->phone }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Business Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $partner->email }}" required>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Business Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Business Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="business_name">Business Name</label>
                            <input type="text" class="form-control" id="business_name" name="business_name"
                                value="{{ $partner->business_name }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="website">Website</label>
                            <input type="url" class="form-control" id="website" name="website"
                                value="{{ $partner->website }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="gst_number">GST Number</label>
                            <input type="text" class="form-control" id="gst_number" name="gst_number"
                                value="{{ $partner->gst_number }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pan_number">PAN Number</label>
                            <input type="text" class="form-control" id="pan_number" name="pan_number"
                                value="{{ $partner->pan_number }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="billing_address">Billing Address</label>
                        <textarea class="form-control" id="billing_address" name="billing_address" required>{{ $partner->billing_address }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="logo">Company Logo</label>
                        <input type="file" class="form-control-file" id="logo" name="logo"
                            accept="image/png, image/jpeg">
                        @if ($partner->logo)
                            <img src="{{ asset($partner->logo) }}" alt="Logo" width="100" class="mt-2">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Other Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Other Settings</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="allowed_customer_creation">Allowed Customer Creation</label>
                            <input type="checkbox" id="allowed_customer_creation" name="allowed_customer_creation"
                                value="1" {{ $partner->allowed_customer_creation ? 'checked' : '' }}>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="is_active">Active</label>
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ $partner->is_active ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success mb-4">Update</button>
        </form>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user_id').select2();

            $('#user_id').on('change', function() {
                var userId = $(this).val();
                if (userId) {
                    $.ajax({
                        url: '/partners/' + userId + '/info',
                        method: 'GET',
                        success: function(data) {
                            $('#name').val(data.name);
                            $('#phone').val(data.phone);
                            $('#email').val(data.email);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $('#user_id').on('change', function() {
            var userId = $(this).val();
            console.log("Selected User ID:", userId);

            if (userId) {
                $.ajax({
                    url: '/partners/' + userId + '/info',
                    method: 'GET',
                    success: function(data) {
                       // console.log("Fetched Data:", data); 
                        if (data) {
                            $('#name').val(data.name);
                            $('#phone').val(data.phone);
                            $('#email').val(data.email);
                        }
                    },
                    error: function() {
                        alert('Error fetching user data.');
                    }
                });
            }
        });
    </script> --}}
@endsection
