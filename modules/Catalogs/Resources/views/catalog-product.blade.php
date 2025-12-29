@extends('layouts.app-client', ['title' => __('Product Management')])

@section('content')
    <!--begin::Container-->
    <div class="container-xxl">
        <!--begin::Header-->
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Products</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Manage your product catalog</span>
                </h3>
                <div class="card-toolbar">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary" id="syncCatalogBtn">
                        <i class="ki-duotone ki-reload fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Sync Products
                    </a>
                </div>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-5">
                <!--begin::Search and Filter-->
                <div class="d-flex align-items-center position-relative w-100">
                    <form method="GET" action="{{ route('Catalog.productsCatalog') }}" id="filter-form" class="w-100">
                        <div class="row g-5">
                            <div class="col-md-4">
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text">
                                        <i class="ki-duotone ki-magnifier fs-2 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <input type="text" name="search" class="form-control form-control-solid"
                                        placeholder="Search products..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Filter by category">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ki-duotone ki-filter fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('Catalog.productsCatalog') }}" class="btn btn-light w-100" id="reset-btn">
                                    <i class="ki-duotone ki-reset fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Search and Filter-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_products">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-250px">Product</th>
                                <th class="min-w-150px">Category</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px">Price</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($products as $product)
                                @php
                                    // Get all categories this product belongs to
                                    $productCategories = Modules\Catalogs\Models\ProductCategory::whereRaw(
                                        "FIND_IN_SET('{$product->retailer_id}', retailer_id)",
                                    )->get();
                                @endphp
                                <tr>
                                    <!--begin::Product-->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!--begin::Thumbnail-->
                                            <div class="symbol symbol-50px me-5">
                                                @if ($product->image_url)
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}"
                                                        class="h-100 align-self-center">
                                                @else
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-bag fs-2x text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                @endif
                                            </div>
                                            <!--end::Thumbnail-->

                                            <!--begin::Text-->
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold">{{ $product->product_name }}</span>
                                                <span class="text-muted">{{ Str::limit($product->description, 50) }}</span>
                                                <span class="text-muted fs-8 mt-1">Retailer ID:
                                                    {{ $product->retailer_id }}</span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                    </td>
                                    <!--end::Product-->

                                    <!--begin::Category-->
                                    <td>
                                        @if ($productCategories->count() > 0)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($productCategories as $category)
                                                    <span class="badge badge-light-info">{{ $category->name }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="badge badge-light-dark">Uncategorized</span>
                                        @endif
                                    </td>
                                    <!--end::Category-->

                                    <!--begin::Status-->
                                    <td>
                                        <span class="badge badge-light-success">Active</span>
                                    </td>
                                    <!--end::Status-->

                                    <!--begin::Price-->
                                    <td>
                                        <span class="text-gray-800 fw-bold">{{ $product->price }}</span>
                                    </td>
                                    <!--end::Price-->

                                    <!--begin::Actions-->
                                    <td class="text-end">
                                        {{-- <a href="{{ route('Catalog.productEdit', $product->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" title="View">
                                    <i class="ki-duotone ki-eye fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </a> --}}

                                        <a href="{{ route('Catalog.productEdit', $product->id) }}"
                                            class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm"
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i class="ki-duotone ki-pencil fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                    </td>
                                    <!--end::Actions-->
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->

                <!--begin::Pagination-->
                <div class="d-flex justify-content-between align-items-center flex-wrap mt-5">
                    <div class="text-muted fs-7">
                        Showing <span class="fw-bold">{{ $products->firstItem() }}</span> to
                        <span class="fw-bold">{{ $products->lastItem() }}</span> of
                        <span class="fw-bold">{{ $products->total() }}</span> products
                    </div>
                    <div>
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.getElementById('syncCatalogBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Syncing...',
                text: 'Please wait while we fetch products.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch("{{ route('Catalog.fetchCatalog') }}", {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.status === 'success') {
                        Swal.fire('Success!', data.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.close();
                    Swal.fire('Error!', 'Something went wrong while syncing.', 'error');
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Initialize select2
            $('[data-control="select2"]').select2({
                width: '100%'
            });

            // Reset button functionality
            $('#reset-btn').click(function(e) {
                e.preventDefault();
                window.location.href = "{{ route('Catalog.index') }}";
            });

            // Ensure filter form maintains query parameters
            $('#filter-form').submit(function() {
                // No need for additional handling as form will submit normally
            });
        });
    </script>
@endpush
