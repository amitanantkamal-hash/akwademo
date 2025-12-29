<div>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div id="kt_app_toolbar" class="app-toolbar">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                    <div class="card-title fw-semibold fs-4">
                        {{ __('Contacts') }}
                        <span class="badge fw-bold px-3 py-2 ms-2 badge-light-primary">
                            {{ count($contacts) }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <button wire:click="toggleFilters" class="btn btn-link"
                            aria-expanded="{{ $filterVisible ? 'true' : 'false' }}">
                            {{ $filterVisible ? 'Hide' : 'Show' }} Advanced Search
                        </button>
                        <a href="{{ route('contacts.index') }}"
                            class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Exportar</a>
                        <a href="{{ route('contacts.index') }}"
                            class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Importar</a>
                        <livewire:addContact>
                    </div>
                </div>
            </div>
        </div>
        @if ($filterVisible)
            <div id="filter-container">
                @include('contacts::contacts.partials.advanceSearch')
            </div>
            <div id="container-filter">
                <div class="container-fluid px-0">
                    <div class="container-fluid px-0">
                        <div class="d-flex  justify-content-between pb-7">
                            <div>
                                <button
                                    class="btn btn-sm btn-light btn-color-muted btn-active-primary active">Bulk_action</button>
                            </div>
                            <ul class="d-flex justify-content-end nav nav-pills w-100" role="tablist">
                                <li class="nav-item m-0" role="presentation">
                                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary me-3"
                                        data-bs-toggle="tab" href="#kt_project_users_card_pane" aria-selected="false"
                                        role="tab">
                                        <i class="ki-outline ki-element-plus fs-2"></i> </a>
                                </li>
                                <li class="nav-item m-0" role="presentation">
                                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary active"
                                        data-bs-toggle="tab" href="#kt_project_users_table_pane" aria-selected="true"
                                        tabindex="-1" role="tab">
                                        <i class="ki-outline ki-row-horizontal fs-2"></i> </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div id="kt_project_users_card_pane" class="tab-pane fade" role="tabpanel">
                                <div class="row g-6 g-xl-9">
                                    @foreach ($contacts as $item)
                                        <div class="col-md-6 col-xxl-3">
                                            <div class="card ">
                                                <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                                                    <div class="symbol symbol-65px symbol-circle mb-5">
                                                        <img alt="Pic"
                                                            src="{{ $item->avatar ? $item->avatar : asset('default-user.jpg') }}" />
                                                        <div
                                                            class="bg-success position-absolute border border-4 border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3">
                                                        </div>
                                                    </div>
                                                    <a href="#"
                                                        class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">
                                                        {{ $item->name }} {{ $item->lastname }}
                                                    </a>
                                                    <div class="fw-semibold text-gray-500 mb-2">
                                                        {{ $item->phone ?? 'No phone' }}
                                                    </div>
                                                    <div class="fw-semibold text-gray-500 mb-2">
                                                        {{ $item->email ?? 'No email' }}
                                                    </div>
                                                    {{--
                                        <div class="d-flex flex-center flex-wrap">
                                            <div
                                                class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                                <div class="fs-6 fw-bold text-gray-700">$14,560</div>
                                                <div class="fw-semibold text-gray-500">Earnings</div>
                                            </div>
                                            <div
                                                class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                                <div class="fs-6 fw-bold text-gray-700">23</div>
                                                <div class="fw-semibold text-gray-500">Tasks</div>
                                            </div>
                                            <div
                                                class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                                <div class="fs-6 fw-bold text-gray-700">$236,400</div>
                                                <div class="fw-semibold text-gray-500">Sales</div>
                                            </div>
                                        </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex flex-stack flex-wrap pt-10">
                                    <div class="fs-6 fw-semibold text-gray-700">
                                        Showing 1 to 10 of 50 entries
                                    </div>
                                    <ul class="pagination">
                                        <li class="page-item previous">
                                            <a href="#" class="page-link"><i class="previous"></i></a>
                                        </li>
                                        <li class="page-item active">
                                            <a href="#" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">4</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">5</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">6</a>
                                        </li>
                                        <li class="page-item next">
                                            <a href="#" class="page-link"><i class="next"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="kt_project_users_table_pane" class="tab-pane fade show active" role="tabpanel">
                                <div class="card card-flush ">
                                    <div class="card-body pt-0">
                                        <div class="table-responsive">
                                            <div id="kt_project_users_table_wrapper"
                                                class="dt-container dt-bootstrap5 dt-empty-footer">
                                                <div id="" class="table-responsive">
                                                    <table id="kt_project_users_table"
                                                        class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold dataTable"
                                                        style="width: 100%;">
                                                        <colgroup>
                                                            <col data-dt-column="0" style="width: 0px;">
                                                            <col data-dt-column="1" style="width: 0px;">
                                                            <col data-dt-column="2" style="width: 0px;">
                                                            <col data-dt-column="3" style="width: 0px;">
                                                            <col data-dt-column="4" style="width: 0px;">
                                                        </colgroup>
                                                        <thead class="fs-7 text-gray-500 text-uppercase">
                                                            <tr>
                                                                <th class="min-w-250px dt-orderable-asc dt-orderable-desc"
                                                                    data-dt-column="0" rowspan="1" colspan="1"
                                                                    aria-label="Manager: Activate to sort"
                                                                    tabindex="0">
                                                                    <span class="dt-column-title"
                                                                        role="button">{{ __('Avatar and Name') }}</span><span
                                                                        class="dt-column-order"></span>
                                                                </th>
                                                                <th class="min-w-90px dt-type-numeric dt-orderable-asc dt-orderable-desc text-center"
                                                                    data-dt-column="2" rowspan="1" colspan="1"
                                                                    aria-label="Amount: Activate to sort"
                                                                    tabindex="0">
                                                                    <span class="dt-column-title"
                                                                        role="button">{{ __('Phone') }}</span><span
                                                                        class="dt-column-order"></span>
                                                                </th>
                                                                <th class="min-w-90px dt-orderable-asc dt-orderable-desc text-center"
                                                                    data-dt-column="3" rowspan="1" colspan="1"
                                                                    aria-label="Status: Activate to sort"
                                                                    tabindex="0">
                                                                    <span class="dt-column-title"
                                                                        role="button">{{ __('Email') }}</span><span
                                                                        class="dt-column-order"></span>
                                                                </th>
                                                                <th class="min-w-50px text-end dt-orderable-none text-center"
                                                                    data-dt-column="4" rowspan="1" colspan="1"
                                                                    aria-label="Details"><span
                                                                        class="dt-column-title">{{ __('Subscription Status') }}</span><span
                                                                        class="dt-column-order"></span></th>
                                                                <th class="min-w-150px dt-orderable-asc dt-orderable-desc text-center"
                                                                    data-dt-column="1" rowspan="1" colspan="1"
                                                                    aria-label="Date: Activate to sort"
                                                                    tabindex="0">
                                                                    <span class="dt-column-title"
                                                                        role="button">{{ __('Actions') }}</span><span
                                                                        class="dt-column-order"></span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fs-6">
                                                            @foreach ($contacts as $item)
                                                                <tr data-name="{{ $item->name }}"
                                                                    data-lastname="{{ $item->lastname }}"
                                                                    data-phone="{{ $item->phone }}"
                                                                    data-email="{{ $item->email }}"
                                                                    data-subscription="{{ $item->subscribed }}">
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="me-5 position-relative">
                                                                                <div
                                                                                    class="symbol symbol-35px symbol-circle">
                                                                                    <img alt="Pic"
                                                                                        src="{{ $item->avatar ? $item->avatar : asset('default-user.jpg') }}" />
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <a wire:click.prevent="$dispatch('checkContact', {contact: {{ json_encode($item) }}, fields: {{ json_encode($item->fields()->get()->toArray()) }}})"
                                                                                    class="fs-6 fw-bold text-gray-900 text-hover-primary mb-2"
                                                                                    style="cursor: pointer;">{{ $item->name }}
                                                                                    {{ $item->lastname }}</a>
                                                                                {{-- <div class="fw-semibold fs-6 text-gray-500">
                                                                            {{ $item->phone}}</div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $item->phone }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $item->email ?? 'No email' }}</td>
                                                                    <td class="text-center">
                                                                        <span
                                                                            class="badge fw-bold px-3 py-2 ms-2  {{ $item->subscribed == 0 ? 'badge-light-danger' : 'badge-light-primary' }}">
                                                                            {{ $item->subscribed == 0 ? 'Not Subscribed' : 'Subscribed' }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button
                                                                            wire:click.prevent="toggleSubscriptionOnContact({{ $item->id }})"
                                                                            class="btn btn-sm btn-light {{ $item->subscribed == 0 ? 'btn-success' : 'btn-danger' }}">
                                                                            <i class="ki-outline ki-messages fs-2"
                                                                                onclick="toggleFiltersB(true)"></i>
                                                                            {{ $item->subscribed == 0 ? 'Subscribe' : 'Unsubscribe' }}
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot></tfoot>
                                                    </table>
                                                </div>
                                                <div id="" class="row">
                                                    <div id=""
                                                        class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                                        <div><select name="kt_project_users_table_length"
                                                                aria-controls="kt_project_users_table"
                                                                class="form-select form-select-solid form-select-sm"
                                                                id="dt-length-0">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select><label for="dt-length-0"></label></div>
                                                    </div>
                                                    <div id=""
                                                        class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                                        <div class="dt-paging paging_simple_numbers">
                                                            <nav aria-label="pagination">
                                                                <ul class="pagination">
                                                                    <li class="dt-paging-button page-item disabled">
                                                                        <button class="page-link previous"
                                                                            role="link" type="button"
                                                                            aria-controls="kt_project_users_table"
                                                                            aria-disabled="true" aria-label="Previous"
                                                                            data-dt-idx="previous" tabindex="-1"><i
                                                                                class="previous"></i></button>
                                                                    </li>
                                                                    <li class="dt-paging-button page-item active">
                                                                        <button class="page-link" role="link"
                                                                            type="button"
                                                                            aria-controls="kt_project_users_table"
                                                                            aria-current="page"
                                                                            data-dt-idx="0">1</button>
                                                                    </li>
                                                                    <li class="dt-paging-button page-item"><button
                                                                            class="page-link next" role="link"
                                                                            type="button"
                                                                            aria-controls="kt_project_users_table"
                                                                            aria-label="Next" data-dt-idx="next"><i
                                                                                class="next"></i></button></li>
                                                                </ul>
                                                            </nav>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!$filterVisible)
            <div id="contact-container" class="app-content flex-column-fluid" style="display: flex;">
                <div class="row g-7">
                    <!--begin::Contact groups-->
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="card card-flush">
                            <div class="card-header pt-7" id="kt_chat_contacts_header">
                                <div class="card-title">
                                    <h2>Listas</h2>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div class="d-flex flex-column gap-5">
                                    @foreach ($groups as $item)
                                        <div class="d-flex flex-stack">
                                            <a href="#" class="btn btn-transparent p-0 btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <i class="ki-outline ki-dots-square fs-2"></i>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3" data-bs-toggle="modal"
                                                        data-bs-target="#editGroupModal"
                                                        data-group-id="{{ $item->id }}"
                                                        data-group-name="{{ $item->name }}">Editar</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                        data-bs-target="#deleteGroupModal"
                                                        data-group-id="{{ $item->id }}">Borrar</a>
                                                </div>
                                            </div>
                                            <a href="#"
                                                class="fs-6 fw-bold text-gray-800 text-hover-primary flex-grow-1">
                                                {{ $item->name }} </a>
                                            @if ($item->contacts()->count() == 0)
                                                <div class="badge badge-light-gray">
                                                    {{ $item->contacts()->count() }}
                                                </div>
                                            @else
                                                <div class="badge badge-light-info">
                                                    {{ $item->contacts()->count() }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="separator my-7"></div>
                                <form action="{{ route('contacts.storlist') }}" method="POST">
                                    @csrf <!-- Token de seguridad para enviar formularios POST en Laravel -->
                                    <label class="fs-6 fw-semibold form-label">{{__('Add Group')}}</label>
                                    <div class="input-group">
                                        <input type="text" name="list_name"
                                            class="form-control form-control-solid" placeholder="Name" required />
                                        <button type="submit" class="btn btn-icon btn-light">
                                            <i class="ki-outline ki-plus-square fs-2"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="separator my-7"></div>
                                <livewire:addField>
                            </div>
                        </div>
                    </div>
                    <livewire:CheckContact :contacts="$contacts" />
                    <div class="col d-flex flex-column">
                        <livewire:user-contact-box :groups="$groups" :camposAdicionales="$camposAdicionales" :contacts="$contacts" />
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('contacts::contacts.partials.modals')
    @include('contacts::contacts.partials.scripts')
</div>
