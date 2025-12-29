<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Modules\AbandonedCart\Models\AbandonedCart;

class ShopifyAbandonedCartSeeder extends Seeder
{
    public function run()
    {
        // Example dummy data for Shopify abandoned carts
        $dummyCarts = [
            [
                'company_id' => 1, // Replace with a valid company ID
                'platform' => 'shopify',
                'cart_id' => 'shopify_cart_1',
                'customer_name' => 'John Doe',
                'customer_phone' => '+919927270503',
                'cart_contents' => json_encode([
                    ['name' => 'Product 1', 'quantity' => 2, 'price' => 50.00],
                    ['name' => 'Product 2', 'quantity' => 1, 'price' => 30.00],
                ]),
                'cart_total' => 130.00,
                'status' => 'active',
                'abandoned_at' => Carbon::now()->subHours(2),
            ],
            [
                'company_id' => 1,
                'platform' => 'shopify',
                'cart_id' => 'shopify_cart_2',
                'customer_name' => 'Jane Smith',
                'customer_phone' => '+917011767613',
                'cart_contents' => json_encode([
                    ['name' => 'Product 3', 'quantity' => 1, 'price' => 75.50],
                ]),
                'cart_total' => 75.50,
                'status' => 'active',
                'abandoned_at' => Carbon::now()->subHours(5),
            ],
            // Add more dummy carts as needed
        ];

        foreach ($dummyCarts as $cartData) {
            AbandonedCart::create($cartData);
        }
    }
}