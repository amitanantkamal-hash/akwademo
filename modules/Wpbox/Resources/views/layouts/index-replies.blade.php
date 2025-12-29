@extends('client.app', ['title' => __($title)])

@section('content')
    @yield('customheading')
    <div class="col-12">
        @include('partials.flash-client')
    </div>
    <div class="card card-flush">
        <div class="card-header d-flex flex-column">
            <div class="flex-1 d-flex flex-row justify-content-between mt-8">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        {{ __($title) }}
                    </div>
                </div>
                <div class="flex-1 d-flex justify-content-end">
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                        <input type="text" id="searchInput" class="form-control form-control-lg ps-12 me-2"
                            placeholder="Search...">
                    </div>
                    <div class="flex-1 ">
                        @isset($action_link)
                            @if ($view == 'qr')
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_create">
                                    {{ __($action_name) }}
                                </button>
                            @else
                                <a href="{{ $action_link }}" class="btn btn btn-info">{{ __($action_name) }}</a>
                            @endif
                        @endisset

                        @isset($action_link2)
                            @if ($view == 'qr')
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_create">
                                    {{ __($action_name2) }}
                                </button>
                            @else
                                <a href="{{ $action_link2 }}" class="btn btn btn-info">{{ __($action_name2) }}</a>
                            @endif
                        @endisset
                    </div>
                </div>

            </div>
            @isset($usefilter)
                @include('general.filters')
            @endisset
        </div>
        @yield('contenttop')
        @if (isset($iscontent))
            <div class="card-body">
                @yield('cardbody')
            </div>
        @else
            <div class="card-body">
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
            <div class="card-footer py-4">
                @if (count($items))
                    @unless (isset($hidePaging) && $hidePaging)
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $items->links() }}
                        </nav>
                    @endunless
                @else
                    <h4>{{ __('crud.no_items', ['items' => $item_names]) }}</h4>
                @endif
            </div>
        @endif
    </div>

    @isset($setup_create)
        @if ($view == 'qr')
            <div class="modal fade" tabindex="-1" id="kt_modal_create">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h2 class="modal-title">{{ __($action_name) }}</h2>
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                        </div>
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
                            <div class="modal-footer d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Close</button>
                                @if (isset($setup_create['isupdate']))
                                    <button type="submit" class="btn btn-info">{{ __('Update record') }}</button>
                                @else
                                    <button type="submit" class="btn btn-info">{{ __('Create record') }}</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endisset

    <div class="modal fade" tabindex="-1" id="kt_modal_edit">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2 class="modal-title">{{ __($action_name) }} {{ __('Flow Bot') }}</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                </div>
                <div id="modal-form-content" class="mx-4"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="kt_modal_edit_bot">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2 class="modal-title">{{ __($action_name) }} {{ __('Flow Bot') }}</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                </div>
                <div id="modal-form-content" class="mx-4"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.edit-button').on('click', function() {
                let replie = $(this).data('id');
                $.ajax({
                    url: `replies/${replie}/edit-ajax`,
                    method: 'GET',
                    success: function(data) {
                        $('#modal-form-content').html(data);
                    },
                    error: function(xhr) {
                        console.error('Error al cargar el formulario:', xhr.responseText);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('.edit-button-bot').on('click', function() {
                let replie = $(this).data('id');
                $.ajax({
                    url: `replies/${replie}/edit-ajax`,
                    method: 'GET',
                    success: function(data) {
                        $('#modal-form-content').html(data);
                    },
                    error: function(xhr) {
                        console.error('Error al cargar el formulario:', xhr.responseText);
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const appCards = document.querySelectorAll('.contenedor');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = searchInput.value.toLowerCase();
                appCards.forEach(card => {
                    const appName = card.getAttribute('data-name').toLowerCase();
                    if (appName.includes(searchTerm)) {
                        card.style.display = ''; // Mostrar tarjeta
                    } else {
                        card.style.display = 'none'; // Ocultar tarjeta
                    }
                });
            });
        });
    </script>
    @include('layouts.footers.auth')
@endsection
