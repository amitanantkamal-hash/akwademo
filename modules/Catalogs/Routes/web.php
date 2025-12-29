<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(
    [
        'middleware' => ['web', 'impersonate'],
        'namespace' => 'Modules\Catalogs\Http\Controllers',
    ],

    function () {


        Route::get('/order/{id}/{token}', 'Main@showPublic')->name('order.public.show.token');
         Route::put('/order/{order}/public/status', 'Main@updatePublicStatus')
            ->name('order.public.update-status');

        Route::put('/order/{order}/public/mark-delivered', 'Main@markAsDeliveredPublic')
            ->name('order.public.mark-delivered');
            
        Route::group(
            [
                'middleware' => ['verified', 'web', 'auth', 'otp.verified', 'impersonate', 'XssSanitizer', 'isOwnerOnPro', 'Modules\Wpbox\Http\Middleware\CheckPlan'],
            ],
            function () {
                Route::prefix('catalog')->group(function () {
                    Route::Any('/list', 'Main@index')->name('Catalog.index');
                    Route::get('/{Catalog}/edit', 'Main@edit')->name('Catalog.edit');
                    Route::get('/create', 'Main@create')->name('Catalog.create');
                    Route::post('/', 'Main@store')->name('Catalog.store');
                    Route::put('/{Catalog}', 'Main@update')->name('Catalog.update');
                    Route::get('/del/{Catalog}', 'Main@destroy')->name('Catalog.delete');
                    Route::get('/loginas/{Catalog}', 'Main@loginas')->name('Catalog.loginas');

                    Route::post('/fetch-catalog', 'Main@fetchCatalog')->name('Catalog.fetchCatalog');
                    Route::Any('/fetch-product-catalog', 'Main@fetchProductCatalog')->name('Catalog.fetchProductCatalog');
                    Route::Any('/product', 'Main@productsCatalog')->name('Catalog.productsCatalog');
                    Route::Any('/catalogs-templates', 'Main@catalogsTemplatesIndex')->name('Catalog.catalogsTemplatesIndex');
                    Route::Any('/catalogs-templates-create', 'Main@catalogsTemplatesCreate')->name('Catalog.catalogsTemplatesCreate');
                    Route::Any('/carousel-templates-create', 'Main@carouselTemplatesCreate')->name('Catalog.carouselTemplatesCreate');
                    Route::Any('catalogs-templates/upload-image', 'Main@uploadImage')->name('Catalog.upload-image');
                    Route::delete('catalogs-templates/del/{template}', 'Main@destroyCatalog')->name('Catalog.destroyCatalog');
                    Route::Any('catalogs-templates/upload-video', 'Main@uploadVideo')->name('Catalog.upload-video');
                    Route::Any('catalogs-templates/upload-pdf', 'Main@uploadPdf')->name('Catalog.upload-pdf');
                    Route::Any('catalogs-templates/submit-catologs', 'Main@submitCatalogTemplate')->name('Catalog.submitCatalogTemplate');
                    Route::Any('catalogs-templates/catalog-template-message', 'Main@sendWhatsAppCatalogTemplateMessage')->name('Catalog.sendWhatsAppCatalogTemplateMessage');
                    Route::delete('category/delete/{id}', 'Main@categoryDelete')->name('Catalog.categoryDelete');

                    // order
                    Route::Any('order', 'Main@orderINdex')->name('Catalog.orderINdex');
                    Route::Any('order/item/{id}', 'Main@itemIndex')->name('Catalog.itemIndex');
                    Route::Any('order/edit/{id}', 'Main@itemEdit')->name('Catalog.itemEdit');
                    Route::Any('order/update/{id}', 'Main@orderUpdate')->name('Catalog.orderUpdate');
                    Route::Any('order/pdf/{id}', 'Main@pdf')->name('Catalog.pdf');
                    Route::get('order/receipt/{id}', 'Main@printReceipt')->name('Catalog.receipt');

                    Route::Any('payment/setting', 'Main@setting')->name('Catalog.setting');
                    Route::Any('payment/setting/update', 'Main@settingUpdate')->name('Catalog.settingUpdate');
                    Route::Any('payment/setting/whatsapp_update', 'Main@whatsappPhoneUpdate')->name('Catalog.whatsappPhoneUpdate');

                    // category
                    Route::Any('category/index', 'Main@categoryIndex')->name('Catalog.categoryIndex');
                    Route::Any('category/create', 'Main@categoryCreate')->name('Catalog.categoryCreate');
                    Route::Any('category/store', 'Main@categoryStore')->name('Catalog.categoryStore');
                    Route::Any('category/edit/{id}', 'Main@categoryEdit')->name('Catalog.categoryEdit');
                    Route::Any('category/update/{id}', 'Main@categoryUpdate')->name('Catalog.categoryUpdate');

                    Route::Any('product/edit/{id}', 'Main@productEdit')->name('Catalog.productEdit');
                    Route::Any('product/update', 'Main@productUpdate')->name('Catalog.productUpdate');

                    Route::Any('/address-message-enable', 'Main@address_message_enable')->name('Catalog.address_message_enable');
                    Route::Any('/payment-method-enable', 'Main@payment_method_enable')->name('Catalog.payment_method_enable');
                    Route::post('/send-order-dispatch/{order_id}', 'Main@sendOrderDispatch')->name('Catalog.sendOrderDispatch');
                    Route::post('/orders/update-status', 'Main@updateStatus')->name('Catalog.orderStatusUpdate');
                    Route::post('/orders/{order}/update-shipping', 'Main@updateShipping')->name('Catalog.updateShipping');
                    Route::post('/catalog/orders/update-payment/{id}', 'Main@updatePayment')->name('Catalog.updatePayment');
                    Route::post('/catalog/send-payment-whatsapp', 'Main@sendPaymentWhatsApp')->name('Catalog.sendPaymentWhatsApp');
                    Route::post('/catalog/orders/cancel/{id}', 'Main@cancelOrder')->name('Catalog.cancelOrder');
                    Route::post('/orders/{id}/update-contact', 'Main@updateContact')->name('Catalog.updateContact');
                    Route::post('/orders/{id}/update-note', 'Main@updateOrderNote')->name('Catalog.updateOrderNote');
                    Route::post('/catalog/apply-discount/{order}', 'Main@applyDiscount')->name('Catalog.applyDiscount');
                    Route::post('/catalog/resend-payment-link', 'Main@resendPaymentLink')->name('Catalog.resendPaymentLink');

                    Route::post('/order/{order}/resend-address-form', 'Main@resendAddressForm')->name('order.resendAddressForm');

                    Route::post('/catalog/storefront-update', 'Main@storefrontUpdate')->name('Catalog.storefrontUpdate');
                    Route::post('/catalog/templates-update', 'Main@templatesUpdate')->name('Catalog.templatesUpdate');
                    Route::post('/catalog/order/{id}/send-default-template', 'Main@sendDefaultTemplate')->name('Catalog.sendDefaultTemplate');
                    Route::post('/catalog/order/{id}/refresh-window', 'Main@refreshWindowStatus')->name('Catalog.refreshWindowStatus');
                    Route::post('/catalog/order/{id}/send-template', 'Main@sendTemplateMessage')->name('Catalog.sendTemplateMessage');
                    Route::post('/catalog/order/{id}/add-item', 'Main@addItemToOrder')->name('Catalog.addItemToOrder');
                    Route::post('/catalog/order/{id}/send-updated-cart', 'Main@sendUpdatedCart')->name('Catalog.sendUpdatedCart');
                    Route::get('/catalog/order/{order}/items-section', 'Main@orderItemsSection')->name('Catalog.orderItemsSection');
                    Route::post('/catalog/order/{order}/update-item', 'Main@updateOrderItem')->name('Catalog.updateOrderItem');
                    Route::post('/catalog/order/{order}/delete-item', 'Main@deleteOrderItem')->name('Catalog.deleteOrderItem');

                    Route::get('/order/{id}/adjust-section', 'Main@orderAdjustSection')
                        ->name('Catalog.orderAdjustSection');
                });
            },
        );
    },


);
