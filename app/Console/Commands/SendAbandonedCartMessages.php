<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AbandonedCartService;
use Carbon\Carbon;
use Modules\AbandonedCart\Models\AbandonedCartMessage;

class SendAbandonedCartMessages extends Command
{
    protected $signature = 'abandoned-cart:send-messages';
    protected $description = 'Send scheduled abandoned cart WhatsApp messages';

    protected $abandonedCartService;

    public function __construct(AbandonedCartService $abandonedCartService)
    {
        parent::__construct();
        $this->abandonedCartService = $abandonedCartService;
    }

    public function handle()
    {
        $messages = AbandonedCartMessage::where('status', 'scheduled')->where('scheduled_at', '<=', Carbon::now())->with('cart')->get();

        $sentCount = 0;
        $failedCount = 0;

        foreach ($messages as $message) {
            if ($this->abandonedCartService->sendScheduledMessage($message)) {
                $sentCount++;
                $this->info("Sent message for cart ID: {$message->cart->cart_id} at " . Carbon::now());
            } else {
                $failedCount++;
                $this->error("Failed to send message for cart ID: {$message->cart->cart_id}");
            }
        }

        $this->info("Completed: {$sentCount} sent, {$failedCount} failed");
    }
}
