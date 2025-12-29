<?php

namespace Modules\AbandonedCart\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AbandonedCartService;
use Illuminate\Http\Request;

class ShopifyAbandonedCartController extends Controller
{
    protected $abandonedCartService;

    public function __construct(AbandonedCartService $abandonedCartService)
    {
        $this->abandonedCartService = $abandonedCartService;
    }

    public function webhook(Request $request)
    {
        // Verify webhook if needed
        $companyId = $request->header('X-Company-ID') ?? auth()->user()->company_id;
        
        $cartData = [
            'cart_id' => $request->input('id'),
            'customer_name' => $request->input('customer.first_name') . ' ' . $request->input('customer.last_name'),
            'customer_phone' => $this->formatPhoneNumber($request->input('customer.phone')),
            'cart_contents' => $request->input('line_items'),
            'cart_total' => $request->input('total_price'),
        ];

        $this->abandonedCartService->processNewAbandonedCart($companyId, 'shopify', $cartData);

        return response()->json(['status' => 'success']);
    }

    protected function formatPhoneNumber($phone)
    {
        // Add logic to format phone number for WhatsApp
        return preg_replace('/[^0-9]/', '', $phone);
    }
}