<div class="card-body pt-9 pb-0">
    @php
        if ($user->profile_photo_path != '') {
            // Si el avatar existe, se utiliza
            $avatar = $user->profile_photo_path;
        } else {
            // Si no existe, se utiliza el avatar por defecto
            $avatar = asset('Metronic/assets/media/avatars/blank.png');
        }
    @endphp
    <div class="d-flex align-items-center mb-2">
        <a class="fs-4 fw-semibold ">
            Account Settings
        </a>
    </div>
    <div class="d-flex flex-wrap flex-sm-nowrap">
        <div class="me-7 mb-4">
            <div class="symbol symbol-750px symbol-lg-100px symbol-fixed position-relative">
                <img src="{{ $avatar }}" alt="user">
                <div
                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-info rounded-circle border border-4 border-body h-20px w-20px">
                </div>
            </div>
        </div>
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <a href="#"
                            class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ auth()->user()->name }}</a>
                        <a href="#"><i class="ki-solid ki-verify fs-1 text-primary"></i></a>
                    </div>
                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                            <i class="ki-duotone ki-sms fs-4 me-2"><span class="path1"></span><span
                                    class="path2"></span></i> {{ auth()->user()->email }}
                        </a>
                        @php
                            if ($user->phone != null) {
                                $phone = $user->phone;
                            } elseif (isset($user['company']) && $user['company']->phone != null) {
                                $phone = $user['company']->phone;
                            } else {
                                $phone = 'No phone available'; // Fallback message if both are null
                            }
                        @endphp
                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                            <i class="ki-duotone ki-phone fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ $phone }}
                        </a>
                        <style>
                            #miflag .iti__arrow {
                                display: none !important;
                            }

                            #miflag .iti__flag {
                                margin-top: -14px;
                            }
                        </style>
                        <a href="#" class="d-flex align-items-start text-gray-500 text-hover-primary"
                            id="miflag">
                            <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span
                                    class="path2"></span></i>
                            <div>
                                <input id="phone-flag" value="{{ $phone }}" style="display: none;" disabled />
                                <div id="flag">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- <div class="d-flex my-4">
                    <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                        <i class="ki-duotone ki-check fs-3 d-none"></i>
                        <span class="indicator-label">
                            Follow</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </a>
                    <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_offer_a_deal">Hire Me</a>
                    <div class="me-0">
                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-solid ki-dots-horizontal fs-2x"></i> </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                    Payments
                                </div>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Create Invoice
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link flex-stack px-3">
                                    Create Payment
                                    <span class="ms-2" data-bs-toggle="tooltip"
                                        aria-label="Specify a target name for future usage and reference"
                                        data-bs-original-title="Specify a target name for future usage and reference"
                                        data-kt-initialized="1">
                                        <i class="ki-duotone ki-information fs-6"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span></i> </span>
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Generate Bill
                                </a>
                            </div>
                            <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                                <a href="#" class="menu-link px-3">
                                    <span class="menu-title">Subscription</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            Plans
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            Billing
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            Statements
                                        </a>
                                    </div>
                                    <div class="separator my-2"></div>
                                    <div class="menu-item px-3">
                                        <div class="menu-content px-3">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input w-30px h-20px" type="checkbox"
                                                    value="1" checked="checked" name="notifications">
                                                <span class="form-check-label text-muted fs-6">
                                                    Recuring
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-item px-3 my-1">
                                <a href="#" class="menu-link px-3">
                                    Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            @php
                $tril_message = null;
                $tril_status = 0;
                $signupTrialPlanActive = false;
                $currentDate = new DateTime();
                $trialExpireDate = null;
                // Check if active_subscription exists and is not null
                if (isset($subs_data['active_subscription']) && $subs_data['active_subscription'] !== null) {
                    if ($subs_data['active_subscription']->trial_expire_date) {
                        $expireDate = new DateTime($subs_data['active_subscription']->trial_expire_date);
                        $tril_status = $currentDate <= $expireDate ? 1 : 0;
                        $tril_message = $currentDate <= $expireDate ? __('Trial Plan ') : '';
                    }
                } else {
                    // Handle the case where there is no active subscription
                    $tril_message = __('No active subscription.');
                    $user = auth()->user();

                    $currentPlanID = $user->plan_id;
                    $freePlanID = config('settings.free_pricing_id');

                    if ($currentPlanID == $freePlanID) {
                        $tril_status = 1;
                        $trialExpireDate = new DateTime($user->trial_ends_at);
                        $tril_message = __('Trial Plan ');
                        $signupTrialPlanActive = true;
                    }
                }
            @endphp
            @if (auth()->user()->hasrole(['owner']))
                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-middle">
                                    <i class="ki-solid ki-verify fs-2 me-2 text-dark"></i>
                                    <div class="fw-semibold fs-6 text-gray-500">Plan</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="fs-5 fw-bold" data-kt-countup="true" data-kt-countup-value="4500"
                                        data-kt-countup-prefix="$" data-kt-initialized="1">
                                        {{ $tril_message }}
                                        @if (isset($subs_data['active_subscription']) && $subs_data['active_subscription'])
                                            {{ $subs_data['active_subscription']->plan->name }}
                                        @else
                                            @if ($tril_status != 1)
                                                No active.
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php
                                $activeSub = $subs_data['active_subscription'] ?? null;
                                $isNotLifetime = $activeSub && $activeSub->plan->period != 3;
                                $showTrial = !$activeSub && $signupTrialPlanActive;

                                $sections = [];

                                if ($isNotLifetime) {
                                    $sections[] = [
                                        'icon' => 'ki-cheque',
                                        'label' => __('Next Billing Date'),
                                        'value' => Carbon\Carbon::parse($activeSub->expire_date)->format('d-M-Y'),
                                    ];
                                }

                                if ($showTrial) {
                                    $sections[] = [
                                        'icon' => 'ki-cheque',
                                        'label' => __('Trial Expiry'),
                                        'value' => Carbon\Carbon::parse($trialExpireDate)->format('d-M-Y'),
                                    ];
                                }

                                if ($activeSub && $activeSub->trial_expire_date < 0) {
                                    $sections[] = [
                                        'icon' => 'ki-dollar',
                                        'label' => __('Trial Expired'),
                                        'value' => Carbon\Carbon::parse($activeSub->trial_expire_date)->format('Y-m-d'),
                                        'prefix' => '%',
                                    ];
                                }
                            @endphp

                            @foreach ($sections as $section)
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-middle">
                                        <i class="ki-solid {{ $section['icon'] }} fs-2 me-2 text-dark"></i>
                                        <div class="fw-semibold fs-6 text-gray-500">{{ $section['label'] }}</div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fs-5 fw-bold counted" data-kt-countup="true"
                                            data-kt-countup-value="80"
                                            data-kt-countup-prefix="{{ $section['prefix'] ?? '' }}"
                                            data-kt-initialized="1">
                                            {{ $section['value'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    @php
                        $progressbar = 0;
                        if ($user->name != null) {
                            $progressbar = $progressbar + 20;
                        }
                        if ($user->name_company != null) {
                            $progressbar = $progressbar + 20;
                        }
                        if ($user->phone != null) {
                            $progressbar = $progressbar + 20;
                        }
                        if ($user->email != null) {
                            $progressbar = $progressbar + 20;
                        }
                        if (auth()->user()->two_factor_confirmed_at) {
                            $progressbar = $progressbar + 20;
                        }
                    @endphp
                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-semibold fs-6 text-gray-500">Profile Compleation</span>
                            <span class="fw-bold fs-6">{{ $progressbar }}%</span>
                        </div>
                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                            <div class="bg-success rounded h-5px" role="progressbar"
                                style="width: {{ $progressbar }}%;" aria-valuenow="{{ $progressbar }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            @endif
            @if (auth()->user()->hasrole(['staff']))
                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-middle">
                                    <i class="ki-solid ki-verify fs-2 text-dark me-1">
                                    </i>
                                    <span class="fw-semibold fs-6 text-gray-500">Account Type</span>
                                </div>
                                <div class="d-flex align-items-center">

                                    <div class="fs-5 fw-bold" data-kt-countup="true" data-kt-countup-value="4500"
                                        data-kt-countup-prefix="$" data-kt-initialized="1">
                                        {{ __('Agent') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (auth()->user()->hasrole(['admin']))
                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-middle">
                                    <i class="ki-solid ki-verify fs-2 text-dark me-1">
                                    </i>
                                    <span class="fw-semibold fs-6 text-gray-500">Account Type</span>
                                </div>
                                <div class="d-flex align-items-center">

                                    <div class="fs-5 fw-bold" data-kt-countup="true" data-kt-countup-value="4500"
                                        data-kt-countup-prefix="$" data-kt-initialized="1">
                                        {{ __('Admin') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="d-flex flex-wrap flex-sm-nowrap">
    </div>
    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
        <li class="nav-item mt-2">
            @if (auth()->user()->hasrole(['staff']) ||
                    auth()->user()->hasrole(['admin']))
                <a class="nav-link text-active-info ms-0 me-10 py-5 @if (Route::currentRouteName() == 'profile.show') active @endif"
                    href="{{ route('profile.show') }}">
                    Overview</a>
            @endif
            @if (auth()->user()->hasrole(['owner']))
                <a class="nav-link text-active-info ms-0 me-10 py-5 @if (Route::currentRouteName() == 'account.profile.show') active @endif"
                    href="{{ route('account.profile.show') }}">
                    Overview</a>
            @endif
        </li>
        @if (auth()->user()->hasrole(['owner']))
            <li class="nav-item mt-2">
                <a class="nav-link text-active-info ms-0 me-10 py-5 @if (Route::currentRouteName() == 'account.profile.billing') active @endif"
                    href="{{ route('account.profile.billing') }}">
                    Subscription </a>
            </li>
            {{-- <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @if (Route::currentRouteName() == 'referrals.index') active @endif"
                    href="{{ route('referrals.index') }}">
                    Referrals </a>
            </li> --}}
            <li class="nav-item mt-2">
                <a class="nav-link text-active-info ms-0 me-10 py-5 @if (Route::currentRouteName() == 'account.profile.api') active @endif"
                    href="{{ route('account.profile.api') }}">
                    Api Keys </a>
            </li>
        @endif
        {{-- <li class="nav-item mt-2">
            <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                href="/metronic8/demo38/pages/user-profile/followers.html">
                Logs</a>
        </li> --}}
    </ul>
</div>
