<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\AbandonedCart\Models\AbandonedCartSetting;
use App\Models\Config;
use App\Services\AbandonedCartService;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Automattic\WooCommerce\Client;
use Modules\AbandonedCart\Models\AbandonedCart;

class FetchAbandonedCarts extends Command
{
    protected $signature = 'abandoned-carts:fetch {--hours=4 : Consider carts abandoned after this many hours}';
    protected $description = 'Fetch abandoned carts from Shopify and WooCommerce';

    protected $abandonedCartService;

    public function __construct(AbandonedCartService $abandonedCartService)
    {
        parent::__construct();
        $this->abandonedCartService = $abandonedCartService;
    }

    public function handle()
    {
        $hours = $this->option('hours');
        $settings = AbandonedCartSetting::where('enabled', true)->get();

        if ($settings->isEmpty()) {
            $this->info('No enabled abandoned cart settings found.');
            return;
        }

        foreach ($settings as $setting) {
            $this->info("Processing abandoned carts for company ID: {$setting->company_id}");
            $this->fetchShopifyAbandonedCarts($setting, $hours);
            // $this->fetchWooCommerceAbandonedCarts($setting, $hours);
        }

        $this->info('Abandoned cart fetching completed.');
    }

    private function fetchShopifyAbandonedCarts($setting, $hours)
    {
        // Get Shopify credentials from config table
        $shopDomain = Config::where('model_id', $setting->company_id)
            ->where('key', 'shopify_store_name')
            ->value('value');

        $apiVersion = Config::where('model_id', $setting->company_id)
            ->where('key', 'shopify_api_version')
            ->value('value');

        $accessToken = Config::where('model_id', $setting->company_id)
            ->where('key', 'shopify_access_token')
            ->value('value');

        if ($shopDomain && !str_contains($shopDomain, '.')) {
            $shopDomain = "{$shopDomain}.myshopify.com";
        }

        // Calculate abandoned time threshold
        $abandonedBefore = Carbon::now()->subHours($hours)->toIso8601String();

        try {
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $accessToken,
                'Content-Type' => 'application/json',
            ])->timeout(30)->get("https://{$shopDomain}/admin/api/{$apiVersion}/checkouts.json", [
                'status' => 'open',
                'created_at_max' => $abandonedBefore,
                'limit' => 250
            ]);

            if (!$response->successful()) {
                $this->error("Failed to fetch checkouts for company {$setting->company_id}: " . $response->body());
                return;
            }

            $checkouts = $response->json()['checkouts'] ?? [];
            $this->info("Found " . count($checkouts) . " abandoned checkouts for company {$setting->company_id}.");

