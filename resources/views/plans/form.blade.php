@include('partials.input', [
    'name' => 'Name',
    'id' => 'name',
    'placeholder' => 'Plan name',
    'required' => true,
    'value' => isset($plan) ? $plan->name : null,
])
<div class="row">
    <div class="col-md-12">
        @include('partials.input', [
            'name' => 'Plan description',
            'id' => 'description',
            'placeholder' => 'Plan description...',
            'required' => false,
            'value' => isset($plan) ? $plan->description : null,
        ])
    </div>
    <div class="col-md-12">
        @include('partials.input', [
            'name' => 'Features list (separate features with comma)',
            'id' => 'features',
            'placeholder' => 'Plan Features comma separated...',
            'required' => false,
            'value' => isset($plan) ? $plan->features : null,
        ])
    </div>
</div>

@include('partials.input', [
    'type' => 'number',
    'name' => 'Price',
    'id' => 'price',
    'placeholder' => 'Plan prce',
    'required' => true,
    'value' => isset($plan) ? $plan->price : null,
])

@if (config('settings.enable_credits'))
    <div style="width: 50%;">
        @include('partials.input',['class'=>'','additionalInfo'=>'Number of credits that will be added to the user\'s account when they subscribe to this plan, on the interval selected below','type'=>'number','name'=>'Credit amount','id'=>"credit_amount",'placeholder'=>"Plan credit amount",'required'=>true,'value'=>(isset($plan)?$plan->credit_amount:null)])
    </div>
@endif

<div class="row">
    <!-- THIS IS SPECIAL -->
    <div class="col-md-6">
        <label class="form-control-label">{{ __('Plan period') }}</label>
        <div class="custom-control custom-radio mb-3">
            <input name="period" class="custom-control-input" id="monthly"
            @if (isset($plan)) @if ($plan->period == 1) checked @endif @else checked
                @endif value="monthly" type="radio">
            <label class="custom-control-label" for="monthly">{{ __('Monthly') }}</label>
        </div>
        <div class="custom-control custom-radio mb-3">
            <input name="period" class="custom-control-input" id="anually" value="anually"
                @if (isset($plan) && $plan->period == 2) checked @endif type="radio">
            <label class="custom-control-label" for="anually">{{ __('Anually') }}</label>
        </div>
        <div class="custom-control custom-radio mb-3">
            <input name="period" class="custom-control-input" id="lifetime" value="lifetime"
                @if (isset($plan) && $plan->period == 3) checked @endif type="radio">
            <label class="custom-control-label" for="lifetime">{{ __('Lifetime') }}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- THIS IS SPECIAL -->
    <div class="col-md-6">
        <label class="form-control-label">{{ __('Plan status') }}</label>
        <div class="custom-control custom-radio mb-3">
            <input name="plan_status" class="custom-control-input" id="active"
            @if (isset($plan)) @if ($plan->status == 1) checked @endif @else checked
                @endif value="1" type="radio">
            <label class="custom-control-label" for="active">{{ __('active') }}</label>
        </div>
        <div class="custom-control custom-radio mb-3">
            <input name="plan_status" class="custom-control-input" id="inactive" value="0"
                @if (isset($plan) && $plan->status == 0) checked @endif type="radio">
            <label class="custom-control-label" for="inactive">{{ __('inactive') }}</label>
        </div>
    </div>
</div>
<div class="row">
    <!-- THIS IS SPECIAL -->
    <div class="col-md-6">
        <label class="form-control-label">{{ __('plan_trial') }}</label>
        <div class="custom-control custom-radio mb-3">
            <input name="trial_status" class="custom-control-input" id="trial_active"
            @if (isset($plan)) @if ($plan->trial_status == 1) checked @endif @else checked
                @endif value="1" type="radio">
            <label class="custom-control-label" for="trial_active">{{ __('active') }}</label>
        </div>
        <div class="custom-control custom-radio mb-3">
            <input name="trial_status" class="custom-control-input" id="trial_inactive" value="0"
                @if (isset($plan) && $plan->trial_status == 0) checked @endif type="radio">
            <label class="custom-control-label" for="trial_inactive">{{ __('inactive') }}</label>
        </div>
    </div>
    <div class="col-md-12">
        @include('partials.input', [
            'type' => 'number',
            'name' => __('Trial Days'),
            'id' => 'trial_days',
            'placeholder' => __('Plan trial days should be greater than 2 days'),
            'additionalInfo' => __('Plan trial days should be greater than 2 days'),
            'required' => false,
            'value' => isset($plan) ? $plan->trial_days : null,
        ])
    </div>
