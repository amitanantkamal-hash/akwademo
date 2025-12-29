@extends('general.index-client')


@section('content')

   <div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Products-->
									<div class="card card-flush">
										<!--begin::Card header-->
										<div class="card-header align-items-center py-5 gap-2 gap-md-5">
											<!--begin::Card title-->
											<div class="card-title">
												<!--begin::Search-->
												<div class="d-flex align-items-center position-relative my-1">
													<i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
													<input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Product" />
												</div>
												<!--end::Search-->
											</div>
											<!--end::Card title-->
											<!--begin::Card toolbar-->
											<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
												<div class="w-100 mw-150px">
													<!--begin::Select2-->
													<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">
														<option></option>
														<option value="all">All</option>
														<option value="published">Published</option>
														<option value="scheduled">Scheduled</option>
														<option value="inactive">Inactive</option>
													</select>
													<!--end::Select2-->
												</div>
												<!--begin::Add product-->
												<a href="apps/ecommerce/catalog/add-product.html" class="btn btn-info">Add Product</a>
												<!--end::Add product-->
											</div>
											<!--end::Card toolbar-->
										</div>
										<!--end::Card header-->
										<!--begin::Card body-->
										<div class="card-body pt-0">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
												<thead>
													<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
														<th class="w-10px pe-2">
															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1" />
															</div>
														</th>
														<th class="min-w-200px">Product</th>
														<th class="text-end min-w-100px">SKU</th>
														<th class="text-end min-w-70px">Qty</th>
														<th class="text-end min-w-100px">Price</th>
														<th class="text-end min-w-100px">Rating</th>
														<th class="text-end min-w-100px">Status</th>
														<th class="text-end min-w-70px">Actions</th>
													</tr>
												</thead>
												<tbody class="fw-semibold text-gray-600">
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/1.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 1</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03813002</span>
														</td>
														<td class="text-end pe-0" data-order="33">
															<span class="fw-bold ms-3">33</span>
														</td>
														<td class="text-end pe-0">26</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/2.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 2</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02372003</span>
														</td>
														<td class="text-end pe-0" data-order="28">
															<span class="fw-bold ms-3">28</span>
														</td>
														<td class="text-end pe-0">281</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/3.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 3</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04936006</span>
														</td>
														<td class="text-end pe-0" data-order="18">
															<span class="fw-bold ms-3">18</span>
														</td>
														<td class="text-end pe-0">268</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/4.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 4</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03294004</span>
														</td>
														<td class="text-end pe-0" data-order="40">
															<span class="fw-bold ms-3">40</span>
														</td>
														<td class="text-end pe-0">79</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/5.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 5</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02296001</span>
														</td>
														<td class="text-end pe-0" data-order="6">
															<span class="badge badge-light-warning">Low stock</span>
															<span class="fw-bold text-warning ms-3">6</span>
														</td>
														<td class="text-end pe-0">247</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/6.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 6</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">01708003</span>
														</td>
														<td class="text-end pe-0" data-order="24">
															<span class="fw-bold ms-3">24</span>
														</td>
														<td class="text-end pe-0">154</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/7.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 7</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">01978008</span>
														</td>
														<td class="text-end pe-0" data-order="16">
															<span class="fw-bold ms-3">16</span>
														</td>
														<td class="text-end pe-0">236</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/8.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 8</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03449006</span>
														</td>
														<td class="text-end pe-0" data-order="19">
															<span class="fw-bold ms-3">19</span>
														</td>
														<td class="text-end pe-0">242</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/9.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 9</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03980008</span>
														</td>
														<td class="text-end pe-0" data-order="40">
															<span class="fw-bold ms-3">40</span>
														</td>
														<td class="text-end pe-0">98</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/10.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 10</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03180008</span>
														</td>
														<td class="text-end pe-0" data-order="36">
															<span class="fw-bold ms-3">36</span>
														</td>
														<td class="text-end pe-0">179</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/11.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 11</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02110009</span>
														</td>
														<td class="text-end pe-0" data-order="40">
															<span class="fw-bold ms-3">40</span>
														</td>
														<td class="text-end pe-0">185</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/12.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 12</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03812003</span>
														</td>
														<td class="text-end pe-0" data-order="23">
															<span class="fw-bold ms-3">23</span>
														</td>
														<td class="text-end pe-0">14</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/13.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 13</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03986005</span>
														</td>
														<td class="text-end pe-0" data-order="31">
															<span class="fw-bold ms-3">31</span>
														</td>
														<td class="text-end pe-0">224</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/14.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 14</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04687009</span>
														</td>
														<td class="text-end pe-0" data-order="0">
															<span class="badge badge-light-danger">Sold out</span>
															<span class="fw-bold text-danger ms-3">0</span>
														</td>
														<td class="text-end pe-0">181</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/15.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 15</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03819006</span>
														</td>
														<td class="text-end pe-0" data-order="19">
															<span class="fw-bold ms-3">19</span>
														</td>
														<td class="text-end pe-0">223</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/16.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 16</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03282004</span>
														</td>
														<td class="text-end pe-0" data-order="41">
															<span class="fw-bold ms-3">41</span>
														</td>
														<td class="text-end pe-0">88</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/17.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 17</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04931008</span>
														</td>
														<td class="text-end pe-0" data-order="18">
															<span class="fw-bold ms-3">18</span>
														</td>
														<td class="text-end pe-0">144</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/18.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 18</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04305001</span>
														</td>
														<td class="text-end pe-0" data-order="28">
															<span class="fw-bold ms-3">28</span>
														</td>
														<td class="text-end pe-0">254</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/19.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 19</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03891001</span>
														</td>
														<td class="text-end pe-0" data-order="47">
															<span class="fw-bold ms-3">47</span>
														</td>
														<td class="text-end pe-0">187</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/20.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 20</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03307006</span>
														</td>
														<td class="text-end pe-0" data-order="10">
															<span class="fw-bold ms-3">10</span>
														</td>
														<td class="text-end pe-0">233</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/21.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 21</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02651003</span>
														</td>
														<td class="text-end pe-0" data-order="20">
															<span class="fw-bold ms-3">20</span>
														</td>
														<td class="text-end pe-0">95</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/22.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 22</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02869007</span>
														</td>
														<td class="text-end pe-0" data-order="26">
															<span class="fw-bold ms-3">26</span>
														</td>
														<td class="text-end pe-0">277</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/23.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 23</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03947009</span>
														</td>
														<td class="text-end pe-0" data-order="0">
															<span class="badge badge-light-danger">Sold out</span>
															<span class="fw-bold text-danger ms-3">0</span>
														</td>
														<td class="text-end pe-0">34</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/24.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 24</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04478009</span>
														</td>
														<td class="text-end pe-0" data-order="29">
															<span class="fw-bold ms-3">29</span>
														</td>
														<td class="text-end pe-0">207</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/25.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 25</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02543007</span>
														</td>
														<td class="text-end pe-0" data-order="38">
															<span class="fw-bold ms-3">38</span>
														</td>
														<td class="text-end pe-0">239</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/26.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 26</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04840007</span>
														</td>
														<td class="text-end pe-0" data-order="39">
															<span class="fw-bold ms-3">39</span>
														</td>
														<td class="text-end pe-0">271</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/27.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 27</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">01164005</span>
														</td>
														<td class="text-end pe-0" data-order="7">
															<span class="badge badge-light-warning">Low stock</span>
															<span class="fw-bold text-warning ms-3">7</span>
														</td>
														<td class="text-end pe-0">240</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/28.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 28</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">01214004</span>
														</td>
														<td class="text-end pe-0" data-order="36">
															<span class="fw-bold ms-3">36</span>
														</td>
														<td class="text-end pe-0">91</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/29.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 29</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">01899005</span>
														</td>
														<td class="text-end pe-0" data-order="2">
															<span class="badge badge-light-warning">Low stock</span>
															<span class="fw-bold text-warning ms-3">2</span>
														</td>
														<td class="text-end pe-0">92</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/30.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 30</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04169005</span>
														</td>
														<td class="text-end pe-0" data-order="17">
															<span class="fw-bold ms-3">17</span>
														</td>
														<td class="text-end pe-0">70</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/31.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 31</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02628005</span>
														</td>
														<td class="text-end pe-0" data-order="23">
															<span class="fw-bold ms-3">23</span>
														</td>
														<td class="text-end pe-0">120</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/32.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 32</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03924004</span>
														</td>
														<td class="text-end pe-0" data-order="49">
															<span class="fw-bold ms-3">49</span>
														</td>
														<td class="text-end pe-0">47</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/33.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 33</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04917003</span>
														</td>
														<td class="text-end pe-0" data-order="13">
															<span class="fw-bold ms-3">13</span>
														</td>
														<td class="text-end pe-0">148</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/34.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 34</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03596006</span>
														</td>
														<td class="text-end pe-0" data-order="38">
															<span class="fw-bold ms-3">38</span>
														</td>
														<td class="text-end pe-0">72</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/35.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 35</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">02824007</span>
														</td>
														<td class="text-end pe-0" data-order="14">
															<span class="fw-bold ms-3">14</span>
														</td>
														<td class="text-end pe-0">192</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/36.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 36</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03621008</span>
														</td>
														<td class="text-end pe-0" data-order="37">
															<span class="fw-bold ms-3">37</span>
														</td>
														<td class="text-end pe-0">66</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/37.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 37</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03879009</span>
														</td>
														<td class="text-end pe-0" data-order="14">
															<span class="fw-bold ms-3">14</span>
														</td>
														<td class="text-end pe-0">198</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/38.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 38</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03391007</span>
														</td>
														<td class="text-end pe-0" data-order="43">
															<span class="fw-bold ms-3">43</span>
														</td>
														<td class="text-end pe-0">77</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/39.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 39</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03788007</span>
														</td>
														<td class="text-end pe-0" data-order="27">
															<span class="fw-bold ms-3">27</span>
														</td>
														<td class="text-end pe-0">173</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/40.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 40</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04822003</span>
														</td>
														<td class="text-end pe-0" data-order="31">
															<span class="fw-bold ms-3">31</span>
														</td>
														<td class="text-end pe-0">211</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/41.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 41</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04110004</span>
														</td>
														<td class="text-end pe-0" data-order="20">
															<span class="fw-bold ms-3">20</span>
														</td>
														<td class="text-end pe-0">82</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/42.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 42</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03133005</span>
														</td>
														<td class="text-end pe-0" data-order="37">
															<span class="fw-bold ms-3">37</span>
														</td>
														<td class="text-end pe-0">273</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/43.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 43</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04147002</span>
														</td>
														<td class="text-end pe-0" data-order="45">
															<span class="fw-bold ms-3">45</span>
														</td>
														<td class="text-end pe-0">261</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/44.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 44</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">04273004</span>
														</td>
														<td class="text-end pe-0" data-order="22">
															<span class="fw-bold ms-3">22</span>
														</td>
														<td class="text-end pe-0">296</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/45.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 45</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03152005</span>
														</td>
														<td class="text-end pe-0" data-order="30">
															<span class="fw-bold ms-3">30</span>
														</td>
														<td class="text-end pe-0">147</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/46.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 46</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03662004</span>
														</td>
														<td class="text-end pe-0" data-order="39">
															<span class="fw-bold ms-3">39</span>
														</td>
														<td class="text-end pe-0">237</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/47.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 47</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03408006</span>
														</td>
														<td class="text-end pe-0" data-order="0">
															<span class="badge badge-light-danger">Sold out</span>
															<span class="fw-bold text-danger ms-3">0</span>
														</td>
														<td class="text-end pe-0">159</td>
														<td class="text-end pe-0" data-order="rating-5">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Scheduled">
															<!--begin::Badges-->
															<div class="badge badge-light-info">Scheduled</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/48.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 48</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03235001</span>
														</td>
														<td class="text-end pe-0" data-order="11">
															<span class="fw-bold ms-3">11</span>
														</td>
														<td class="text-end pe-0">15</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/49.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 49</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03957006</span>
														</td>
														<td class="text-end pe-0" data-order="8">
															<span class="badge badge-light-warning">Low stock</span>
															<span class="fw-bold text-warning ms-3">8</span>
														</td>
														<td class="text-end pe-0">96</td>
														<td class="text-end pe-0" data-order="rating-3">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Published">
															<!--begin::Badges-->
															<div class="badge badge-light-success">Published</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<!--begin::Thumbnail-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																	<span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/50.png);"></span>
																</a>
																<!--end::Thumbnail-->
																<div class="ms-5">
																	<!--begin::Title-->
																	<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 50</a>
																	<!--end::Title-->
																</div>
															</div>
														</td>
														<td class="text-end pe-0">
															<span class="fw-bold">03110003</span>
														</td>
														<td class="text-end pe-0" data-order="17">
															<span class="fw-bold ms-3">17</span>
														</td>
														<td class="text-end pe-0">137</td>
														<td class="text-end pe-0" data-order="rating-4">
															<div class="rating justify-content-end">
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label checked">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
																<div class="rating-label">
																	<i class="ki-outline ki-star fs-6"></i>
																</div>
															</div>
														</td>
														<td class="text-end pe-0" data-order="Inactive">
															<!--begin::Badges-->
															<div class="badge badge-light-danger">Inactive</div>
															<!--end::Badges-->
														</td>
														<td class="text-end">
															<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</td>
													</tr>
												</tbody>
											</table>
											<!--end::Table-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Products-->
								</div>
								<!--end::Content container-->
							</div>
@endsection