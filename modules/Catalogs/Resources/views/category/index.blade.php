@extends('layouts.app-client')

@section('title', __('Categories Management'))

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-abstract-42 fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                    {{ __('Categories Management') }}
                </h1>
                <span class="badge badge-light-primary fs-8 fw-bolder ms-4">{{ $setup['items']->total() }}
                    {{ __('Categories') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                @if ($setup['items']->isNotEmpty())
                    <div class="d-flex align-items-center position-relative">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute start-0 ms-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="table-search" class="form-control form-control-solid w-250px ps-10"
                            placeholder="{{ __('Search categories...') }}">
                    </div>
                @endif

                <a href="{{ route('Catalog.categoryCreate') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-abstract-37 fs-2"></i>
                    {{ __('Add Category') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        @if ($setup['items']->isNotEmpty())
            @php
                $totalProducts = 0;
                $categoriesWithProducts = 0;
                $emptyCategories = 0;

                foreach ($setup['items'] as $category) {
                    $matchedProducts = $setup['products']->filter(function ($product) use ($category) {
                        return $product->category_id == $category->id &&
                            $product->retailer_id == $category->retailer_id;
                    });
                    $productCount = $matchedProducts->count();
                    $totalProducts += $productCount;

                    if ($productCount > 0) {
                        $categoriesWithProducts++;
                    } else {
                        $emptyCategories++;
                    }
                }
            @endphp
            <div class="row g-6 mb-7">
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-dark">{{ $setup['items']->total() }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Categories') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-success">{{ $categoriesWithProducts }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('With Products') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-warning">{{ $emptyCategories }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Empty Categories') }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card card-dashed h-xl-100 flex-center flex-column py-4">
                        <span class="fs-2hx fw-bolder text-info">{{ $totalProducts }}</span>
                        <span class="text-gray-600 fw-semibold">{{ __('Total Products') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Categories Table Card -->
        <div class="card">
            @if ($setup['items']->isNotEmpty())
                <!-- Card Header -->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">{{ __('All Categories') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <span class="text-muted fs-7">
                            {{ __('Showing') }} {{ $setup['items']->firstItem() }} - {{ $setup['items']->lastItem() }}
                            {{ __('of') }} {{ $setup['items']->total() }}
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle fs-6">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">{{ __('Category') }}</th>
                                    {{-- <th class="min-w-200px">{{ __('Products') }}</th> --}}
                                    <th class="min-w-100px text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($setup['items'] as $item)
                                    @php
                                        $matchedProducts = $setup['products']->filter(function ($product) use ($item) {
                                            return $product->category_id == $item->id;
                                        });
                                        $productCount = $matchedProducts->count();
                                    @endphp

                                    <tr data-category-id="{{ $item->id }}" class="category-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-5">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-abstract-46 fs-3 text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bolder fs-6 mb-1">{{ $item->name }}</span>
                                                    {{-- <span class="text-muted fs-7">ID: {{ $item->id }}</span>
                                                    <span class="text-muted fs-8 mt-1">
                                                        <i class="ki-duotone ki-calendar-8 fs-4 me-1"></i>
                                                        {{ $item->created_at->format('M d, Y') }}
                                                    </span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            @if ($productCount > 0)
                                                <div class="d-flex flex-column">
                                                    <span class="badge badge-light-success mb-2">
                                                        {{ $productCount }} {{ __('Products') }}
                                                    </span>
                                                    <div class="products-preview">
                                                        @foreach ($matchedProducts->take(3) as $product)
                                                            <span class="badge badge-light-info fs-8 me-1 mb-1">
                                                                {{ Str::limit($product->product_name, 20) }}
                                                            </span>
                                                        @endforeach
                                                        @if ($productCount > 3)
                                                            <span class="badge badge-light-warning fs-8">
                                                                +{{ $productCount - 3 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge badge-light-danger">
                                                    <i class="ki-duotone ki-cross-circle fs-4 me-1"></i>
                                                    {{ __('No Products') }}
                                                </span>
                                            @endif
                                        </td> --}}
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <!-- Edit Button -->
                                                <a href="{{ route('Catalog.categoryEdit', $item->id) }}"
                                                    class="btn btn-icon btn-light-primary btn-sm"
                                                    title="{{ __('Edit Category') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-pencil fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>

                                                <!-- View Products Button -->
                                                @if ($productCount > 0)
                                                    <button type="button"
                                                        class="btn btn-icon btn-light-info btn-sm view-products-btn"
                                                        data-category-id="{{ $item->id }}"
                                                        data-category-name="{{ $item->name }}"
                                                        data-products='@json(
                                                            $matchedProducts->take(5)->map(function ($p) {
                                                                return $p->product_name;
                                                            }))'
                                                        title="{{ __('View Products') }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                        <i class="ki-duotone ki-eye fs-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </button>
                                                @endif

                                                <!-- Delete Button -->
                                                <button type="button"
                                                    class="btn btn-icon btn-light-danger btn-sm delete-category-btn"
                                                    data-category-id="{{ $item->id }}"
                                                    data-category-name="{{ $item->name }}"
                                                    title="{{ __('Delete Category') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ki-duotone ki-trash fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($setup['items']->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <span class="text-muted fs-7">
                                {{ __('Showing') }}
                                <strong>{{ $setup['items']->firstItem() ?? 0 }}</strong>
                                {{ __('to') }}
                                <strong>{{ $setup['items']->lastItem() ?? 0 }}</strong>
                                {{ __('of') }}
                                <strong>{{ $setup['items']->total() }}</strong>
                                {{ __('entries') }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap py-2">
                            {{ $setup['items']->links() }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="card-body">
                    <div class="text-center py-10">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <!-- Icon -->
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-abstract-42 fs-2hx text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-dark fw-bolder mb-3">{{ __('No Categories Found') }}</h3>
                            <p class="text-muted fs-5 mb-6 w-lg-400px">
                                {{ __('You haven\'t created any categories yet. Categories help you organize your products and make them easier to find.') }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3">
                                <a href="{{ route('Catalog.categoryCreate') }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-abstract-37 fs-2"></i>
                                    {{ __('Create Your First Category') }}
                                </a>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#helpModal">
                                    <i class="ki-duotone ki-information fs-2"></i>
                                    {{ __('Learn More') }}
                                </a>
                            </div>

                            <!-- Additional Help -->
                            <div class="mt-10">
                                <div class="d-flex align-items-center text-muted fs-7">
                                    <i class="ki-duotone ki-information fs-3 me-2"></i>
                                    {{ __('Categories help customers browse your products efficiently and improve their shopping experience.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Products Modal -->
    <div class="modal fade" id="productsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="productsModalTitle">{{ __('Category Products') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="productsList" class="d-flex flex-column gap-2">
                        <!-- Products will be populated here by JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ __('About Categories') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <h4 class="text-dark mb-3">{{ __('Why use categories?') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Organize products logically') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Improve customer navigation') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Enhance search and filtering') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span>{{ __('Streamline inventory management') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-dark mb-3">{{ __('Category Status') }}</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-success me-3">{{ __('With Products') }}</span>
                                <span>{{ __('Category contains active products') }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="badge badge-light-danger me-3">{{ __('Empty') }}</span>
                                <span>{{ __('No products assigned to this category') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('Catalog.categoryCreate') }}"
                        class="btn btn-primary">{{ __('Create Category') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{ __('Delete Category') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="text-dark fs-5">
                        {{ __('Are you sure you want to delete this category?') }}
                    </p>
                    <p class="text-muted">
                        <strong id="deleteCategoryName"></strong>
                    </p>

                    <div class="alert alert-warning d-flex align-items-center mt-4">
                        <i class="ki-duotone ki-information fs-2hx me-4"></i>
                        <span>
                            {{ __('This action cannot be undone.') }}
                        </span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>

                    <button type="button" id="confirmDeleteCategory" class="btn btn-danger">
                        {{ __('Delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Search functionality
            const searchInput = document.getElementById('table-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.category-row');

                    if (searchTerm.length === 0) {
                        rows.forEach(row => row.style.display = '');
                        return;
                    }

                    rows.forEach(row => {
                        const categoryName = row.querySelector('.text-dark').textContent
                            .toLowerCase();
                        const categoryId = row.querySelector('.text-muted').textContent
                            .toLowerCase();
                        const products = row.querySelector('.products-preview')?.textContent
                            .toLowerCase() || '';

                        const matchesSearch = categoryName.includes(searchTerm) ||
                            categoryId.includes(searchTerm) ||
                            products.includes(searchTerm);

                        row.style.display = matchesSearch ? '' : 'none';
                    });
                });
            }

            // View products functionality
            const productsModal = new bootstrap.Modal(document.getElementById('productsModal'));
            const productsModalTitle = document.getElementById('productsModalTitle');
            const productsList = document.getElementById('productsList');

            document.querySelectorAll('.view-products-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const categoryName = this.getAttribute('data-category-name');
                    const products = JSON.parse(this.getAttribute('data-products'));

                    productsModalTitle.textContent = `Products in ${categoryName}`;
                    productsList.innerHTML = '';

                    if (products.length > 0) {
                        products.forEach(product => {
                            const productElement = document.createElement('div');
                            productElement.className =
                                'd-flex align-items-center p-3 bg-light rounded';
                            productElement.innerHTML = `
                                <i class="ki-duotone ki-check-circle fs-3 text-success me-3"></i>
                                <span class="text-dark">${product}</span>
                            `;
                            productsList.appendChild(productElement);
                        });
                    } else {
                        productsList.innerHTML = `
                            <div class="text-center py-4">
                                <i class="ki-duotone ki-information fs-2hx text-muted mb-3"></i>
                                <p class="text-muted">No products found in this category</p>
                            </div>
                        `;
                    }

                    productsModal.show();
                });
            });

            // Auto-focus search input on page load
            if (searchInput) {
                setTimeout(() => {
                    searchInput.focus();
                }, 300);
            }
        });
        // Delete category
        let deleteCategoryId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));

        document.querySelectorAll('.delete-category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteCategoryId = this.getAttribute('data-category-id');
                const categoryName = this.getAttribute('data-category-name');

                document.getElementById('deleteCategoryName').textContent = categoryName;
                deleteModal.show();
            });
        });

        document.getElementById('confirmDeleteCategory').addEventListener('click', function() {
            if (!deleteCategoryId) return;

            fetch(`/catalog/category/delete/${deleteCategoryId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-category-id="${deleteCategoryId}"]`).remove();
                        deleteModal.hide();
                    } else {
                        alert(data.message || "Failed to delete category");
                    }
                })
                .catch(() => alert("Something went wrong"));
        });
    </script>
@endpush

@push('css')
    <style>
        .category-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #f3f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #3699ff;
            font-size: 1.25rem;
        }

        .card-dashed {
            border: 1px dashed #e4e6ef;
            background: #fafafa;
        }

        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-row td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .products-preview {
            max-height: 80px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .products-preview::-webkit-scrollbar {
            width: 4px;
        }

        .products-preview::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        .products-preview::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }

        .badge-light-success {
            background-color: #e8fff3;
            color: #50cd89;
        }

        .badge-light-info {
            background-color: #f8f5ff;
            color: #8950fc;
        }

        .badge-light-warning {
            background-color: #fff8dd;
            color: #ffc700;
        }

        .badge-light-danger {
            background-color: #ffe2e5;
            color: #f1416c;
        }

        @media (max-width: 768px) {
            .d-flex.flex-column.flex-sm-row {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .d-flex.flex-column.flex-sm-row .btn {
                margin-top: 1rem;
                width: 100%;
            }

            .w-250px {
                width: 100% !important;
            }

            .category-row .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .category-row .d-flex.gap-2 .btn {
                margin: 0;
            }

            .products-preview {
                max-height: 60px;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush
