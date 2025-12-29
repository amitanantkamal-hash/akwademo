@extends('layouts.app-client')

@section('title')
    <x-button-links />
@endsection

@section('content')
    <div class="row">
        @include('partials.flash-client')
        <div class="d-flex justify-content-end">
            <div class="col-md-4">
                <div class="d-flex align-items-center position-relative">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                    <input type="text" id="searchInput" class="form-control form-control-lg ps-12 me-1"
                        placeholder="Search...">
                </div>
            </div>
        </div>

        @php
            $modules = [
                'Agents' => (object) [
                    'name' => 'Agents',
                    'icon' => asset('custom/imgs/company_apps/Agent.png'),
                    'description' =>
                        'This section allows you to manage agents who interact with customers through the platform.',
                    'slider' => 'custom[agent_enable]',
                ],
                'Translation settings' => (object) [
                    'name' => 'Translation settings',
                    'icon' => asset('custom/imgs/company_apps/translate.png'),
                    'description' =>
                        'Configure automatic translation options for conversations in different languages.',
                    'slider' => 'custom[translation_enabled]',
                ],
                'WebHooks' => (object) [
                    'name' => 'WebHooks',
                    'icon' => asset('custom/imgs/company_apps/webHook.png'),
                    'description' =>
                        'In this section, you can manage WebHooks, which allow the application to integrate with external systems.',
                    'slider' => '',
                ],
                'Chat settings' => (object) [
                    'name' => 'Chat settings',
                    'icon' => asset('custom/imgs/company_apps/chatsetting.png'),
                    'description' => 'Configure chat preferences such as automatic replies and predefined messages.',
                    'slider' => '',
                ],
                'Bot settings' => (object) [
                    'name' => 'Bot settings',
                    'icon' => asset('custom/imgs/company_apps/botconfig.png'),
                    'description' => 'Here, you can configure automated bots that respond to customer messages.',
                    'slider' => '',
                ],
                'Voiceflow' => (object) [
                    'name' => 'Voiceflow',
                    'icon' => asset('custom/imgs/company_apps/VoiceFlow.png'),
                    'description' => 'Voiceflow allows users to design conversation flows intuitively.',
                    'slider' => 'custom[enable_voiceflow]',
                ],
                'WooCommerce integration' => (object) [
                    'name' => 'WooCommerce integration',
                    'icon' => asset('custom/imgs/woocommerce.svg'),
                    'description' => 'Integration with WooCommerce to manage products and orders.',
                    'slider' => '',
                ],
                'Shopify integration' => (object) [
                    'name' => 'Shopify integration',
                    'icon' => asset('custom/imgs/shopify.svg'),
                    'description' => 'Integration with Shopify to manage products and sales.',
                    'slider' => '',
                ],
                'Ecommerce' => (object) [
                    'name' => 'Ecommerce',
                    'icon' => asset('custom/imgs/shopify.svg'),
                    'description' => 'Integration with Ecommerce to manage Ecommerce on a subdomain.',
                    'slider' => '',
                ],

                'Facebook' => (object) [
                    'name' => 'Facebook',
                    'icon' => asset('custom/imgs/facebook.svg'),
                    'description' => 'Facebook allows you to communicate with your customers via Facebook.',
                    'slider' => '',
                    'link' => route('ctwameta.index'),
                ],
                'Instagram' => (object) [
                    'name' => 'Instagram',
                    'icon' => asset('custom/imgs/instagram.svg'),
                    'description' => 'Connect with your customers via Instagram.',
                    'slider' => '',
                ],
            ];
        @endphp
        {{-- @dd($modules) --}}
        <div class="row g-3 g-lg-4 ps-6" id="appContainer">
            @foreach ($separators as $separator)
                @php
                    $module = $modules[$separator['name']] ?? null;
                @endphp
                @if ($module)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4  app-card" data-name="{{ $module->name }}">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body p-0">
                                <div class="d-flex flex-stack  px-8 pt-8 flex-grow-1">
                                    <div class="align-items-center d-flex gap-2 justigy-content-start">
                                        {{-- {!! $icon !!} con esta sintaxis ingresas html directamente. --}}
                                        <img alt='Icono de WooCommerce'
                                            src="{{ $module->icon }}"style="height: 44px; width: 44px;">
                                        @if (array_key_exists('link', $separator))
                                            <span class="badge badge-light-info h-100 justify-content-center">Beta</span>
                                        @endif
                                    </div>
                                    <span class="symbol symbol-50px text-end">
                                        <a class="btn btn-sm btn-icon btn-clear btn-light">
                                            <i class="ki-duotone ki-information-2 fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </a>
                                    </span>
                                </div>
                                <div class="d-flex flex-column card-p flex-grow-1">
                                    <a class="text-gray-900 fw-bold fs-5 flex cursor-default" href="#">
                                        {{ $module->name }}
                                    </a>
                                    @if (array_key_exists('link', $separator))
                                        <p class="text-gray-700 fs-6">Imagine being able to send messages to your
                                            {{ $module->name }} contacts without changing the app! Request beta access from
                                            our team and enjoy a smoother and more complete messaging experience.</p>
                                    @else
                                        <span class="text-gray-700 fs-6">
                                            {{ $module->description }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between items-center py-4">
                                @if (array_key_exists('link', $separator))
                                    @if (isset($module->link))
                                        <a class="btn btn-light btn-sm" href="{{ $module->link }}"> {{-- href={{route('meta.setup',['socialMedia' => $separator['link']])}} --}}
                                            <i class="ki-duotone ki-setting-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Settings
                                        </a>
                                    @else
                                        <a class="btn btn-light btn-sm disabled" disabled"> {{-- href={{route('meta.setup',['socialMedia' => $separator['link']])}} --}}
                                            <i class="ki-duotone ki-setting-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Settings
                                        </a>
                                    @endif
                                @else
                                    <a disabled class="btn btn-light btn-sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#restorantModal" data-tab="#{{ $separator['snake'] }}">
                                        <i class="ki-duotone ki-setting-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Settings
                                    </a>
                                    <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        @if ($module->slider != '')
                                            @include('partials.fields-client-check', [
                                                'fields' => $separator['fields'],
                                            ])
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- @else
                    <p>Módulo no encontrado para el separador: {{ $separator['name'] }}</p> --}}
                @endif
            @endforeach
        </div>
        <!-- Modal -->
        <div class="modal fade" id="restorantModal" tabindex="-1" role="dialog" aria-labelledby="restorantModalLabel"
            aria-hidden="true">
            <div class="modal-dialog mw-650px modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-10">
                        <form id="company-apps-form" method="POST" autocomplete="off" enctype="multipart/form-data"
                            action="{{ route('admin.owner.updateApps', $company) }}">
                            @csrf
                            @method('PUT')

                            <div class="tab-content" id="myTabContent">
                                @foreach ($separators as $separator)
                                    <div class="tab-pane fade show @if ($loop->first) active @endif"
                                        id="{{ $separator['snake'] }}" role="tabpanel"
                                        aria-labelledby="{{ $separator['snake'] }}">
                                        @include('partials.fields-client', [
                                            'fields' => $separator['fields'],
                                        ])
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center mt-7">
                                <button type="submit" id="ajaxSaveBtn" class="btn btn-info">{{ __('Save') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#company-apps-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData(this);

                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT' // simulate PUT via POST
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#ajaxSaveBtn').prop('disabled', true).text('Saving...');
                    },
                    success: function(response) {
                        toastr.success('Settings updated successfully!');
                        $('#ajaxSaveBtn').prop('disabled', false).text('Save');
                        $('#restorantModal').modal('hide');
                    },
                    error: function(xhr) {
                        $('#ajaxSaveBtn').prop('disabled', false).text('Save');

                        let message = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            message = Object.values(xhr.responseJSON.errors).flat().join(
                            '<br>');
                        }
                        toastr.error(message);
                    }
                });
            });

            // For modal tab switching
            $('#restorantModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var tabToActivate = button.data('tab');

                $('.tab-pane').removeClass('active show');
                $(tabToActivate).addClass('active show');
            });
        });
    </script>

    <script>
        $('#restorantModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var tabToActivate = button.data('tab');

            $('.tab-pane').removeClass('active show');
            $(tabToActivate).addClass('active show');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('custom[agent_enable]');
            const form = document.getElementById('form-custom[agent_enable]');
            checkbox.addEventListener('change', function() {
                form.submit();
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('custom[translation_enabled]');
            const form = document.getElementById('form-custom[translation_enabled]');
            checkbox.addEventListener('change', function() {
                form.submit();
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('custom[enable_voiceflow]');
            const form = document.getElementById('form-custom[enable_voiceflow]');
            checkbox.addEventListener('change', function() {
                form.submit();
            });
        });
        //filtrar
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const appCards = document.querySelectorAll('.app-card');
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
@endsection
