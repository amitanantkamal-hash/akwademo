@extends('layouts.app-client')

@section('title')
    {{ __('Plans') }}
    <x-button-links />
@endsection

@section('content')
    <!-- Notifications -->
    <div class="col-12">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- Errors display -->
        @if (session('error'))
            <div role="alert" class="alert alert-danger">{{ session('error') }}</div>
        @endif

    </div>

    @if ($currentPlan)
        <!-- Show Current form actions -->
        @include('plans.info', ['planAttribute' => $planAttribute, 'showLinkToPlans' => false])
    @endif


    <div class="card" id="kt_pricing">
        <!--begin::Card body-->
        <div class="card-body p-lg-17">
            <!--begin::Plans-->
            <div class="d-flex flex-column">
                <!--begin::Heading-->
                <div class="mb-13 text-center">
                    <h1 class="fs-2hx fw-bold mb-5">{{ __('Choose Your Plan') }}</h1>
                </div>

                <div class="nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true">
                    <button class="btn btn-color-gray-600 btn-active btn-active-secondary px-6 py-3 me-2 active"
                        data-kt-plan="month"> {{ __('Monthly') }}</button>
                    <button class="btn btn-color-gray-600 btn-active btn-active-secondary px-6 py-3"
                        data-kt-plan="annual">{{ __('Annual') }}</button>
                </div>

                <!--begin::Mensulaes-->
                <div id="monthly-div" class="row g-10">

                    @foreach ($plans as $plan)
                        @if ($plan['period'] == 1)
                            @if (!(config('settings.forceUserToPay', false) && intval(config('settings.free_pricing_id')) . '' == $plan['id'] . ''))
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="d-flex flex-column w-100 bg-secondary bg-opacity-50 rounded-3 py-15 px-10">
                                        <!--begin::Heading-->
                                        <div class="mb-7 text-center flex-grow-1 d-flex flex-column justify-content-center">
                                            <!--begin::Title-->
                                            <h1 class="text-gray-900 mb-5 fw-bolder">{{ $plan['name'] }}</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-600 fw-semibold mb-5">{{ $plan['description'] }}</div>
                                            <!--end::Description-->
                                            <!--begin::Price-->
                                            <div class="text-center">
                                                <span class="fs-3x fw-bold text-primary">@money($plan['price'], config('settings.site_currency', 'usd'), config('settings.site_do_currency', true))</span>
                                                <span class="fs-7 fw-semibold opacity-50">/
                                                    <span
                                                        data-kt-element="period">{{ $plan['period'] == 1 ? __('m') : __('y') }}</span></span>
                                            </div>
                                            <!--end::Price-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Features-->
                                        <div class="w-100 mb-10">
                                            @if (count($plans))
                                                @foreach (explode(',', $plan['features']) as $feature)
                                                    <div class="d-flex align-items-center mb-5">
                                                        <span
                                                            class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{ __(trim($feature)) }}</span>
                                                        <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!--end::Features-->

                                        <div class="d-flex justify-content-center mb-4">
                                            @if ($currentPlan && $plan['id'] . '' == $currentPlan->id . '')
                                                <a href=""
                                                    class="btn btn-info disabled">{{ __('Current Plan') }}</a>
                                            @else
                                                @if (strlen($plan['stripe_id']) > 2 && config('settings.subscription_processor') == 'Stripe')
                                                    <a href="{{ route('upgrade.plan', $plan['id']) }}"
                                                        class="btn btn-info">{{ __('Switch to') . ' ' . $plan['name'] }}</a>
                                                @endif

                                                @if (
                                                    $plan['price'] > 0 &&
                                                        (config('settings.subscription_processor') == 'Local' || config('settings.subscription_processor') == 'local'))
                                                    <button data-bs-toggle="modal"
                                                        data-target="#paymentModal{{ $plan['id'] }}"
                                                        class="btn btn-info">{{ __('Switch to') . ' ' . $plan['name'] }}</button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="paymentModal{{ $plan['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-danger modal-dialog-centered modal-"
                                                            role="document">
                                                            <div class="modal-content bg-gradient-danger">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        {{ $plan['name'] }}</h5>
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ config('settings.local_transfer_info') }}
                                                                    <br /><br />
                                                                    {{ config('settings.local_transfer_account') }}
                                                                    <hr /><br />
                                                                    {{ __('Plan price ') }}<br />
                                                                    @money($plan['price'], config('settings.site_currency', 'usd'), config('settings.site_do_currency', true)) /
                                                                    {{ $plan['period'] == 1 ? __('m') : __('y') }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
                <!--end::Row-->

                <!--begin::Anuales-->
                <div id="annual-div" class="row g-10" style="display: none;">
                    @foreach ($plans as $plan)
                        @if ($plan['period'] != 1)
                            @if (!(config('settings.forceUserToPay', false) && intval(config('settings.free_pricing_id')) . '' == $plan['id'] . ''))
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="d-flex flex-column w-100 bg-secondary bg-opacity-50 rounded-3 py-15 px-10">
                                        <!--begin::Heading-->
                                        <div class="mb-7 text-center flex-grow-1 d-flex flex-column justify-content-center">
                                            <!--begin::Title-->
                                            <h1 class="text-gray-900 mb-5 fw-bolder">{{ $plan['name'] }}</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-600 fw-semibold mb-5">{{ $plan['description'] }}</div>
                                            <!--end::Description-->
                                            <!--begin::Price-->
                                            <div class="text-center">
                                                <span class="fs-3x fw-bold text-primary">@money($plan['price'], config('settings.site_currency', 'usd'), config('settings.site_do_currency', true))</span>
                                                <span class="fs-7 fw-semibold opacity-50">/
                                                    <span
                                                        data-kt-element="period">{{ $plan['period'] == 1 ? __('m') : __('y') }}</span></span>
                                            </div>
                                            <!--end::Price-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Features-->
                                        <div class="w-100 mb-10">
                                            @if (count($plans))
                                                @foreach (explode(',', $plan['features']) as $feature)
                                                    <div class="d-flex align-items-center mb-5">
                                                        <span
                                                            class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{ __(trim($feature)) }}</span>
                                                        <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!--end::Features-->

                                        <div class="d-flex justify-content-center mb-4">
                                            @if ($currentPlan && $plan['id'] . '' == $currentPlan->id . '')
                                                <a href=""
                                                    class="btn btn-info disabled">{{ __('Current Plan') }}</a>
                                            @else
                                                @if (strlen($plan['stripe_id']) > 2 && config('settings.subscription_processor') == 'Stripe')
                                                    <a href="{{ route('upgrade.plan', $plan['id']) }}"
                                                        class="btn btn-info">{{ __('Switch to') . ' ' . $plan['name'] }}</a>
                                                @endif

                                                @if (
                                                    $plan['price'] > 0 &&
                                                        (config('settings.subscription_processor') == 'Local' || config('settings.subscription_processor') == 'local'))
                                                    <button data-bs-toggle="modal"
                                                        data-target="#paymentModal{{ $plan['id'] }}"
                                                        class="btn btn-info">{{ __('Switch to') . ' ' . $plan['name'] }}</button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="paymentModal{{ $plan['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-danger modal-dialog-centered modal-"
                                                            role="document">
                                                            <div class="modal-content bg-gradient-danger">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        {{ $plan['name'] }}</h5>
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ config('settings.local_transfer_info') }}
                                                                    <br /><br />
                                                                    {{ config('settings.local_transfer_account') }}
                                                                    <hr /><br />
                                                                    {{ __('Plan price ') }}<br />
                                                                    @money($plan['price'], config('settings.site_currency', 'usd'), config('settings.site_do_currency', true)) /
                                                                    {{ $plan['period'] == 1 ? __('m') : __('y') }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
                <!--end::Row-->

            </div>
            <!--end::Plans-->
        </div>
        <!--end::Card body-->
    </div>


    <!-- Stripe Subscription form -->
    <div class="row mt-4" id="stripe-payment-form-holder" style="display: none">
        <div class="col-md-12">
            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('Subscribe to') }} <span id="plan_name">PLAN_NAME</span></h2>
                    </div>
                </div>

                <div class="card-body pt-0">

                    <form action="{{ route('plans.subscribe') }}" method="post" id="stripe-payment-form">
                        @csrf
                        <input name="plan_id" id="plan_id" type="hidden" />
                        <div style="width: 100%;" class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} mb-5">
                            <input name="name" id="name" type="text"
                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Name on card') }}"
                                value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form">
                            <div style="width: 100%;" #stripecardelement id="card-element" class="form-control">

                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors. -->
                            <br />
                            <div class="text-danger" id="card-errors" role="alert">

                            </div>
                        </div>
                        <div class="text-center" id="totalSubmitStripe">
                            <button v-if="totalPrice" type="submit"
                                class="btn btn-info mt-4 paymentbutton">{{ __('Subscribe') }}</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')


    <script type="text/javascript">
        $(".btn-sub-actions").on('click', function() {
            var action = $(this).attr('data-action');

            $('#action').val(action);
            document.getElementById('form-subscription-actions').submit();
        });

        function showLocalPayment(plan_name, plan_id) {
            alert(plan_name);
        }

        var plans = <?php echo json_encode($plans); ?>;
        var user = <?php echo json_encode(auth()->user()); ?>;
        var payment_processor = <?php echo json_encode(config('settings.subscription_processor')); ?>;
    </script>

    @if (config('settings.subscription_processor') == 'Stripe')
        <!-- Stripe -->
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            "use strict";
            var STRIPE_KEY = "{{ config('settings.stripe_key') }}";
            var ENABLE_STRIPE = "{{ config('settings.subscription_processor') == 'Stripe' }}";
            if (ENABLE_STRIPE) {
                js.initStripe(STRIPE_KEY, "stripe-payment-form");
            }

            function validateOrderFormSubmit() {
                return true;
            }

            function showStripeCheckout(plan_id, plan_name) {
                $('#plan_id').val(plan_id);
                $('#plan_name').html(plan_name);
                $('#stripe-payment-form-holder').show();
            }
        </script>
    @else
        @if (!(config('settings.subscription_processor') == 'Local'))
            <!-- Payment Processors JS Modules -->
            @include($subscription_processor . '-subscribe::subscribe')
        @endif
    @endif
    <script>
        $(document).ready(function() {
            const $monthlyDiv = $('#monthly-div');
            const $annualDiv = $('#annual-div');

            $('.nav-group button').on('click', function() {
                const plan = $(this).data('kt-plan');

                if (plan === 'month') {
                    $monthlyDiv.show();
                    $annualDiv.hide();
                } else if (plan === 'annual') {
                    $monthlyDiv.hide();
                    $annualDiv.show();
                }

                $('.nav-group button').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>






@endsection
