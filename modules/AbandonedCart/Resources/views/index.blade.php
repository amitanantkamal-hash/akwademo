<!-- resources/views/abandoned-cart/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Abandoned Carts</h4>
                        <a href="{{ route('abandoned-cart.settings') }}" class="btn btn-outline-primary">
                            Settings
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($carts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Platform</th>
                                    <th>Cart Total</th>
                                    <th>Abandoned</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                <tr>
                                    <td>{{ $cart->customer_name }}</td>
                                    <td>{{ $cart->customer_phone }}</td>
                                    <td>
                                        <span class="badge badge-info text-uppercase">{{ $cart->platform }}</span>
                                    </td>
                                    <td>{{ config('currency.symbol') }}{{ number_format($cart->cart_total, 2) }}</td>
                                    <td>{{ $cart->abandoned_at->diffForHumans() }}</td>
                                    <td>
                                        @if($cart->status === 'active')
                                            <span class="badge badge-warning">Active</span>
                                        @elseif($cart->status === 'recovered')
                                            <span class="badge badge-success">Recovered</span>
                                        @else
                                            <span class="badge badge-secondary">Expired</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('abandoned-cart.show', $cart->id) }}" class="btn btn-sm btn-info">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $carts->links() }}
                    </div>
                    @else
                    <div class="alert alert-info">
                        No abandoned carts found.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection