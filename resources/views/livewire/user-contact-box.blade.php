<div class="card card-flush h-800px" id="kt_contacts_main">
    @if ($view === 'addContact')
        <div class="card-header pt-7" id="kt_chat_contacts_header">
            <div class="card-title">
                <i class="ki-outline ki-badge fs-1 me-2"></i>
                <h2>Add contact</h2>
            </div>
        </div>
        <div class="card-body pt-5">
            <form id="kt_ecommerce_settings_general_form" class="form" action="{{ route('contacts.storeContact') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label class="fs-6 fw-semibold mb-3">
                        <span>Add avatar</span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg.">
                            <i class="ki-outline ki-information fs-7"></i>
                        </span>
                    </label>
                    <div class="d-flex">
                        <div class="flex-1 mt-1">
                            <style>
                                .image-input-placeholder {
                                    background-image: url('{{ asset('Metronic/assets/media/avatars/blank.png') }}');
                                }

                                [data-bs-theme="dark"] .image-input-placeholder {
                                    background-image: url('{{ asset('Metronic/assets/media/avatars/blank.png') }}');
                                }
                            </style>
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url('{{ asset('Metronic/assets/media/avatars/blank.png') }}')">
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url('{{ asset('Metronic/assets/media/avatars/blank.png') }}')">
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg"
                                        onchange="previewImage(event)" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Cancel avatar" onclick="cancelImage()">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Remove avatar" onclick="removeImage()">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 d-flex justify-content-start ms-8 align-items-center">
                            <div class="fv-row mb-2">
                                <label class="fs-6 fw-semibold form-label mt-5">
                                    <span class="form-check">
                                        <input type="checkbox" class="form-check-input" id="enabled_ia_bot"
                                            name="enable_ia_bots" value="1" />
                                        <span>{{ __('Enable AI Bots replies') }}</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="Toggle to enable replies from AI Bots.">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span class="required">{{ __('Name') }}</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Enter the contact's name.">
                                <i class="ki-outline ki-information fs-7"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="name" value="" />
                    </div>
                    <div class="col-6">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span class="required">{{ __('Last Name') }}</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Enter the contact's name.">
                                <i class="ki-outline ki-information fs-7"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="lastname" value="" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span>Telefono</span>
                            <span class="ms-1" data-bs-toggle="tooltip"
                                title="Enter the contact's phone number (optional).">
                                <i class="ki-outline ki-information fs-7"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="phone" value="" />
                    </div>
                    <div class="col-6">
                        <div class="fv-row mb-2">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Country</span>
                            </label>
                            <div class="w-100">
                                @include('livewire.components.select-country')
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" class="form-control form-control-solid" name="company_id"
                    value="{{ auth()->user()->company_id }}" />


                <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                    <div class="col">
                        @include('partials.select-reminder-12', $field = $fields_groups)
                    </div>
                    @foreach ($camposAdicionales as $index => $campo)
                        <div class="col">
                            <div class="fv-row mb-2">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>{{ $campo->name }}</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        title="Enter the contact's {{ strtolower($campo->name) }}.">
                                        <i class="ki-outline ki-information fs-7"></i>
                                    </span>
                                </label>
                                <input type="{{ $campo->type }}" class="form-control form-control-solid"
                                    name="custom[{{ $campo->id }}]" value="" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="separator mb-6"></div>
                <div class="d-flex justify-content-end">
                    <button type="reset" data-kt-contacts-type="cancel" class="btn btn-light me-3"
                        wire:click="$dispatch('switchView', { view: 'Contact'})">Clear</button>
                    <button type="submit" data-kt-contacts-type="submit" class="btn btn-info">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    @elseif ($view === 'editContact')
        <div class="card-header pt-7" id="kt_chat_contacts_header">
            <div class="card-title">
                <i class="ki-outline ki-badge fs-1 me-2"></i>
                <h2>Edit contact</h2>
            </div>
        </div>
        <div class="card-body pt-5">
            <form id="kt_ecommerce_settings_general_form" class="form"
                action="{{ route('contacts.update', ['contact' => $contact['id']]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <label class="fs-6 fw-semibold mb-3">
                        <span>Update photo</span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg.">
                            <i class="ki-outline ki-information fs-7"></i>
                        </span>
                    </label>
                    <div class="d-flex">

                        <div class="flex-1 mt-1">

                            @php
                                if ($contact['avatar'] != null) {
                                    $avatar = $contact['avatar'];
                                } else {
                                    $avatar = asset('Metronic/assets/media/avatars/blank.png');
                                }
                            @endphp
                            <style>
                                .image-input-placeholder {
                                    background-image: url('{{ $avatar }}');
                                }

                                [data-bs-theme="dark"] .image-input-placeholder {
                                    background-image: url('{{ $avatar }}');
                                }
                            </style>
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url('{{ asset('Metronic/assets/media/avatars/blank.png') }}')">
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url('{{ $avatar }}')">
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg"
                                        onchange="previewImage(event)" />
                                    <input type="hidden" name="avatar_remove" id='avatar_remove' />
                                </label>

                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Cancel avatar" onclick="cancelImage()">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Remove avatar" onclick="removeImage()">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 d-flex justify-content-start ms-8 align-items-center">
                            <div class="fv-row mb-2">
                                <label class="fs-6 fw-semibold form-label mt-5">
                                    <span class="form-check">
                                        <input type="checkbox" class="form-check-input" id="enabled_ia_bot"
                                            name="enable_ia_bots" value="1"
                                            @if ($contact['subscribed']) checked @endif />
                                        <span>{{ __('Enable AI Bots replies') }}</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="Toggle to enable replies from IA Bots.">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span class="required">{{ __('Name') }}</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Enter the contact's name.">
                                <i class="ki-outline ki-information fs-7"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="name"
                            value="{{ $contact['name'] }}" />
                    </div>
                    <div class="col-6">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span class="required">{{ __('Last Name') }}</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Enter the contact's name.">
                                <i class="ki-outline ki-information fs-7"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="lastname"
                            value="{{ $contact['lastname'] }}" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span>WhatsApp number</span>
                            <span class="ms-1" data-bs-toggle="tooltip"
                                title="Enter the contact's phone number (optional).">
                                <i class="ki-outline ki-information fs-7"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="phone"
                            value="{{ $contact['phone'] }}" />
                    </div>
                    <div class="col-6">
                        <div class="fv-row mb-2">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Country</span>
                            </label>
                            <div class="w-100">
                                <select id="kt_ecommerce_select2_country" class="form-select form-select-solid"
                                    name="country_id" data-kt-ecommerce-settings-type="select2_flags"
                                    data-placeholder="Select a country">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $contact['country_id'] ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" class="form-control form-control-solid" name="company_id"
                    value="{{ auth()->user()->company_id }}" />




                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-1 row-cols-lg-2">
                    <div class="col">
                        @include('partials.select-reminder-12', $field = $fields_groups)

                    </div>
                    @if (isset($fields))
                        @foreach ($fields as $campo)
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        <span>{{ $campo['name'] }}</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="Enter the contact's {{ strtolower($campo['name']) }}.">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                    </label>
                                    <input type="{{ $campo['type'] }}" class="form-control form-control-solid"
                                        name="custom[{{ $campo['id'] }}]" value="{{ $campo['pivot']['value'] }}" />
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($contact['fields'] as $campo)
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        <span>{{ $campo->name }}</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="Enter the contact's {{ strtolower($campo->name) }}.">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                    </label>
                                    <input type="{{ $campo->type }}" class="form-control form-control-solid"
                                        name="custom[{{ $campo->id }}]" value="{{ $campo['pivot']['value'] }}" />
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-1 row-cols-lg-2">
                    @foreach ($camposAdicionales as $index => $campo)
                        @if (!in_array($campo->id, $existingFieldIds))
                            <!-- Verificar si el campo ya existe -->
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        <span>{{ $campo->name }}</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="Enter the contact's {{ strtolower($campo->name) }}.">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                    </label>
                                    <input type="{{ $campo->type }}" class="form-control form-control-solid"
                                        name="custom[{{ $campo->id }}]" value="" />
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="separator mb-6"></div>
                <div class="d-flex justify-content-end">
                    <button type="reset" data-kt-contacts-type="cancel" class="btn btn-light me-3"
                        wire:click="$dispatch('switchView', { view: 'Contact'})">Clear</button>
                    <button type="submit" data-kt-contacts-type="submit" class="btn btn-info">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    @elseif ($view === 'addField')
        <div class="card card-flush h-lg-100" id="kt_contacts_main">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between p-4">
                    <div>
                        <button wire:click="$dispatch('switchView', { view: 'Contact'})" class="btn btn-info w-100">
                            <i class="ki-duotone ki-double-left fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{__('Return to Contact')}}
                        </button>
                    </div>

                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addFieldModal">
                        {{ __('Add Field') }}
                    </button>
                </div>
                <div class="card-px text-center py-5 my-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5">
                            <thead>
                                <tr class="text-center text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($camposAdicionales as $campo)
                                    <tr>
                                        <td class="text-gray-800 text-hover-primary fs-5 fw-bold">{{ $campo->name }}
                                        </td> <!-- Muestra el nombre del campo -->
                                        <td>{{ $campo->type }}</td> <!-- Muestra el tipo del campo -->
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editFields" data-field-id="{{ $campo->id }}">
                                                {{ __('crud.edit') }}
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#deleteFields"
                                                data-field-id="{{ $campo->id }}">
                                                {{ __('crud.delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card card-flush h-lg-100" id="kt_contacts_main">
            <div class="card-header pt-7 d-flex" id="kt_chat_contacts_header">
                <div class="flex-1 card-title">
                    <i class="ki-outline ki-badge fs-1 me-2"></i>
                    <h2>Contact Details</h2>
                </div>
                <div class="flex-grow-1 d-flex justify-content-end card-toolbar gap-3">
                    @if (config('settings.app_code_name', '') == 'wpbox')
                        <a href="{{ route('campaigns.create', ['contact_id' => $contact['id']]) }}"
                            class="btn btn-sm btn-light btn-active-light-primary">
                            <i class="ki-outline ki-message-text-2 fs-6"></i>Chat
                        </a>
                    @endif
                    <a href="#" wire:click="toggleSubscription({{ json_encode($contact) }})"
                        class="btn btn-sm btn-light {{ $contact['subscribed'] == 0 ? 'btn-success' : 'btn-danger' }}">
                        <i class="ki-outline ki-messages fs-6"></i>
                        {{ $contact['subscribed'] == 0 ? 'Subscribe' : 'Unsubscribe' }}
                    </a>
                    @php
                        $toGroups = [];
                        if (isset($contact['groups'])) {
                            // Si el array está vacío, $toGroups se queda como un array vacío
                            if (!empty($contact['groups'])) {
                                $toGroups = $contact['groups'];
                            }
                        }
                        if (empty($toGroups) && isset($contactGroup)) {
                            $toGroups = $contactGroup;
                        }
                    @endphp
                    <button wire:click="$dispatch('switchView', { view: 'editContact' })"
                        class="btn btn-sm btn-info btn-active-light-info"
                        onclick="select2edit({{ json_encode($toGroups) }})">
                        <i class="ki-solid ki-notepad-edit fs-2 m-0 p-0"></i>
                    </button>

                    <a href="{{ route('contacts.delete', ['contact' => $contact['id']]) }}"
                        class="btn btn-sm btn-light-danger btn-active-light-info">
                        <i class="ki-solid ki-cross fs-1 m-0 p-0"></i>
                    </a>
                </div>
            </div>
            <div class="card-body pt-5">
                <div class="d-flex gap-7 align-items-center">
                    <div class="flex-1 d-flex flex-row">
                        <div class="symbol symbol-circle symbol-100px">
                            @if (!empty($contact['avatar']))
                                <img alt="Picture Avatar" src="{{ $contact['avatar'] }}"class="avatar shadow" />
                            @else
                                <span
                                    class="symbol-label bg-light-primary text-primary fs-2x fw-bolder">{{ strtoupper(substr($contact['name'], 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="d-flex flex-column gap-2 ms-4">
                            <div class="d-flex flex-row align-items-center gap-2">
                                <h3 class="mb-0">{{ $contact['name'] }} {{ $contact['lastname'] }}</h3>
                                <span
                                    class="badge fw-bold px-3 py-2 ms-2  {{ $contact['subscribed'] == 0 ? 'badge-light-danger' : 'badge-light-primary' }}">
                                    {{ $contact['subscribed'] == 0 ? 'Not Subscribed' : 'Subscribed' }}
                                </span>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-outline ki-sms fs-2"></i>
                                <a href="#" class="text-muted text-hover-primary">
                                    @if (isset($fields))
                                        @php
                                            $emailField = collect($fields)->firstWhere('name', 'Email');
                                            $emailValue = $emailField ? $emailField['pivot']['value'] : null;
                                        @endphp
                                        @if ($emailValue)
                                            @if ($emailValue === '')
                                                <div class="fs-5">N/A</div>
                                            @else
                                                <div class=" fs-5">
                                                    {{ $emailValue }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="fs-5">N/A</div>
                                        @endif
                                    @else
                                        @php
                                            $emailField = collect($contact['fields'])->firstWhere('name', 'Email');
                                            $emailValue = $emailField ? $emailField['pivot']['value'] : null;
                                        @endphp
                                        @if ($emailValue)
                                            @if ($emailValue === '')
                                                <div class=" fs-5">N/A</div>
                                            @else
                                                <div class=" fs-5">
                                                    {{ $emailValue }}
                                                </div>
                                            @endif
                                        @else
                                            <div class=" fs-5">N/A</div>
                                        @endif
                                    @endif
                                </a>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-outline ki-phone fs-2"></i>
                                <a href="#"
                                    class="text-muted text-hover-primary">{{ $contact['phone'] ?? 'N/A' }}</a>
                            </div>

                        </div>
                    </div>
                </div>
                @if (isset($contact['groups']))
                    @if (empty($contact['groups']) || count($contact['groups']) == 0)
                        <div class="flex-grow-1 justify-center">
                            <label class="text-center fw-semibold fs-4 mb-4 mt-4">{{ __('Groups') }}</label>
                        </div>
                        <span class="p-2 fw-bold fs-4">{{ __('Without groups') }}</span>
                    @elseif (count($contact['groups']) > 0)
                        <div class="d-flex flex-column">
                            <div class="flex-grow-1 justify-center ">
                                <label class="text-center fw-semibold fs-4 mb-4 mt-4">{{ __('Groups') }}</label>
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    @foreach ($contact['groups'] as $index => $contactGroup)
                                        <div class="col-auto mb-2">
                                            @if ($index % 2 == 0)
                                                <a href="/contacts/manage?group={{ $contactGroup['id'] }}"
                                                    class="badge badge-light-success fw-bold p-3">{{ $contactGroup['name'] }}</a>
                                            @else
                                                <a href="/contacts/manage?group={{ $contactGroup['id'] }}"
                                                    class="badge badge-secondary fw-bold p-3">{{ $contactGroup['name'] }}</a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="d-flex flex-column">
                        <div class="flex-grow-1 justify-center">
                            <label class="text-center fw-semibold fs-4 mb-4 mt-4">{{ __('Groups') }}</label>
                        </div>
                        <div class="container">
                            <div class="row justify-content-center">
                                @if (isset($contactGroup))
                                    @foreach ($contactGroup as $index => $cGroup)
                                        <div class="col-auto mb-2">
                                            @if ($index % 2 == 0)
                                                <a href="/contacts/manage?group={{ $cGroup['id'] }}"
                                                    class="badge badge-light-success fw-bold p-3">{{ $cGroup['name'] }}</a>
                                            @else
                                                <a href="/contacts/manage?group={{ $cGroup['id'] }}"
                                                    class="badge badge-secondary fw-bold p-3">{{ $cGroup['name'] }}</a>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span class="p-2 fw-bold fs-4">{{ __('Without groups') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 fw-semibold mt-6 mb-8 gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary d-flex align-items-center pb-4 active"
                            data-bs-toggle="tab" href="#kt_contact_view_general">
                            <i class="ki-outline ki-home fs-4 me-1"></i>General</a>
                    </li>
                </ul>
                <div class="tab-content" id="">
                    <div class="tab-pane fade show active" id="kt_contact_view_general" role="tabpanel">
                        <div class="d-flex flex-column gap-5 mt-7">
                            <div class="d-flex flex-column gap-1">
                                <div class="fw-bold text-muted">Country</div>
                                <div class="fw-bold fs-5">
                                    {{ $contact_country }}
                                </div>
                            </div>
                            <div class="separator mb-6"></div>
                            <div class="row mt-5">
                                @if (isset($fields))
                                    @foreach ($fields as $index => $campo)
                                        {{-- @dd($campo) --}}
                                        <div class="col-md-6">
                                            <div class="fw-bold text-muted mb-3">{{ $campo['name'] }}</div>
                                            <div class="fw-bold fs-5">
                                                {{ empty($campo['pivot']['value']) ? 'N/A' : $campo['pivot']['value'] }}
                                            </div>
                                        </div>
                                        @if (($index + 1) % 2 == 0)
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($contact['fields'] as $index => $campo)
                                        <div class="col-md-6">
                                            <div class="fw-bold text-muted mb-3">{{ $campo['name'] }}</div>
                                            <div class="fw-bold fs-5">
                                                {{ empty($campo['pivot']['value']) ? 'N/A' : $campo['pivot']['value'] }}
                                            </div>
                                        </div>
                                        @if (($index + 1) % 2 == 0)
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="row mt-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
