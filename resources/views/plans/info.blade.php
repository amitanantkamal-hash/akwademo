<div class="mb-4 mb-xl-4 d-flex flex-wrap align-items-center">
    <div class="notice d-flex flex-grow-1 bg-light-primary rounded border-primary border p-4 align-items-center">
        <i class="ki-outline ki-credit-cart fs-2tx text-primary me-4"></i>
        <div class="d-flex flex-stack flex-grow-1 ">
            <div class="fw-semibold">
                <h4 class="text-gray-900 fw-bold">
                    {{ __('You are currently using the ') . $planAttribute['plan']['name'] . ' ' . __('plan') }}</h4>
                <div class="fs-7 text-gray-700">{{ $planAttribute['itemsMessage'] }}</div>
            </div>
        </div>
    </div>
</div>
