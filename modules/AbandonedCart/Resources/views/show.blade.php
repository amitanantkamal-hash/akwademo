<!-- resources/views/abandoned-cart/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Abandoned Cart Details</h4>
                        <a href="{{ route('abandoned-cart.index') }}" class="btn btn-outline-secondary">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="30%">Name:</th>
                                    <td>{{ $cart->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $cart->customer_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Platform:</th>
                                    <td>
                                        <span class="badge badge-info text-uppercase">{{ $cart->platform }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cart ID:</th>
                                    <td>{{ $cart->cart_id }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Cart Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="30%">Status:</th>
                                    <td>
                                        @if($cart->status === 'active')
                                            <span class="badge badge-warning">Active</span>
                                        @elseif($cart->status === 'recovered')
                                            <span class="badge badge-success">Recovered</span>
                                            <br><small>{{ $cart->recovered_at->format('M j, Y g:i A') }}</small>
                                        @else
                                            <span class="badge badge-secondary">Expired</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Abandoned:</th>
                                    <td>{{ $cart->abandoned_at->format('M j, Y g:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Value:</th>
                                    <td>{{ config('currency.symbol') }}{{ number_format($cart->cart_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Messages Sent:</th>
                                    <td>{{ $cart->messages->where('status', 'sent')->count() }} of {{ $cart->messages->count() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Cart Contents</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $contents = is_string($cart->cart_contents) ? 
                                                        json_decode($cart->cart_contents, true) : 
                                                        $cart->cart_contents;
                                        @endphp
                                        
                                        @foreach($contents as $item)
                                        <tr>
                                            <td>{{ $item['name'] ?? 'Unknown Product' }}</td>
                                            <td>{{ $item['quantity'] ?? 1 }}</td>
                                            <td>{{ config('currency.symbol') }}{{ number_format($item['price'] ?? 0, 2) }}</td>
                                            <td>{{ config('currency.symbol') }}{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="table-primary">
                                            <td colspan="3" class="text-right font-weight-bold">Cart Total:</td>
                                            <td class="font-weight-bold">{{ config('currency.symbol') }}{{ number_format($cart->cart_total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Message History</h5>
                            
                            @if($cart->messages->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Campaign</th>
                                            <th>Scheduled For</th>
                                            <th>Sent At</th>
                                            <th>Status</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart->messages as $message)
                                        <tr>
                                            <td>
                                                @php
                                                    $campaign = \Modules\Wpbox\Models\Campaign::find($message->campaign_id);
                                                @endphp
                                                {{ $campaign->name ?? 'Unknown Campaign' }}
                                            </td>
                                            <td>{{ $message->scheduled_at->format('M j, Y g:i A') }}</td>
                                            <td>
                                                @if($message->sent_at)
                                                    {{ $message->sent_at->format('M j, Y g:i A') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($message->status === 'sent')
                                                    <span class="badge badge-success">Sent</span>
                                                @elseif($message->status === 'scheduled')
                                                    <span class="badge badge-info">Scheduled</span>
                                                @elseif($message->status === 'failed')
                                                    <span class="badge badge-danger">Failed</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($message->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($message->response)
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-toggle="popover" title="API Response" data-content="{{ $message->response }}">
                                                        View Response
                                                    </button>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info">
                                No messages have been sent for this abandoned cart.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        trigger: 'focus',
        placement: 'top'
    });
});
</script>
@endsection