<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Company;

class SetupShopifyWebhooks extends Command
{
    protected $signature = 'shopify:setup-webhooks {company_id} {shop_domain} {access_token}';
    protected $description = 'Set up abandoned cart webhooks for a Shopify store';

    public function handle()
    {
        $companyId = $this->argument('company_id');
        $shopDomain = $this->argument('shop_domain');
        $accessToken = $this->argument('access_token');
        $apiversion = $this->argument('api_version');
        
        // Verify company exists
        $company = Company::find($companyId);
        if (!$company) {
            $this->error("Company with ID {$companyId} not found.");
            return 1;
        }

        $webhookUrl = url('/abandoned-cart/shopify/webhook');
        
        $webhooks = [
            [
                'topic' => 'carts/create',
                'address' => $webhookUrl,
                'format' => 'json'
            ],
            [
                'topic' => 'carts/update',
                'address' => $webhookUrl,
                'format' => 'json'
            ]
        ];

        foreach ($webhooks as $webhook) {
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $accessToken,
                'Content-Type' => 'application/json',
            ])->post("https://{$shopDomain}/admin/api/2023-07/webhooks.json", [
                'webhook' => $webhook
            ]);

            if ($response->successful()) {
                $this->info("Successfully created {$webhook['topic']} webhook");
            } else {
                $this->error("Failed to create {$webhook['topic']} webhook: " . $response->body());
            }
        }

        $this->info('Shopify webhook setup completed.');
    }
}