</div>

<div class="row">
    <div class="col-12 mt-4">
        <h6 class="heading text-muted mb-4">{{ __('Payment processor') }}</h6>
    </div>
    @if (config('settings.subscription_processor', 'Stripe') == 'Stripe')
        <div class="col-md-6">
            @include('partials.input', [
                'name' => 'Stripe Pricing Plan ID',
                'id' => 'stripe_id',
                'placeholder' => 'Product price plan id from Stripe starting with price_xxxxxx',
                'required' => false,
                'value' => isset($plan) ? $plan->stripe_id : null,
            ])
        </div>
    @else
        @if (strtolower(config('settings.subscription_processor')) != 'local')
            @include($theSelectedProcessor . '-subscribe::planid')
        @endif
    @endif
</div>

<div class="row">

    <div class="col-12 mt-4">
        <h6 class="heading text-muted mb-4">{{ __('Plan limits') }}</h6>
    </div>
    @if (config('settings.limit_items_show', true))
        <div class="col-md-6">
            @include('partials.input', [
                'type' => 'number',
                'name' => config('settings.limit_items_name', 'Limit items'),
                'id' => 'limit_items',
                'placeholder' => 'Number of allowed usage',
                'required' => false,
                'additionalInfo' => '0 is unlimited numbers of usage per plan period',
                'value' => isset($plan) ? $plan->limit_items : null,
            ])
        </div>
    @endif

    @if (config('settings.limit_views_show', false))
        <div class="col-md-6">
            @include('partials.input', [
                'type' => 'number',
                'name' => config('settings.limit_views_name', 'Limit views'),
                'id' => 'limit_views',
                'placeholder' => 'Number of allowed usage',
                'required' => false,
                'additionalInfo' => '0 is unlimited numbers of usage per plan period',
                'value' => isset($plan) ? $plan->limit_views : null,
            ])
        </div>
    @endif

    @if (config('settings.limit_orders_show', false))
        <div class="col-md-6">
            @include('partials.input', [
                'type' => 'number',
                'name' => __('contact_limit'),
                'id' => 'contact_limit',
                'placeholder' => 'Number of allowed usage',
                'required' => false,
                'additionalInfo' => '0 is unlimited numbers of usage per plan period',
                'value' => isset($plan) ? $plan->contact_limit : null,
            ])
        </div>
    @endif

    @if (config('settings.limit_orders_show', false))
        <div class="col-md-6">
            @include('partials.input', [
                'type' => 'number',
                'name' => __('conversation_limit'),
                'id' => 'conversation_limit',
                'placeholder' => 'Number of conversation',
                'required' => false,
                'additionalInfo' => '0 is unlimited numbers of usage per plan period',
                'value' => isset($plan) ? $plan->conversation_limit : null,
            ])
        </div>
    @endif

    @if (config('settings.limit_orders_show', false))
        <div class="col-md-6">
            @include('partials.input', [
                'type' => 'number',
                'name' => __('team_limit'),
                'id' => 'team_limit',
                'placeholder' => 'Number of team members',
                'required' => false,
                'additionalInfo' => '0 is unlimited numbers of usage per plan period',
                'value' => isset($plan) ? $plan->team_limit : null,
            ])
        </div>
    @endif

    @if (config('settings.limit_orders_show', false))
        <div class="col-md-6">
            @include('partials.input', [
                'type' => 'number',
                'name' => __('max_flow_builder'),
                'id' => 'max_flow_builder',
                'placeholder' => 'Number of Flow Builder',
                'required' => false,
                'additionalInfo' => '0 is unlimited numbers of usage per plan period',
                'value' => isset($plan) ? $plan->max_flow_builder : null,
            ])
        </div>
    @endif


    @if (config('settings.limit_orders_show', false))
        <div class="col-md-6">
            @include('partials.input', [
                'type' => 'number',
                'name' => __('max_bot_reply'),
                'id' => 'max_bot_reply',
                'placeholder' => 'Number of Bot Reply',
                'required' => false,
                'additionalInfo' => '0 is unlimited numbers of usage per plan period',
                'value' => isset($plan) ? $plan->max_bot_reply : null,
            ])
        </div>
    @endif

</div>

<input name="ordering" value="enabled" type="hidden" />

@include('plans.plugins')

<div class="text-center">
    <button type="submit" class="btn btn-success mt-4">{{ isset($plan) ? __('Update plan') : __('SAVE') }}</button>
</div>
