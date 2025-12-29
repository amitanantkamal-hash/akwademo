@extends('client.app', ['title' => __($title)])

@section('content')
    @yield('customheading')

    <div class="col-12">
        @include('partials.flash-client')
    </div>

    <div class="container-xxl card card-flush">
        <!-- Card Header -->
        <div class="card-header align-items-center py-5 gap-4 flex-wrap flex-md-nowrap">
            <!-- Title Block -->
            <div class="card-title flex-grow-1">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
                    <h3 class="mb-0 d-flex align-items-center text-dark fw-bold fs-2">
                        <i class="ki-outline ki-element-11 fs-1 me-2 text-gray-700"></i> {{ __($title) }}
                    </h3>
                </div>
            </div>

            <!-- Search + Action -->
            <div class="card-toolbar d-flex align-items-center justify-content-end flex-wrap gap-2 w-100">
                <!-- Search Bar (always visible) -->
                <div class="d-flex align-items-center position-relative me-2">
                    <i class="ki-outline ki-magnifier fs-2 position-absolute ms-4"></i>
                    <input type="text" id="searchInput" class="form-control form-control-solid ps-12"
                        placeholder="Search..." />
                </div>

                <!-- Action Button - Desktop -->
                @isset($action_link)
                    <div class="d-none d-md-block">
                        <a href="{{ $action_link }}" class="btn btn-sm btn-light-primary">
                            {!! $action_icon !!} {{ __($action_name) }}
                        </a>
                    </div>
                @endisset

                <!-- Mobile: Dropdown Button with Actions -->
                @isset($action_link)
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-sm btn-icon btn-light-primary" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="ki-duotone ki-menu"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ $action_link }}" class="dropdown-item">
                                    {!! $action_icon !!} {{ __($action_name) }}
                                </a>
                            </li>
                        </ul>
                    </div>
                @endisset
            </div>

        </div>

        <!-- Filters (if any) -->
        @isset($usefilter)
            @include('general.filters')
        @endisset

        @yield('contenttop')

        <!-- Card Body -->
        @if (isset($iscontent))
            <div class="card-body">
                @yield('cardbody')
            </div>
        @else
            <div class="card-body pt-0">
                @if (count($items))
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    @if (isset($custom_table))
                                        @yield('thead')
                                    @else
                                        @if (isset($fields))
                                            @foreach ($fields as $field)
                                                <th>{{ __($field['name']) }}</th>
                                            @endforeach
                                            <th>{{ __('crud.actions') }}</th>
                                        @else
                                            @yield('thead')
                                        @endif
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @yield('tbody')
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Pagination or No Items -->
            <div class="card-footer py-4">
                @if (count($items))
                    @unless (isset($hidePaging) && $hidePaging)
                        <div class="d-flex justify-content-end">
                            {{ $items->links() }}
                        </div>
                    @endunless
                @else
                    <h4 class="text-muted">{{ __('crud.no_items', ['items' => $item_names]) }}</h4>
                @endif
            </div>
        @endif
    </div>

    <!-- Modal -->
    @isset($setup_create)
        @if ($view == 'qr')
            <div class="modal fade" tabindex="-1" id="kt_modal_create">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header border-0">
                            <h2 class="modal-title">{{ __($action_name) }}</h2>
                            <button type="button" class="btn btn-sm btn-icon btn-active-light-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form action="{{ $setup_create['action'] }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @isset($setup_create['isupdate'])
                                @method('PUT')
                            @endisset

                            <div class="modal-body mx-4">
                                @isset($setup_create['inrow'])
                                    <div class="row">
                                    @endisset
                                    @include('partials.fields-modal', ['fiedls' => $fields_create])
                                    @isset($setup_create['inrow'])
                                    </div>
                                @endisset
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">
                                    {{ __('Close') }}
                                </button>
                                <button type="submit" class="btn btn-info">
                                    {{ isset($setup_create['isupdate']) ? __('Update record') : __('Create record') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endisset

    <!-- JS: Live search -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const appCards = document.querySelectorAll('.contenedor');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = searchInput.value.toLowerCase();
                appCards.forEach(card => {
                    const appName = card.getAttribute('data-name').toLowerCase();
                    card.style.display = appName.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    </script>

    @include('layouts.footers.auth')
@endsection
