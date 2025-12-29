{{-- @php
    $tril_message = null;
    $tril_status = 0;
    $currentDate = new DateTime();
    if ($subs_data['active_subscription']->trial_expire_date) {
        $expireDate = new DateTime($subs_data['active_subscription']->trial_expire_date);

        $tril_status = $currentDate <= $expireDate ? 1 : 0;
        $tril_message = $currentDate <= $expireDate ? __('Trial Plan ') : '';
    }
@endphp --}}
{{-- @dd($subs_data) --}}
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

{{-- <div class="d-flex flex-column flex-xl-row">
    <div class="flex-column flex-lg-row-auto w-100">
        <div class="card mb-6">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#"
                                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $tril_message }}{{ $subs_data['active_subscription']->plan->name }}</a>
                                    <a href="#"><i class="ki-outline ki-verify fs-1 text-primary"></i></a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    @if ($tril_status != 0)
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-600 text-hover-primary me-5 mb-2">
                                            <i class="ki-outline ki-dollar fs-4 me-1"></i>{{ __('Trial Expire') }}
                                            :
                                            {{ Carbon\Carbon::parse($subs_data['active_subscription']->trial_expire_date)->format('Y-m-d') }}
                                        </a>
                                    @endif
                                    @php
                                        $formattedExpireDate = null;
                                        if (
                                            isset($subs_data['active_subscription']) &&
                                            $subs_data['active_subscription'] !== null
                                        ) {
                                            if (!empty($subs_data['active_subscription']->expire_date)) {
                                                $formattedExpireDate = Carbon\Carbon::parse(
                                                    $subs_data['active_subscription']->expire_date,
                                                )->format('Y-m-d');
                                            } else {
                                                $formattedExpireDate = __('No expiration date available.');
                                            }
                                        } else {
                                            $formattedExpireDate = __('No active subscription found.');
                                        }
                                    @endphp
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-600 text-hover-primary me-5 mb-2">
                                        <i class="ki-outline ki-dollar fs-4 me-1"></i>{{ __('next_billing') }}
                                        :
                                        {{ $formattedExpireDate }}
                                    </a>
                                    @php
                                        // Initialize a variable to hold the payment method
                                        $paymentMethod = null;
                                        // Check if active_subscription exists and is not null
                                        if (
                                            isset($subs_data['active_subscription']) &&
                                            $subs_data['active_subscription'] !== null
                                        ) {
                                            // Check if payment_method exists
                                            if (isset($subs_data['active_subscription']->payment_method)) {
                                                $paymentMethod = $subs_data['active_subscription']->payment_method;
                                            } else {
                                                $paymentMethod = __('Payment method not available.');
                                            }
                                        } else {
                                            $paymentMethod = __('No active subscription found.');
                                        }
                                    @endphp
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-600 text-hover-primary me-5 mb-2">
                                        <i class="ki-outline ki-wallet fs-4 me-1"></i>{{ __('payment_method') }}
                                        :
                                        {{ $paymentMethod }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="card  mb-5 mb-xl-10">
    <div class="card-body">
        {{-- <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-6">
            <i class="ki-solid ki-information fs-2tx text-warning me-4"><span class="path1"></span><span
                    class="path2"></span><span class="path3"></span></i> <!--end::Icon-->
            <div class="d-flex flex-stack flex-grow-1 ">
                <div class=" fw-semibold">
                    <h4 class="text-gray-900 fw-bold">We need your attention!</h4>
                    <div class="fs-6 text-gray-700 ">Your payment was declined. To start using tools, please <a
                            href="#" class="fw-bold" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_new_card">Add Payment Method</a>.</div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            {{-- {{ $subs_data['active_subscription'] }} --}}
            <div class="col-lg-7">
                <h3 class="mb-2">
                    @php
                        $activeSub = $subs_data['active_subscription'] ?? null;
                        $isNotLifetime = $activeSub && $activeSub->plan->period != 3;
                        $isLifetime = $activeSub && $activeSub->plan->period == 3;
                        $expireDate = $activeSub?->expire_date;
                    @endphp

                    @if ($isNotLifetime)
                        {{ __('Subscription Active until') }}
                        <span>{{ $expireDate ? Carbon\Carbon::parse($expireDate)->format('d-M-Y') : __('N/A') }}</span>
                    @elseif ($signupTrialPlanActive)
                        {{ __('Your trial period ends at') }}
                        {{ Carbon\Carbon::parse($trialExpireDate)->format('d-M-Y') }}
                    @elseif($isLifetime)
                        {{ __('Your subscription is active for a Lifetime') }}
                    @else
                        {{ __('No active subscription found.') }}
                    @endif

                </h3>
                @php
                    $activeSub = $subs_data['active_subscription'] ?? null;
                @endphp

                @if (($activeSub && $activeSub->plan->period != 3) || $signupTrialPlanActive)
                    <p class="fs-6 text-gray-600 fw-semibold mb-6 mb-lg-15">
                        {{ __('We will send you a notification upon Subscription expiration') }}
                    </p>
                @endif

                <div class="fs-5 mb-2">
                    @php
                        $activeSub = $subs_data['active_subscription'] ?? null;
                        $plan = $activeSub?->plan;
                        $price = $activeSub?->price;
                        $period = $plan?->period ?? null;

                        $periodLabel = match ($period) {
                            1 => 'Per Month',
                            2 => 'Per Year',
                            default => __(''),
                        };
                    @endphp

                    @if (!$signupTrialPlanActive)
                        <span class="text-gray-800 fw-bold me-1">
                            {{ __('Price') }}
                            {{ $price ? money($price, config('settings.site_currency', 'usd'), config('settings.site_do_currency', true)) : __('') }}
                        </span>
                    @endif

                    <span class="text-gray-600 fw-semibold">
                        {{ $periodLabel }}
                    </span>

                </div>
                @php
                    $activeSub = $subs_data['active_subscription'] ?? null;
                    $campaignLimit = $activeSub?->campaign_limit;
                @endphp

                <div class="fs-6 text-gray-600 fw-semibold {{ $campaignLimit === 0 ? 'mb-10' : '' }}">
                    @if ($activeSub)
                        @if ($campaignLimit === 0)
                            {{ __('Your plan doesn’t require update.') }}
                        @else
                            {{ __('Extended Pro Package. Unlock unlimited options.') }}
                        @endif
                    @else
                        @if($signupTrialPlanActive)
                            {{ __('Subscribe now to unlock the full power of the application and access all premium features without limitations.') }}
                        @else
                        {{ __('N/A') }}
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex text-muted fw-bold fs-5 mb-3">
                    <span class="flex-grow-1 text-gray-800">Campaings</span>
                    <span class="text-gray-800">
                        <span>
                            {{ $campaing_count }}
                        </span> of <span>
                            @if (isset($subs_data['active_subscription']) && $subs_data['active_subscription'] !== null)


                                @if ($subs_data['active_subscription']->campaign_limit == 0)
                                    {{ __('unlimited') }}
                                @else
                                    {{ $subs_data['active_subscription']->campaign_limit }}
                                @endif
                            @else
                                {{ __('N/A') }}
                                <!-- or any other message indicating the subscription is not available -->

                            @endif
                        </span> Used</span>
                </div>
                <div class="progress h-8px bg-light-primary mb-2">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 2%" aria-valuenow="86"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @if (isset($subs_data['active_subscription']) && $subs_data['active_subscription'] !== null)


                    @if ($subs_data['active_subscription']->campaign_limit == 0)
                        <div class="fs-6 text-gray-600 fw-semibold mb-10">

                            Your plan doesn’t require update, you have unlimited Campaigns.

                        </div>
                    @else
                        <div class="fs-6 text-gray-600 fw-semibold mb-10">

                            Campaigns remaining until your plan requires update:
                            {{ $subs_data['active_subscription']->campaign_limit }}

                        </div>
                    @endif
                @else
                    <div class="fs-6 text-gray-600 fw-semibold mb-10">

                        {{ __('No active subscription found.') }}
                        <!-- or any other message indicating the subscription is not available -->

                    </div>

                @endif


                <div class="d-flex justify-content-end pb-0 px-0">
                    <a href="{{ route('whatsapp.setup') }}" data-toggle="tooltip"
                        class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body fw-bold me-2">
                        {{ __('Whatsapp Cloud API Setup') }}
                    </a>
                    @if (env('ENABLE_PRICING_FOR_CUSTOMER') == true)
                        <a href="{{ route('available.plans') }}" class="btn btn-info">{{ __('Upgrade Plan') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-5 mb-xl-10">
    <div class="card-header card-header-stretch pb-0">
        <div class="card-title">
            <h3 class="m-0">Plan Details</h3>
        </div>
        <div class="card-toolbar m-0">
            <div class="d-flex align-items-center">

            </div>
        </div>
    </div>

    <div id="kt_billing_payment_tab_content" class="card-body tab-content">
        <div id="kt_billing_creditcard" class="tab-pane fade show active" role="tabpanel" "="" aria-labelledby="kt_billing_creditcard_tab">
            <div class="row gx-9 gy-6">
                                  @if (isset($subs_data['active_subscription']) && $subs_data['active_subscription'] !== null)
            <div class="col-sm-6 col-lg-4 col-xl-3" data-kt-billing-element="card">
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-4 fw-bold mb-5 text-gray-500">
                            <i class="ki-solid ki-wallet fs-1 me-2 text-dark">
                            </i>
                            {{ __('price') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-bold ms-4 text-capitalize">
                                {{-- ${{ $subs_data['active_subscription']->price  __('N/A') }} --}}
                                @if ($subs_data['active_subscription']->price)
                                    @money($subs_data['active_subscription']->price, config('settings.site_currency', 'usd'), config('settings.site_do_currency', true))
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3" data-kt-billing-element="card">
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-4 fw-bold mb-5 text-gray-500">
                            <i class="ki-solid ki-people fs-1 me-2  text-dark">
                            </i>
                            {{ __('team_limit') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-bold ms-4 text-capitalize">
                                {{ $subs_data['active_subscription']->team_limit === 0 ? __('unlimited') : $subs_data['active_subscription']->team_limit }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3" data-kt-billing-element="card">
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-4 fw-bold mb-5 text-gray-500">
                            <i class="ki-solid ki-add-notepad fs-1 me-2 text-primary">
                            </i>
                            {{ __('campaign_limit') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-bold ms-4 text-capitalize">
                                {{ $subs_data['active_subscription']->campaign_limit === 0 ? __('unlimited') : $subs_data['active_subscription']->campaign_limit }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3" data-kt-billing-element="card">
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-4 fw-bold mb-5 text-gray-500">
                            <i class="ki-solid ki-badge fs-1 me-2  text-dark">
                            </i>
                            {{ __('contact_limit') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-bold ms-4 text-capitalize">
                                {{ @$subs_data['active_subscription']->contact_limit === 0 ? __('unlimited') : @$subs_data['active_subscription']->contact_limit }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3" data-kt-billing-element="card">
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-4 fw-bold mb-5 text-gray-500">
                            <i class="ki-solid ki-messages fs-1 me-2  text-dark">
                            </i>
                            {{ __('conversation_limit') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-bold ms-4 text-capitalize">
                                {{ $subs_data['active_subscription']->conversation_remaining === 0 ? __('unlimited') : $subs_data['active_subscription']->conversation_remaining }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3" data-kt-billing-element="card">
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-4 fw-bold mb-5 text-gray-500">
                            <i class="ki-solid ki-technology-2 fs-1 me-2 text-primary">
                            </i>
                            {{ __('max_flow_builder') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-bold ms-4 text-capitalize">
                                {{ $subs_data['active_subscription']->max_flow_builder === 0 ? __('unlimited') : $subs_data['active_subscription']->max_flow_builder ?? __('N/A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3" data-kt-billing-element="card">
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-4 fw-bold mb-5 text-gray-500">
                            <i class="ki-solid ki-abstract-26 fs-1 me-2 text-dark">
                            </i>
                            {{ __('max_bot_reply') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-3 fw-bold ms-4 text-capitalize">
                                {{ $subs_data['active_subscription']->max_bot_reply === 0 ? __('unlimited') : $subs_data['active_subscription']->max_bot_reply ?? __('N/A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div>No Active Subscription.</div>
            @endif

        </div>
    </div>
</div>
</div>
@if (!$subs_data['active_subscription'] == null)
    <div class="card ">
        <div class="card-header card-header-stretch border-bottom border-gray-200">
            <div class="card-title">
                <h3 class="fw-bold m-0">{{ __('Billing History') }}</h3>
            </div>
            <div class="card-toolbar m-0">
                <ul class="nav nav-stretch nav-line-tabs border-transparent" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_billing_alltime_tab" class="nav-link fs-5 fw-semibold" data-bs-toggle="tab"
                            role="tab" href="#kt_billing_all">
                            {{ __('All Time') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @php
            $show = true;
            if (isset($subs_data['billingHistory']['error']) && $subs_data['billingHistory']['error']) {
                $show = false;
            }
        @endphp
        <div class="tab-content">
            <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                aria-labelledby="kt_billing_months">
                <div class="table-responsive">
                    <table class="table table-row-bordered align-middle gy-4 gs-9">
                        <thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bold bg-light bg-opacity-75">
                            <tr>
                                <td class="min-w-150px">{{ __('Date') }}</td>
                                <td class="min-w-250px">{{ __('Description') }}</td>
                                <td class="min-w-150px">{{ __('Amount') }}</td>
                                <td class="min-w-150px">{{ __('Invoice') }}</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @if ($show)
                                @forelse ($subs_data['billingHistory'] as $invoice)
                                    <tr>
                                        <td>{{ $invoice['date'] }}</td>
                                        <td><a href="#">{{ $invoice['description'] }}</a></td>
                                        <td>{{ $invoice['amount'] }}</td>
                                        <td><a href="{{ $invoice['invoice_pdf'] }}"
                                                class="btn btn-sm btn-light btn-active-light-primary">PDF</a>
                                        </td>
                                        <td class="text-right"><a href="{{ $invoice['invoice_pdf'] }}"
                                                target="_blank"
                                                class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Empty.</td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="5">Empty.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="card mt-8">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Cancel Plan Subscription</h3>
        </div>
    </div>
    <div id="kt_account_settings_deactivate" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                <i class="ki-outline ki-information fs-2tx text-warning me-4"></i> <!--end::Icon-->
                <div class="d-flex flex-stack flex-grow-1 ">
                    <div class=" fw-semibold">
                        <h4 class="text-gray-900 fw-bold">You Are Cancel Your Plan Subscription</h4>
                        <div class="fs-6 text-gray-700 ">You will not be able to access the most important
                            functions of the application by doing this.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            @if (isset($subs_data['active_subscription']) && $subs_data['active_subscription'] !== null)


                @if ($subs_data['active_subscription']->status == 1 && $subs_data['active_subscription']->payment_method == 'stripe')
                    <a href="javascript:void(0)"
                        onclick="delete_row('{{ route('cancel.subscription', $subs_data['active_subscription']->id) }}')"
                        data-toggle="tooltip" class="btn btn-danger btn-active-light-danger me-2">

                        {{ __('cancel_subscription') }}

                    </a>
                @endif
                @if ($subs_data['active_subscription']->status == 1 && $subs_data['active_subscription']->payment_method == 'razor_pay')
                    <a href="javascript:void(0)"
                        onclick="delete_row('{{ route('cancel.subscription', $subs_data['active_subscription']->id) }}')"
                        data-toggle="tooltip" class="btn btn-danger btn-active-light-danger me-2">

                        {{ __('cancel_subscription') }}

                    </a>
                @endif
            @else
                <!-- Optionally, you can display a message if there is no active subscription -->

                <div class="alert alert-warning">

                    {{ __('No active subscription found.') }} <!-- or any other message you prefer -->

                </div>

            @endif
        </div>
    </div>
</div>
