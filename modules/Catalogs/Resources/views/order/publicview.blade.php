@extends('layouts.public')

@section('content')
    @php
        // Status texts mapping
        $statusTexts = [
            'order' => 'Pending',
            'accepted' => 'Accepted',
            'preparing' => 'Preparing',
            'ready_to_dispatch' => 'Ready to Dispatch',
            'dispatched' => 'Dispatched',
            'delivered' => 'Delivered',
            'canceled' => 'Cancelled',
        ];

        $statusText = $statusTexts[$order->status] ?? ucwords(str_replace('_', ' ', $order->status));

        // Status badge colors
        $statusColors = [
            'order' => 'warning',
            'accepted' => 'primary',
            'preparing' => 'info',
            'ready_to_dispatch' => 'info',
            'dispatched' => 'success',
            'delivered' => 'success',
            'canceled' => 'danger',
        ];

        $statusColor = $statusColors[$order->status] ?? 'secondary';

        // Payment status color
        $paymentColor =
            $order->payment_status === 'Paid'
                ? 'success'
                : ($order->payment_status === 'Pending'
                    ? 'warning'
                    : 'danger');
    @endphp

    <!-- Status Card with Update Option -->
    {{-- <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="card-title mb-2">
                        <i class="bi bi-truck me-2"></i>
                        Order Status
                    </h4>
                    <p class="text-muted mb-0">
                        Current status of your order #{{ $order->reference_id }}
                    </p>

                    <!-- Status Update Form (Only show for specific statuses) -->
                    @if (in_array($order->status, ['order', 'accepted', 'preparing', 'ready_to_dispatch', 'dispatched']) && $order->payment_status == 'Paid')
                        <div class="mt-3">
                            <form id="status-update-form" method="POST"
                                action="{{ route('order.public.update-status', $order->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="token" value="{{ request()->token }}">

                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <select name="status" id="status-select" class="form-select form-select-lg">
                                            @foreach ($statusTexts as $key => $text)
                                                @if (!in_array($key, ['canceled']))
                                                    <option value="{{ $key }}"
                                                        {{ $order->status == $key ? 'selected' : '' }}>
                                                        {{ $text }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2 mt-md-0">
                                        @if ($order->status == 'dispatched')
                                            <button type="button" class="btn btn-success btn-lg w-100"
                                                id="mark-delivered-btn">
                                                <i class="bi bi-check-all me-2"></i>
                                                Mark as Delivered
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                                <i class="bi bi-arrow-clockwise me-2"></i>
                                                Update Status
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-text mt-2">
                                    @if ($order->status == 'dispatched')
                                        <i class="bi bi-info-circle me-1"></i> Your order is out for delivery. Click "Mark
                                        as Delivered" when you receive it.
                                    @elseif($order->status == 'delivered')
                                        <i class="bi bi-check-circle me-1"></i> Order delivered successfully!
                                    @else
                                        <i class="bi bi-info-circle me-1"></i> You can update the order status as it
                                        progresses
                                    @endif
                                </div>
                            </form>
                        </div>
                    @elseif($order->payment_status != 'Paid')
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Payment status is {{ $order->payment_status }}. Please complete payment to update order status.
                        </div>
                    @endif
                </div>
                <div class="col-md-4 text-end mt-3 mt-md-0">
                    <div class="d-flex flex-column align-items-end">
                        <span class="badge bg-{{ $statusColor }} fs-5 py-2 px-4 mb-2">
                            {{ $statusText }}
                        </span>
                        @if ($order->status == 'delivered')
                            <div class="text-muted small">
                                <i class="bi bi-calendar-check me-1"></i>
                                Delivered on {{ \Carbon\Carbon::parse($order->delivery_datetime)->format('d M Y, h:i A') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Confirmation Modal for Mark as Delivered -->
    <div class="modal fade" id="deliveryConfirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <p class="text-center fs-5">Are you sure you have received your order
                        <strong>#{{ $order->reference_id }}</strong>?
                    </p>

                    <div class="mb-3">
                        <label for="delivery-note" class="form-label">Delivery Notes (Optional)</label>
                        <textarea class="form-control" id="delivery-note" rows="3"
                            placeholder="Any notes about the delivery, condition of items, etc..."></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirm-received">
                        <label class="form-check-label" for="confirm-received">
                            I confirm that I have received all items in good condition
                        </label>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Please verify all items are received before confirming delivery.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirm-delivery-btn" disabled>
                        <i class="bi bi-check-all me-2"></i>
                        Confirm Delivery
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-6">
            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Customer Name</div>
                            <div class="fw-bold fs-5">{{ $order->user_name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">WhatsApp Number</div>
                            <div class="fw-bold fs-5 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="#25D366" class="me-2">
                                    <path
                                        d="M12.04 2C6.58 2 2.12 6.46 2.12 11.93c0 2.1.55 4.14 1.6 5.94L2 22l4.28-1.67c1.72.94 3.66 1.44 5.76 1.44h.01c5.46 0 9.92-4.46 9.92-9.93S17.5 2 12.04 2zm5.82 14.33c-.24.67-1.38 1.3-1.91 1.39-.49.09-1.12.12-1.81-.11-.42-.14-.96-.31-1.65-.61-2.91-1.26-4.8-4.18-4.95-4.38-.14-.19-1.18-1.57-1.18-3.01 0-1.44.75-2.15 1.02-2.44.24-.28.64-.41 1.02-.41.12 0 .23.01.33.01.29.01.44.03.64.5.24.58.82 2 .89 2.14.07.14.12.31.02.5-.09.19-.14.31-.28.49-.14.17-.3.38-.43.51-.14.14-.29.29-.13.57.15.29.66 1.09 1.42 1.76 1 .88 1.82 1.16 2.11 1.29.29.14.46.12.63-.07.17-.19.72-.84.91-1.13.19-.29.38-.24.64-.14.26.1 1.67.79 1.95.93.28.14.47.21.54.33.07.14.07.8-.17 1.47z" />
                                </svg>

                                <a href="https://wa.me/{{ $order->phone_number }}" target="_blank">
                                    {{ $order->phone_number }}
                                </a>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Order Date</div>
                            <div class="fw-bold">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Order Number</div>
                            <div class="fw-bold">{{ $order->reference_id }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-geo-alt me-2"></i>
                        Shipping Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small">Shipping Method</div>
                        <div class="fw-bold">{{ $order->shipping_method ?? 'Not specified' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Delivery Address</div>
                        <div class="fw-bold">{{ $order->address ?? 'Not specified' }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Recipient Name</div>
                            <div class="fw-bold">{{ $order->for_person ?? 'Not specified' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Recipient Phone</div>
                            <div class="fw-bold">{{ $order->for_person_number ?? 'Not specified' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">City</div>
                            <div class="fw-bold">{{ $order->city ?? 'Not specified' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Pin Code</div>
                            <div class="fw-bold">{{ $order->pin_code ?? 'Not specified' }}</div>
                        </div>
                    </div>

                    @if ($order->delivery_note)
                        <div class="mt-3 pt-3 border-top">
                            <div class="text-muted small">Delivery Note</div>
                            <div class="fst-italic">"{{ $order->delivery_note }}"</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-credit-card me-2"></i>
                        Payment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Payment Status</div>
                            <div>
                                <span class="badge bg-{{ $paymentColor }}">
                                    {{ $order->payment_status ?? 'Not specified' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Payment Method</div>
                            <div class="fw-bold">{{ $order->transaction_type ?? 'Not specified' }}</div>
                        </div>
                        @if ($order->transaction_id)
                            <div class="col-12 mb-3">
                                <div class="text-muted small">Transaction ID</div>
                                <div class="fw-bold font-monospace">{{ $order->transaction_id }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Enhanced Order Items Section -->
        <div class="col-lg-6">
            <!-- Enhanced Order Items Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-cart me-2"></i>
                            Order Items
                        </h5>
                        <span class="badge bg-primary rounded-pill">
                            {{ count($setup['items']) }} Items
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50%">Product</th>
                                    <th class="text-center" style="width: 15%">Qty</th>
                                    <th class="text-end" style="width: 15%">Price</th>
                                    <th class="text-end" style="width: 20%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($setup['items'] as $index => $item)
                                    @php
                                        // Determine if $item is an array or object
                                        $productName = is_array($item) ? $item['name'] : $item->name;
                                        $itemPrice = is_array($item)
                                            ? $item['amount_value']
                                            : $item->amount_value / 100;
                                        $itemQuantity = is_array($item) ? $item['quantity'] : $item->quantity;
                                        $retailerId = is_array($item) ? $item['retailer_id'] : $item->retailer_id;

                                        // Get product details from CatalogProduct using retailer_id
                                        $productDetails = \App\Models\CatalogProduct::where(
                                            'retailer_id',
                                            $retailerId,
                                        )->first();
                                        $productImage = $productDetails->image_url ?? '';
                                        $productDescription = $productDetails->description ?? '';
                                        $productSku = $productDetails->sku ?? '';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($productImage)
                                                    <div class="symbol symbol-60px me-3 flex-shrink-0">
                                                        <img src="{{ $productImage }}" alt="{{ $productName }}"
                                                            class="rounded"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    </div>
                                                @else
                                                    <div class="symbol symbol-60px symbol-light me-3 flex-shrink-0">
                                                        <span class="symbol-label">
                                                            <i class="bi bi-box-seam fs-3 text-muted"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold mb-1">{{ $productName }}</div>
                                                    @if ($productDescription)
                                                        <div class="text-muted small mb-1">
                                                            {{ Str::limit($productDescription, 50) }}</div>
                                                    @endif
                                                    @if ($productSku)
                                                        <div class="text-muted small">
                                                            <i class="bi bi-tag me-1"></i>SKU: {{ $productSku }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="fw-bold fs-5">{{ $itemQuantity }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="fw-bold">₹{{ number_format($itemPrice, 2) }}</div>
                                            <div class="text-muted small">per item</div>
                                        </td>
                                        <td class="text-end">
                                            <div class="fw-bold fs-5 text-primary">
                                                ₹{{ number_format($itemPrice * $itemQuantity, 2) }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-group-divider">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">Subtotal:</td>
                                    <td class="text-end fw-bold fs-5">
                                        ₹{{ number_format($order->subtotal_value / $order->subtotal_offset, 2) }}
                                    </td>
                                </tr>

                                @if ($order->shipping_cast > 0)
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Shipping Charge:</td>
                                        <td class="text-end fw-bold">
                                            <span class="text-success">+
                                                ₹{{ number_format($order->shipping_cast, 2) }}</span>
                                        </td>
                                    </tr>
                                @endif

                                @if ($order->discount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">
                                            Discount
                                            @if ($order->discount_type == 'percent')
                                                <span class="text-muted small">({{ $order->discount }}%)</span>
                                            @endif:
                                        </td>
                                        <td class="text-end fw-bold">
                                            <span class="text-danger">- ₹{{ number_format($order->discount, 2) }}</span>
                                        </td>
                                    </tr>
                                @endif

                                @if ($order->tax_amount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Tax:</td>
                                        <td class="text-end fw-bold">
                                            + ₹{{ number_format($order->tax_amount, 2) }}
                                        </td>
                                    </tr>
                                @endif

                                <tr class="table-active">
                                    <td colspan="3" class="text-end fw-bold fs-4">Total Amount:</td>
                                    <td class="text-end fw-bold fs-4 text-primary">
                                        ₹{{ number_format($order->final_amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Order Summary Footer -->
                    <div class="p-4 border-top bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="text-muted small">Order Created</div>
                                    <div class="fw-bold">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                @if ($order->updated_at != $order->created_at)
                                    <div class="mb-3">
                                        <div class="text-muted small">Last Updated</div>
                                        <div class="fw-bold">{{ $order->updated_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="text-muted small">Items Count</div>
                                    <div class="fw-bold">{{ count($setup['items']) }} Items</div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-muted small">Payment Status</div>
                                    <div>
                                        <span class="badge bg-{{ $paymentColor }}">
                                            {{ $order->payment_status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Instructions -->
            @if ($order->order_process_note)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-left-text me-2"></i>
                            Special Instructions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <i class="bi bi-quote fs-4 text-muted me-3"></i>
                            <div>
                                <p class="mb-0 fst-italic">"{{ $order->order_process_note }}"</p>
                                <div class="text-muted small mt-2">Customer's special request</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Delivery Information (if delivered) -->
            @if ($order->status == 'delivered')
                <div class="card">
                    <div class="card-header bg-success bg-opacity-10">
                        <h5 class="mb-0 text-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Delivery Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($order->tracking_number)
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Tracking Number</div>
                                    <div class="fw-bold">{{ $order->tracking_number }}</div>
                                </div>
                            @endif
                            @if ($order->delivery_datetime)
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Delivered On</div>
                                    <div class="fw-bold">
                                        {{ \Carbon\Carbon::parse($order->delivery_datetime)->format('d M Y, h:i A') }}
                                    </div>
                                </div>
                            @endif
                            @if ($order->delivery_partner)
                                <div class="col-12">
                                    <div class="text-muted small">Delivery Partner</div>
                                    <div class="fw-bold">{{ $order->delivery_partner }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Cancellation Reason (if canceled) -->
    @if ($order->status == 'canceled' && $order->cancel_reason)
        <div class="card border-danger mt-4">
            <div class="card-header bg-danger bg-opacity-10 text-danger">
                <h5 class="mb-0">
                    <i class="bi bi-x-circle me-2"></i>
                    Cancellation Details
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <i class="bi bi-exclamation-triangle fs-4 text-danger me-3"></i>
                    <div>
                        <div class="fw-bold mb-1">Reason for Cancellation:</div>
                        <p class="mb-0">{{ $order->cancel_reason }}</p>
                        <div class="text-muted small mt-2">
                            Cancelled on {{ $order->updated_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Handle Mark as Delivered button click
            $('#mark-delivered-btn').click(function(e) {
                e.preventDefault();
                $('#deliveryConfirmationModal').modal('show');
            });

            // Enable confirm button when checkbox is checked
            $('#confirm-received').change(function() {
                $('#confirm-delivery-btn').prop('disabled', !this.checked);
            });

            // Handle delivery confirmation
            $('#confirm-delivery-btn').click(function() {
                const deliveryNote = $('#delivery-note').val();
                const orderId = {{ $order->id }};
                const token = "{{ request()->token }}";

                // Show loading
                const $btn = $(this);
                const originalText = $btn.html();
                $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Processing...');
                $btn.prop('disabled', true);

                $.ajax({
                    url: "{{ route('order.public.mark-delivered', $order->id) }}",
                    method: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        token: token,
                        delivery_note: deliveryNote,
                        status: 'delivered'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Delivery Confirmed!',
                                text: response.message ||
                                    'Thank you for confirming delivery!',
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to update status'
                            });
                            $btn.html(originalText).prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message ||
                                'Something went wrong. Please try again.'
                        });
                        $btn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // Handle general status form submission
            $('#status-update-form').submit(function(e) {
                e.preventDefault();

                const form = $(this);
                const status = $('#status-select').val();
                const orderId = {{ $order->id }};

                // Don't submit if status is delivered (use mark delivered button instead)
                if (status === 'delivered') {
                    $('#deliveryConfirmationModal').modal('show');
                    return false;
                }

                // Show confirmation
                const statusTextMap = {
                    'order': 'Pending',
                    'accepted': 'Accepted',
                    'preparing': 'Preparing',
                    'ready_to_dispatch': 'Ready to Dispatch',
                    'dispatched': 'Dispatched'
                };

                Swal.fire({
                    title: 'Update Order Status?',
                    html: `Are you sure you want to change the status to <strong>${statusTextMap[status] || status}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Update',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        const $submitBtn = form.find('button[type="submit"]');
                        const originalBtnText = $submitBtn.html();
                        $submitBtn.html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Updating...'
                        );
                        $submitBtn.prop('disabled', true);

                        $.ajax({
                            url: form.attr('action'),
                            method: form.attr('method'),
                            data: form.serialize(),
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Status Updated!',
                                        text: response.message ||
                                            'Order status updated successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message ||
                                            'Failed to update status'
                                    });
                                    $submitBtn.html(originalBtnText).prop('disabled',
                                        false);
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong'
                                });
                                $submitBtn.html(originalBtnText).prop('disabled',
                                    false);
                            }
                        });
                    }
                });
            });

            // Disable previous statuses in dropdown
            const statusOrder = ['order', 'accepted', 'preparing', 'ready_to_dispatch', 'dispatched', 'delivered'];
            const currentStatus = "{{ $order->status }}";
            const currentIndex = statusOrder.indexOf(currentStatus);

            $('#status-select option').each(function() {
                const optionStatus = $(this).val();
                const optionIndex = statusOrder.indexOf(optionStatus);

                // Disable options that are before current status (can't go backwards)
                if (optionIndex < currentIndex) {
                    $(this).prop('disabled', true);
                    $(this).text($(this).text() + ' (Previous status)');
                }
            });
        });
    </script>
@endsection

@section('css')
    <style>
        /* Enhanced styling for the public view */

        /* Status badge enhancements */
        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000;
        }

        .badge.bg-primary {
            background-color: #0d6efd !important;
        }

        .badge.bg-info {
            background-color: #0dcaf0 !important;
        }

        .badge.bg-success {
            background-color: #198754 !important;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 2px solid #dee2e6;
            padding: 1.25rem 1.5rem;
        }

        /* Table enhancements */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.03);
        }

        .table-hover tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        /* Symbol styling for product images */
        .symbol {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .symbol.symbol-60px {
            width: 60px;
            height: 60px;
        }

        .symbol-light {
            background-color: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .symbol-label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        /* Form enhancements */
        .form-select-lg {
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
            border-radius: 10px;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-select-lg:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Modal enhancements */
        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 2px solid #dee2e6;
            border-radius: 15px 15px 0 0;
        }

        /* Animation for status updates */
        @keyframes statusUpdate {
            0% {
                transform: scale(0.95);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .card-body form {
            animation: statusUpdate 0.3s ease-out;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header h5 {
                font-size: 1.1rem;
            }

            .table-responsive {
                font-size: 0.9rem;
            }

            .symbol.symbol-60px {
                width: 50px;
                height: 50px;
            }

            .btn-lg {
                padding: 0.5rem 1rem;
                font-size: 1rem;
            }

            .form-select-lg {
                font-size: 1rem;
            }

            .badge.fs-5 {
                font-size: 0.9rem !important;
                padding: 0.5rem 1rem;
            }
        }

        /* Print styles */
        @media print {

            .btn,
            .form-select,
            #status-update-form,
            #mark-delivered-btn {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
        }
    </style>
@endsection
