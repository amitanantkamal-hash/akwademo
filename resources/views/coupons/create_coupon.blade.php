@extends('layouts.app', ['title' => __('Create Coupons')])

@section('content')
    <div class="header  pb-5 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <h2>{{ __('Create a New Coupon') }}</h2>
                <form action="{{ route('admin.create.coupon') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Coupon Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="discount_type" class="form-label">{{ __('Discount Type') }}</label>
                        <select class="form-control form-control-alternative" id="discount_type" name="discount_type"
                            required>
                            <option value="percentage">{{ __('Percentage') }}</option>
                            <option value="fixed">{{ __('Fixed Amount') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="duration_type" class="form-label">{{ __('Discount Duration') }}</label>
                        <select class="form-control form-control-alternative" id="duration_type" name="duration_type"
                            required>
                            <option value="once">{{ __('Once') }}</option>
                            <option value="repeating">{{ __('Repeating') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="duration_in_months" class="form-label">{{ __('Discount Month') }}</label>
                        <input type="number" class="form-control" id="duration_in_months" name="duration_in_months" value ="1" required>
                        <small class="form-text text-muted">{{ __('') }}</small>
                    </div>

                    <div class="mb-3">
                        <label for="discount_value" class="form-label">{{ __('Discount Value') }}</label>
                        <input type="number" class="form-control" id="discount_value" name="discount_value" required>
                    </div>

                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">{{ __('Expiration Date') }}</label>
                        <input type="date" class="form-control" id="expiration_date" name="expiration_date">
                    </div>

                    <div class="mb-3">
                        <label for="usage_limit" class="form-label">{{ __('Usage Limit') }}</label>
                        <input type="number" class="form-control" id="usage_limit" name="usage_limit">
                        <small class="form-text text-muted">{{ __('Leave blank for unlimited usage.') }}</small>
                    </div>

                    <div class="mb-3">
                        <label for="applicable_plan_ids" class="form-label">{{ __('Applicable Plans') }}</label>
                        <select multiple class="form-control form-control-alternative" id="applicable_plan_ids"
                            name="applicable_plan_ids[]">
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->stripe_id }}">{{ $plan->name }}</option>
                            @endforeach
                       
                        </select>
                        <small
                            class="form-text text-muted">{{ __('Hold Ctrl (Windows) or Command (Mac) to select multiple plans.') }}</small>
                    </div>

                    <button type="submit" class="btn btn-info">{{ __('Create Coupon') }}</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endsection
