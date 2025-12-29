<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AbandonedCartService;

class TestAbandonedCartWithoutDB extends Command
{
    protected $signature = 'test:abandoned-cart';
    protected $description = 'Test abandoned cart functionality without database';

    protected $abandonedCartService;

    public function __construct(AbandonedCartService $abandonedCartService)
    {
        parent::__construct();
        $this->abandonedCartService = $abandonedCartService;
    }

    public function handle()
    {
        $this->info('Testing abandoned cart functionality without database...');
        
        // Create a mock abandoned cart data
        $mockCartData = [
            'company_id' => 1,
            'platform' => 'shopify',
            'cart_id' => 'test_cart_123',
            'customer_name' => 'Test Customer',
            'customer_phone' => '+1234567890',
            'customer_email' => 'test@example.com',
            'cart_contents' => json_encode([
                ['name' => 'Test Product', 'quantity' => 2, 'price' => 29.99]
            ]),
            'cart_total' => 59.98,
            'abandoned_at' => now()->subHours(2),
        ];
        
        $this->info('Mock cart data created:');
        $this->info(json_encode($mockCartData, JSON_PRETTY_PRINT));
        
        // Test your service logic (modify this based on your actual service)
        $this->info('Testing service logic...');
        
        // If your service has methods that don't require database access, test them here
        // For example:
        try {
            $payload = $this->abandonedCartService->createPayload((object)$mockCartData);
            $this->info('Payload created successfully:');
            $this->info(json_encode($payload, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            $this->error('Error creating payload: ' . $e->getMessage());
        }
        
        $this->info('Test completed!');
    }
}