<div class="row">
    <div class="col-12 col-md-6">
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Profile Details</h3>
                </div>
                <button class="btn btn-sm btn-primary align-self-center">Edit
                    Profile</button>
            </div>
            <div class="card-body p-9">
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">
                        Contact Phone
                        <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active"
                            data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                            <i class="ki-outline ki-information fs-7"></i> </span>
                    </label>

                    <div class="col-lg-8 d-flex align-items-center">
                        @if ($user->phone != null)
                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->phone }}</span>
                        @elseif (isset($user['company']) && $user['company']->phone != null)
                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user['company']->phone }}</span>
                        @else
                            <span class="fw-bold fs-6 text-gray-800 me-2">No phone available</span>
                        @endif
                        {{-- <span class="badge badge-success">Verified</span> --}}
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Email</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">{{ __('Name Company') }}</label>
                    <div class="col-lg-8">
                        @if ($user->phone != null)
                            <span class="fw-bold fs-6 text-gray-800">{{ $user->name_company }}</span>
                        @else
                            <span class="fw-bold fs-6 text-gray-800">{{ __('N/A') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view_edit" style="display: none;">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                data-bs-target="#kt_account_profile_details" aria-expanded="true"
                aria-controls="kt_account_profile_details">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Profile Details</h3>
                </div>
            </div>
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form action="{{ route('account.profile.update', ['id' => $user->id]) }}"
                    class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body border-top p-9" data-select2-id="select2-data-143-k8sy">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                            <div class="col-lg-8">
                                {{-- <div class="image-input image-input-outline" data-kt-image-input="true" style="">
                                    @php
                                        $avatar = 'https://www.gravatar.com/avatar/' . md5(auth()->user()->email);
                                        // Verifica si el avatar de Gravatar existe
                                        $response = @getimagesize($avatar);
                                        if ($response) {
                                            // Si el avatar existe, se utiliza
                                            $avatar = $avatar;
                                        } else {
                                            // Si no existe, se utiliza el avatar por defecto
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
                                    <div class="d-flex flex-row">
                                        <div class="image-input image-input-outline" data-kt-image-input="true"
                                            style="background-image: url('{{ $avatar }}')">
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url('{{ $avatar }}')">
                                            </div>
                                            <label
                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                data-bs-dismiss="click" title="Change image">
                                                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                                        class="path2"></span></i>
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg"
                                                    onchange="previewImage(event)" />
                                                <input type="hidden" name="image_remove" id='image_remove' />
                                            </label>
                                            <span
                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                data-bs-dismiss="click" title="Cancel image" onclick="cancelImage()">
                                                <i class="ki-outline ki-cross fs-3"></i>
                                            </span>
                                            <span
                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                data-bs-dismiss="click" title="Remove image" onclick="removeImage()">
                                                <i class="ki-outline ki-cross fs-3"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="flex-1 mt-1">
                                    @php
                                        if ($user->profile_photo_path != '') {
                                            // Si el avatar existe, se utiliza
                                            $avatar = $user->profile_photo_path;
                                        } else {
                                            // Si no existe, se utiliza el avatar por defecto
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
                                            <input type="hidden" name="avatar_remove" />
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
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            </div>
                            {{-- <div class="d-flex justify-content-center align-items-center mt-4">
                                <div
                                    class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                    <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
                                    <div class="d-flex flex-stack flex-grow-1 ">
                                        <div class=" fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">Gravatar cannot be edited.
                                            </h4>
                                            <div class="fs-6 text-gray-700 "></div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input type="text" name="fname"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="First name" value="{{ $user->name }}">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            if ($user->phone != null) {
                                $phone = $user->phone;
                            } elseif (isset($user['company']) && $user['company']->phone != null) {
                                $phone = $user['company']->phone;
                            } else {
                                $phone = 'No phone available'; // Fallback message if both are null
                            }
                        @endphp
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Phone</span>
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    aria-label="Phone number must be active"
                                    data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i></span> </label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input id="phone_form" type="tel" name="phone"
                                    class="form-control form-control-lg form-control-solid" placeholder="Phone number"
                                    value="{{ $phone }}">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="country_code" name="country_code" value="" />
                        <div class="row mb-6">
                            <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Name company') }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input type="text" name="name_company"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="First name" value="{{ $user->name_company }}">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" id='buttonDiscard'
                            class="btn btn-light btn-active-light-primary me-2">Discard</button>
                        <button type="submit" class="btn btn-info" id="kt_account_profile_details_submit">Save
                            Changes</button>
                    </div>
                    <input type="hidden">
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card mb-5 mb-xl-10" id="kt_profile_billing_view">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Billing Details</h3>
                </div>
                <button class="btn btn-sm btn-primary align-self-center">Edit
                    Billing</button>
            </div>
            <div class="card-body p-9">
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Address</label>
                    <div class="col-lg-8">
                        <span
                            class="fw-bold fs-6 text-gray-800">{{ auth()->user()->company->billing_address ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">City</label>
                    <div class="col-lg-8">
                        <span
                            class="fw-bold fs-6 text-gray-800">{{ auth()->user()->company->billing_city ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">State</label>
                    <div class="col-lg-8">
                        <span
                            class="fw-bold fs-6 text-gray-800">{{ auth()->user()->company->billing_state ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Zip/Pin Code</label>
                    <div class="col-lg-8">
                        <span
                            class="fw-bold fs-6 text-gray-800">{{ auth()->user()->company->billing_zip_code ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-5 mb-xl-10" id="kt_profile_billing_view_edit" style="display: none;">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                data-bs-target="#kt_account_profile_details" aria-expanded="true"
                aria-controls="kt_account_profile_details">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Billing Details</h3>
                </div>
            </div>
            <div id="kt_account_settings_billing_details" class="collapse show">
                <form action="{{ route('account.profile.billing.update') }}"
                    class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body border-top p-9" data-select2-id="select2-data-143-k8sy">
                        <div class="row mb-6">
                            <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Address') }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input type="text" name="billing_address"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="Address"
                                            value="{{ auth()->user()->company->billing_address ?? '' }}">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('City') }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input type="text" name="billing_city"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="City"
                                            value="{{ auth()->user()->company->billing_city ?? '' }}">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('State') }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input type="text" name="billing_state"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="State"
                                            value="{{ auth()->user()->company->billing_state ?? '' }}">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Zip/Pin Code') }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input type="text" name="billing_zip_code"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="Zip/Pin code"
                                            value="{{ auth()->user()->company->billing_zip_code ?? '' }}">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" id='buttonDiscardbilling'
                            class="btn btn-light btn-active-light-primary me-2">Discard</button>
                        <button type="submit" class="btn btn-info" id="kt_account_profile_billing_submit">Save
                            Changes</button>
                    </div>
                    <input type="hidden">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card  mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Sign-in Method</h3>
        </div>
    </div>
    <div id="kt_account_settings_signin_method" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="d-flex flex-wrap align-items-center">
                <div id="kt_signin_email">
                    <div class="fs-6 fw-bold mb-1">Email Address</div>
                    <div class="fw-semibold text-gray-600">{{ $user->email }}</div>
                </div>
                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        @livewire('profile.update-profile-information-form')
                    @endif
                </div>
                <div id="kt_signin_email_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-info">Change Email</button>
                </div>
            </div>
            <div class="separator separator-dashed my-6"></div>
            <div class="d-flex flex-wrap align-items-center mb-10">
                <div id="kt_signin_password">
                    <div class="fs-6 fw-bold mb-1">Password</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>
                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                    @include('profile.update-password-form')
                </div>

                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-info">Reset Password</button>
                </div>
            </div>
            <div class="notice d-flex bg-light-info rounded border-info border border-dashed  p-6">
                <i class="ki-outline ki-shield-tick fs-2tx text-info me-4"></i> <!--end::Icon-->
                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                    <div class="mb-3 mb-md-0 fw-semibold">
                        <h4 class="text-gray-900 fw-bold">Secure Your Account</h4>

                        <div class="fs-6 text-gray-700 pe-7">Two-factor authentication adds an extra layer of
                            security to your account. To log in, in addition you'll need to provide a 6 digit code
                        </div>
                    </div>
                    @php
                        $text = '';
                        if (auth()->user()->two_factor_confirmed_at) {
                            $text = 'Deactivate';
                        } else {
                            $text = 'Enable';
                        }
                    @endphp
                    <a href="#" class="btn btn-info px-6 align-self-center text-nowrap" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_enable_factor">
                        {{ $text }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card  mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_notifications" aria-expanded="true" aria-controls="kt_account_notifications">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Notifications</h3>
        </div>
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_settings_notifications" class="collapse show">
        <!--begin::Form-->
        <form class="form">
            <!--begin::Card body-->
            <div class="card-body border-top px-9 pt-3 pb-4">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-row-dashed border-gray-300 align-middle gy-6">
                        <tbody class="fs-6 fw-semibold">
                            <!--begin::Table row-->
                            <tr>
                                <td class="min-w-250px fs-4 fw-bold">Notifications</td>
                                <td class="w-125px">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="kt_settings_notification_email" checked="" data-kt-check="true"
                                            data-kt-check-target="[data-kt-settings-notification=email]">
                                        <label class="form-check-label ps-2" for="kt_settings_notification_email">
                                            Email
                                        </label>
                                    </div>
                                </td>
                                <td class="w-125px">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="kt_settings_notification_phone" checked="" data-kt-check="true"
                                            data-kt-check-target="[data-kt-settings-notification=phone]">
                                        <label class="form-check-label ps-2" for="kt_settings_notification_phone">
                                            Phone
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->

                            <!--begin::Table row-->
                            <tr>
                                <td>Billing Updates</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="billing1" checked="" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="billing1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="billing2" checked="" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="billing2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->

                            <!--begin::Table row-->
                            <tr>
                                <td>New Team Members</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="team1" checked="" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="team1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="team2" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="team2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->

                            <!--begin::Table row-->
                            <tr>
                                <td>Completed Projects</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="project1" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="project1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="project2" checked="" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="project2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->

                            <!--begin::Table row-->
                            <tr>
                                <td class="border-bottom-0">Newsletters</td>
                                <td class="border-bottom-0">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="newsletter1" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="newsletter1"></label>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="newsletter2" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="newsletter2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button class="btn btn-light btn-active-light-info me-2">Discard</button>
                <button class="btn btn-info  px-6">Save Changes</button>
            </div>
            <!--end::Card footer-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>

<div class="card mb-8">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">
                Browser Sessions</h3>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Content-->
    <div id="kt_account_settings_deactivate" class="collapse show">
        @livewire('profile.logout-other-browser-sessions-form')
    </div>
</div>

<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Delete Account</h3>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Content-->
    <div id="kt_account_settings_deactivate" class="collapse show">
        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            @livewire('profile.delete-user-form')
        @endif
    </div>
</div>
