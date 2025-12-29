@extends('layouts.app-client', ['title' => __('Whatsapp API')])
@section('content')
    <div class="card ">
        <div class="card-header card-header-stretch">
            <div class="card-title d-flex flex-stack flex-wrap gap-4 w-100 my-8">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            {{ __('API Keys') }}
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#" class="btn btn-info  btn-sm w-100 fs-7" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create_campaign">
                        {{ __('New API') }}
                    </a>
                    <a href="{{ config('wpbox.api_docs', 'https://documenter.getpostman.com/view/8538142/2s9Ykn8gvj') }}"
                        class="btn btn-info  btn-sm w-100 fs-7" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create_campaign">
                        {{ __('Documentation') }}
                    </a>
                    <a href="{{ route('wpbox.api.index') }}"
                        class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-info bg-body h-40px fs-7 fw-bold"
                        data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                        {{ __('Campaings API') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9" id="kt_api_keys_table">
                    <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                        <tr>
                            <th class="min-w-175px ps-9">Label</th>
                            <th class="min-w-250px px-0" colspan="1">API Keys</th>
                            <th class="min-w-100px">Creado</th>
                            <th class="w-100px" colspan="2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="fs-6 fw-semibold text-gray-600">
                        <tr>
                            <td class="ps-9">Main Api Whatbox</td>

                            <td data-bs-target="license" class="ps-0 align-middle">
                                {{ $token }}
                                {{-- <div class="position-relative">
                                <input id="new_password"
                                    class="form-control form-control-lg form-control-light border-0 fs-9" type="password"
                                    placeholder="" name="new_password" value="{{ $token }}" autocomplete="off" />
                                <button class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    onclick="togglePasswordVisibility()">
                                    <i id="eye-icon" class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span></i>
                                </button>
                            </div> --}}
                            </td>
                            <td>
                                <button data-action="copy"
                                    class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                    <i class="ki-outline ki-copy fs-2"></i> </button>
                            </td>
                            <td>
                                Nov 01, 2020
                            </td>
                            <td>
                                <span class="badge badge-light-success fs-7 fw-semibold">Active</span>

                            </td>
                            <td>
                                <div class="w-100px position-relative">
                                    <select class="form-select form-select-sm form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-placeholder="Options" data-hide-search="true"
                                        data-select2-id="select2-data-10-ja5l" tabindex="-1" aria-hidden="true"
                                        data-kt-initialized="1">
                                        <option value="" data-select2-id="select2-data-12-gg10"></option>
                                        <option value="2">Options 1</option>
                                        <option value="3">Options 2</option>
                                        <option value="4">Options 3</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5"
                                        dir="ltr" data-select2-id="select2-data-11-x68q" style="width: 100%;"><span
                                            class="selection"><span
                                                class="select2-selection select2-selection--single form-select form-select-sm form-select-solid"
                                                role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                aria-disabled="false" aria-labelledby="select2-hi5f-container"
                                                aria-controls="select2-hi5f-container"><span
                                                    class="select2-selection__rendered" id="select2-hi5f-container"
                                                    role="textbox" aria-readonly="true" title="Options"><span
                                                        class="select2-selection__placeholder">Options</span></span><span
                                                    class="select2-selection__arrow" role="presentation"><b
                                                        role="presentation"></b></span></span></span><span
                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                            </td>
                        </tr>
                        {{-- <tr>
                        <td class="ps-9">
                            Navitare </td>

                        <td data-bs-target="license" class="ps-0">
                            jk076590ygghgh324vd33 </td>

                        <td>
                            <button data-action="copy"
                                class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                <i class="ki-outline ki-copy fs-2"></i> </button>
                        </td>

                        <td>
                            Sep 27, 2020 </td>

                        <td>
                            <span class="badge badge-light-info fs-7 fw-semibold">Review</span>
                        </td>

                        <td class="pe-9">
                            <div class="w-100px position-relative">
                                <select class="form-select form-select-sm form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="Options" data-hide-search="true"
                                    data-select2-id="select2-data-13-sz52" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option value="" data-select2-id="select2-data-15-wct8"></option>
                                    <option value="2">Options 1</option>
                                    <option value="3">Options 2</option>
                                    <option value="4">Options 3</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-14-k20a" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-sm form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                            aria-disabled="false" aria-labelledby="select2-ubsz-container"
                                            aria-controls="select2-ubsz-container"><span
                                                class="select2-selection__rendered" id="select2-ubsz-container"
                                                role="textbox" aria-readonly="true" title="Options"><span
                                                    class="select2-selection__placeholder">Options</span></span><span
                                                class="select2-selection__arrow" role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-9">
                            Docs API Key </td>

                        <td data-bs-target="license" class="ps-0">
                            fftt456765gjkkjhi83093985 </td>

                        <td>
                            <button data-action="copy"
                                class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                <i class="ki-outline ki-copy fs-2"></i> </button>
                        </td>

                        <td>
                            Jul 09, 2020 </td>

                        <td>
                            <span class="badge badge-light-danger fs-7 fw-semibold">Inactive</span>
                        </td>

                        <td class="pe-9">
                            <div class="w-100px position-relative">
                                <select class="form-select form-select-sm form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="Options" data-hide-search="true"
                                    data-select2-id="select2-data-16-tm1w" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option value="" data-select2-id="select2-data-18-akok"></option>
                                    <option value="2">Options 1</option>
                                    <option value="3">Options 2</option>
                                    <option value="4">Options 3</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-17-hwkp" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-sm form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                            aria-disabled="false" aria-labelledby="select2-ilat-container"
                                            aria-controls="select2-ilat-container"><span
                                                class="select2-selection__rendered" id="select2-ilat-container"
                                                role="textbox" aria-readonly="true" title="Options"><span
                                                    class="select2-selection__placeholder">Options</span></span><span
                                                class="select2-selection__arrow" role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-9">
                            Identity Key </td>

                        <td data-bs-target="license" class="ps-0">
                            jk076590ygghgh324vd3568 </td>

                        <td>
                            <button data-action="copy"
                                class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                <i class="ki-outline ki-copy fs-2"></i> </button>
                        </td>

                        <td>
                            May 14, 2020 </td>

                        <td>
                            <span class="badge badge-light-success fs-7 fw-semibold">Active</span>
                        </td>

                        <td class="pe-9">
                            <div class="w-100px position-relative">
                                <select class="form-select form-select-sm form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="Options" data-hide-search="true"
                                    data-select2-id="select2-data-19-40k2" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option value="" data-select2-id="select2-data-21-wvcg"></option>
                                    <option value="2">Options 1</option>
                                    <option value="3">Options 2</option>
                                    <option value="4">Options 3</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-20-5d7b" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-sm form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                            aria-disabled="false" aria-labelledby="select2-jwts-container"
                                            aria-controls="select2-jwts-container"><span
                                                class="select2-selection__rendered" id="select2-jwts-container"
                                                role="textbox" aria-readonly="true" title="Options"><span
                                                    class="select2-selection__placeholder">Options</span></span><span
                                                class="select2-selection__arrow" role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-9">
                            Remore Interface </td>

                        <td data-bs-target="license" class="ps-0">
                            hhet6454788gfg555hhh4 </td>

                        <td>
                            <button data-action="copy"
                                class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                <i class="ki-outline ki-copy fs-2"></i> </button>
                        </td>

                        <td>
                            Dec 30, 2019 </td>

                        <td>
                            <span class="badge badge-light-success fs-7 fw-semibold">Active</span>
                        </td>

                        <td class="pe-9">
                            <div class="w-100px position-relative">
                                <select class="form-select form-select-sm form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="Options" data-hide-search="true"
                                    data-select2-id="select2-data-22-81c0" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option value="" data-select2-id="select2-data-24-lt3g"></option>
                                    <option value="2">Options 1</option>
                                    <option value="3">Options 2</option>
                                    <option value="4">Options 3</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-23-h46v" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-sm form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                            aria-disabled="false" aria-labelledby="select2-nmkj-container"
                                            aria-controls="select2-nmkj-container"><span
                                                class="select2-selection__rendered" id="select2-nmkj-container"
                                                role="textbox" aria-readonly="true" title="Options"><span
                                                    class="select2-selection__placeholder">Options</span></span><span
                                                class="select2-selection__arrow" role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-9">
                            none set </td>

                        <td data-bs-target="license" class="ps-0">
                            fftt456765gjkkjhi83093985 </td>

                        <td>
                            <button data-action="copy"
                                class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                <i class="ki-outline ki-copy fs-2"></i> </button>
                        </td>

                        <td>
                            Inactive </td>

                        <td>
                            <span class="badge badge-light-danger fs-7 fw-semibold">Active</span>
                        </td>

                        <td class="pe-9">
                            <div class="w-100px position-relative">
                                <select class="form-select form-select-sm form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="Options" data-hide-search="true"
                                    data-select2-id="select2-data-25-k74c" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option value="" data-select2-id="select2-data-27-foo0"></option>
                                    <option value="2">Options 1</option>
                                    <option value="3">Options 2</option>
                                    <option value="4">Options 3</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-26-iclm" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-sm form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                            aria-disabled="false" aria-labelledby="select2-j6n3-container"
                                            aria-controls="select2-j6n3-container"><span
                                                class="select2-selection__rendered" id="select2-j6n3-container"
                                                role="textbox" aria-readonly="true" title="Options"><span
                                                    class="select2-selection__placeholder">Options</span></span><span
                                                class="select2-selection__arrow" role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-9">
                            Test App </td>

                        <td data-bs-target="license" class="ps-0">
                            jk076590ygghgh324vd33 </td>

                        <td>
                            <button data-action="copy"
                                class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light">
                                <i class="ki-outline ki-copy fs-2"></i> </button>
                        </td>

                        <td>
                            Apr 03, 2019 </td>

                        <td>
                            <span class="badge badge-light-success fs-7 fw-semibold">Active</span>
                        </td>

                        <td class="pe-9">
                            <div class="w-100px position-relative">
                                <select class="form-select form-select-sm form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="Options" data-hide-search="true"
                                    data-select2-id="select2-data-28-eqef" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option value="" data-select2-id="select2-data-30-em96"></option>
                                    <option value="2">Options 1</option>
                                    <option value="3">Options 2</option>
                                    <option value="4">Options 3</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-29-hapj" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-sm form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                            aria-disabled="false" aria-labelledby="select2-4pcx-container"
                                            aria-controls="select2-4pcx-container"><span
                                                class="select2-selection__rendered" id="select2-4pcx-container"
                                                role="textbox" aria-readonly="true" title="Options"><span
                                                    class="select2-selection__placeholder">Options</span></span><span
                                                class="select2-selection__arrow" role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('new_password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('ki-eye-slash', 'ki-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('ki-eye', 'ki-eye-slash');
            }
        }
    </script>
@endsection
