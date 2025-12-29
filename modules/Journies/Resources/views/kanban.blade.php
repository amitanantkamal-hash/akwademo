@extends('layouts.app-client', ['title' => __('Journey')])

@section('js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css">
    <style>
        #myKanban {
            overflow-x: auto;
            padding: 20px 0;
        }

        .kanban-title-board {
            color: #fff;
            font-weight: 600;
        }

        .success,
        .info,
        .warning,
        .error {
            background: var(--bs-gray-600);
            border-radius: 6px;
        }

        .custom-button {
            background-color: var(--bs-success);
            border: none;
            color: white;
            padding: 7px 15px;
            margin: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl">
        <div class="card card-flush shadow-sm">
            <!-- Card Header -->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5 flex-wrap justify-content-between">
                <!-- Title -->
                <div class="card-title d-flex align-items-center">
                    <i class="ki-duotone ki-clipboard fs-2x me-2 text-primary"></i>
                    <h3 class="mb-0">{{ $journey->name }}</h3>
                </div>

                <!-- Desktop Toolbar Buttons -->
                <div class="card-toolbar d-none d-md-flex">
                    <a href="{{ route('journies.index') }}" class="btn btn-light-primary btn-sm me-2">
                        <i class="ki-duotone ki-arrow-left fs-4 me-1"></i>{{ __('Back') }}
                    </a>

                    <a href="{{ route('stages.create', $journey) }}" class="btn btn-success btn-sm me-2">
                        <i class="ki-duotone ki-plus fs-4 me-1"></i>{{ __('Add Stage') }}
                    </a>

                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addContactModal">
                        <i class="ki-duotone ki-user-plus fs-4 me-1"></i>{{ __('Add Contact') }}
                    </a>
                </div>

                <!-- Mobile Menu Dropdown -->
                <div class="card-toolbar d-md-none">
                    <div class="dropdown">
                        <button class="btn btn-icon btn-sm btn-light-primary" type="button" id="mobileToolbarDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ki-duotone ki-category">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileToolbarDropdown">
                            <li>
                                <a href="{{ route('journies.index') }}" class="dropdown-item">
                                    <i class="ki-duotone ki-arrow-left fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> {{ __('Back') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('stages.create', $journey) }}" class="dropdown-item">
                                    <i class="ki-duotone ki-plus fs-4 me-1"></i>{{ __('Add Stage') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#addContactModal">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i> {{ __('Add Contact') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                @include('partials.flash')

                <!-- Add Contact Modal -->
                <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('journey.add-contact', $journey) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addContactModalLabel">{{ __('Add Contact to Journey') }}
                                    </h5>
                                    <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal">
                                        <i class="ki-duotone ki-cross fs-2"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="contact_id" class="form-label">{{ __('Select Contact') }}</label>
                                        <select name="contact_id" id="contact_id" class="form-select" required>
                                            <option value="">{{ __('Choose a contact') }}</option>
                                            @foreach ($contacts as $contact)
                                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-info">{{ __('Add Contact') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Kanban Board -->
                <div id="myKanban"></div>
            </div>
        </div>
    </div>

    @include('journies::scripts')
@endsection