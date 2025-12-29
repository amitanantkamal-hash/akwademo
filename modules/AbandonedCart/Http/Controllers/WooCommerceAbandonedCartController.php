<?php

namespace Modules\AbandonedCart\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AbandonedCartService;
use Illuminate\Http\Request;

class WooCommerceAbandonedCartController extends Controller
{
    protected $abandonedCartService;

    public function __construct(AbandonedCartService $abandonedCartService)
    {
        $this->abandonedCartService = $abandonedCartService;
    }

    public function webhook(Request $request)
    {
        $companyId = $request->header('X-Company-ID') ?? auth()->user()->company_id;
        
        $cartData = [
            'cart_id' => $request->input('cart_key'),
            'customer_name' => $request->input('customer.first_name') . ' ' . $request->input('customer.last_name'),
            'customer_phone' => $this->formatPhoneNumber($request->input('customer.phone')),
            'cart_contents' => $request->input('items'),
            'cart_total' => $request->input('total'),
        ];

        $this->abandonedCartService->processNewAbandonedCart($companyId, 'woocommerce', $cartData);

        return response()->json(['status' => 'success']);
    }

    protected function formatPhoneNumber($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}