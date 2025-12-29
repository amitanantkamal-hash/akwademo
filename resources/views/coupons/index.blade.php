@extends('layouts.app', ['title' => __('Pages')])

@section('content')
    <div class="header pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <h1 class="mb-3 mt--3">🎟️ {{ __('coupons_manager') }}</h1>
                <div class="row align-items-center pt-2">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">

                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('admin.add.coupons') }}"
                                    class="btn btn-sm btn-primary">{{ __('Add coupon') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @include('partials.flash')
                    </div>
                    @if (count($coupons))
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Discount Type') }}</th>
                                        <th scope="col">{{ __('Discount Duration') }}</th>
                                        <th scope="col">{{ __('Discount Value') }}</th>
                                        <th scope="col">{{ __('Expiration Date') }}</th>
                                        <th scope="col">{{ __('Usage Limit') }}</th>
                                        <th scope="col">{{ __('Usage Count') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon->name }}</td>
                                            <td>{{ ucfirst($coupon->discount_type) }}</td>
                                            <td>{{ ucfirst($coupon->duration_in_months) }} / {{ ucfirst($coupon->duration_type) }}</td>
                                            <td>{{ $coupon->discount_type === 'percentage' ? $coupon->discount_value . '%' : '$' . $coupon->discount_value }}
                                            </td>
                                            <td>{{ $coupon->expiration_date ? $coupon->expiration_date->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td>{{ $coupon->usage_limit ?? 'Unlimited' }}</td>
                                            <td>{{ $coupon->usage_count ?? 0 }}</td>
                                            <td>
                                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="card-footer py-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
