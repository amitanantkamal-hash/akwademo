<?php

namespace App\Console\Commands;

use App\Jobs\SendFeedbackMessageJob;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Paymenttemplate;
use Modules\Catalogs\Models\Order;

class SendFeedbackMessages extends Command
{
    protected $signature = 'feedback:send';
    protected $description = 'Send feedback WhatsApp messages with company-specific templates';

    public function handle()
    {
        $delayMinutes = env('FEEDBACK_DELAY_MINUTES', 1);
        $cutoffTime = Carbon::now()->subMinutes($delayMinutes);

        $orders = Order::where('status', 'delivered')
            ->where('feedback_msg', 0)
            ->whereNotNull('delivery_datetime')
            ->where('delivery_datetime', '<=', $cutoffTime)
            ->get();
            
        // Group orders by company
        $ordersByCompany = $orders->groupBy('company_id');

        foreach ($ordersByCompany as $companyId => $companyOrders) {
            // Get review template + business_name
            $catalog = Paymenttemplate::where('company_id', $companyId)->first();

            if (!$catalog || !$catalog->review_template) {
                Log::error("Review template not configured for company: {$companyId}");
                continue;
            }

            $template = $catalog->review_template;
            $businessName = $catalog->business_name ?? 'Our Business';

            foreach ($companyOrders as $order) {
                // Queue job for each order
                SendFeedbackMessageJob::dispatch($order, $template, $businessName);
            }
        }

        $this->info('Queued ' . count($orders) . ' feedback messages');
    }
}