            foreach ($checkouts as $checkout) {
                $cartId = $checkout['token'] ?? uniqid();
                $phone  = $checkout['phone'] ?? '';
                
                // Try to fetch phone using customer_id if missing
                if (empty($phone) && isset($checkout['customer']['id'])) {
                    $customerId = $checkout['customer']['id'];

                    try {
                        $customerResponse = Http::withHeaders([
                            'X-Shopify-Access-Token' => $accessToken,
                            'Content-Type' => 'application/json',
                        ])->timeout(30)->get("https://{$shopDomain}/admin/api/{$apiVersion}/customers/{$customerId}.json");

                        if ($customerResponse->successful()) {
                            $customer = $customerResponse->json()['customer'] ?? [];
                    
                            $phone = $customer['phone'] ?? ($customer['default_address']['phone'] ?? '');
                        }
                    } catch (\Exception $e) {
                        $this->warn("Failed to fetch customer {$customerId} for company {$setting->company_id}: " . $e->getMessage());
                    }
                }

                // ✅ Skip if phone is missing
                if (empty($phone)) {
                    $this->warn("Skipping cart {$cartId} for company {$setting->company_id} (no phone number).");
                    continue;
                }

                // ✅ Skip if cart_id already exists in DB
                $alreadyExists = AbandonedCart::where('platform', 'shopify')
                    ->where('cart_id', $cartId)
                    ->where('company_id', $setting->company_id)
                    ->exists();

                if ($alreadyExists) {
                    $this->warn("Skipping cart {$cartId} for company {$setting->company_id} (already processed).");
                    continue;
                }

                // Prepare cart data
                $cartData = [
                    'cart_id' => $cartId,
                    'customer_name' => $this->getShopifyCustomerName($checkout),
                    'customer_phone' => $phone,
                    'customer_email' => $checkout['email'] ?? '',
                    'cart_contents' => $checkout['line_items'] ?? [],
                    'cart_total' => $checkout['total_price'] ?? 0,
                    'abandoned_at' => $checkout['updated_at'] ?? now()->toDateTimeString(),
                ];

                // Process new abandoned cart
                $this->abandonedCartService->processNewAbandonedCart(
                    $setting->company_id,
                    'shopify',
                    $cartData
                );

                $this->info("Processed cart for: " . $cartData['customer_name']);
            }
        } catch (\Exception $e) {
            $this->error("Error processing company {$setting->company_id}: " . $e->getMessage());
        }
    }



    private function fetchWooCommerceAbandonedCarts(AbandonedCartSetting $setting, $hours)
    {
        $storeUrl = Config::getValue($setting->company_id, 'woocommerce_store_url');
        $consumerKey = Config::getValue($setting->company_id, 'woocommerce_consumer_key');
        $consumerSecret = Config::getValue($setting->company_id, 'woocommerce_consumer_secret');

        if (!$storeUrl || !$consumerKey || !$consumerSecret) {
            $this->warn("Company {$setting->company_id} is missing WooCommerce credentials. Skipping.");
            return;
        }

        try {
            $woocommerce = new Client(
                $storeUrl,
                $consumerKey,
                $consumerSecret,
                [
                    'version' => 'wc/v3',
                    'verify_ssl' => false,
                ]
            );

            $abandonedBefore = Carbon::now()->subHours($hours);

            $carts = $woocommerce->get('orders', [
                'status' => 'pending',
                'after' => $abandonedBefore->toIso8601String(),
                'per_page' => 100
            ]);

            $this->info("Found " . count($carts) . " abandoned carts for company {$setting->company_id}.");

            foreach ($carts as $cart) {
                $cartId = $cart['id'] ?? uniqid();
                $customerName = $this->getWooCommerceCustomerName($cart);
                $customerPhone = $cart['billing']['phone'] ?? '';
                $customerEmail = $cart['billing']['email'] ?? '';

                if ($customerName === 'Unknown Customer' || (empty($customerPhone) && empty($customerEmail))) {
                    $this->warn("Skipping cart {$cartId} with unknown or missing contact for company {$setting->company_id}.");
                    continue;
                }

                // ✅ Optional: implement duplicate check for WooCommerce too
                if ($this->abandonedCartService->cartExists($setting->company_id, 'woocommerce', $cartId)) {
                    $this->warn("Skipping duplicate cart {$cartId} for company {$setting->company_id}.");
                    continue;
                }

                $cartData = [
                    'cart_id' => $cartId,
                    'customer_name' => $customerName,
                    'customer_phone' => $customerPhone,
                    'customer_email' => $customerEmail,
                    'cart_contents' => $cart['line_items'] ?? [],
                    'cart_total' => $cart['total'] ?? 0,
                    'abandoned_at' => $cart['date_modified'] ?? now()->toDateTimeString(),
                ];

                $this->abandonedCartService->processNewAbandonedCart(
                    $setting->company_id,
                    'woocommerce',
                    $cartData
                );

                $this->info("Processed cart for: {$cartData['customer_name']}");
            }
        } catch (\Exception $e) {
            $this->error("Error processing company {$setting->company_id}: " . $e->getMessage());
        }
    }

    private function getShopifyCustomerName($checkout)
    {
        if (!empty($checkout['customer']['first_name']) || !empty($checkout['customer']['last_name'])) {
            return trim(($checkout['customer']['first_name'] ?? '') . ' ' . ($checkout['customer']['last_name'] ?? ''));
        }

        if (!empty($checkout['billing_address']['first_name']) || !empty($checkout['billing_address']['last_name'])) {
            return trim(($checkout['billing_address']['first_name'] ?? '') . ' ' . ($checkout['billing_address']['last_name'] ?? ''));
        }

        return 'Unknown Customer';
    }

    private function getWooCommerceCustomerName($cart)
    {
        if (!empty($cart['billing']['first_name']) || !empty($cart['billing']['last_name'])) {
            return trim(($cart['billing']['first_name'] ?? '') . ' ' . ($cart['billing']['last_name'] ?? ''));
        }

        if (!empty($cart['shipping']['first_name']) || !empty($cart['shipping']['last_name'])) {
            return trim(($cart['shipping']['first_name'] ?? '') . ' ' . ($cart['shipping']['last_name'] ?? ''));
        }

        return 'Unknown Customer';
    }
}
