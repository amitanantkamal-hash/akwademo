<?php

// app/Services/AbandonedCartService.php
namespace App\Services;

use Carbon\Carbon;
use Modules\AbandonedCart\Models\AbandonedCart;
use Modules\AbandonedCart\Models\AbandonedCartMessage;
use Modules\AbandonedCart\Models\AbandonedCartSetting;

class AbandonedCartService
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function processNewAbandonedCart($companyId, $platform, $cartData)
    {
        // Check if abandoned cart feature is enabled for this company
        $settings = AbandonedCartSetting::where('company_id', $companyId)->first();
        if (!$settings || !$settings->enabled) {
            return false;
        }

        // Create abandoned cart record
        $abandonedCart = AbandonedCart::create([
            'company_id' => $companyId,
            'platform' => $platform,
            'cart_id' => $cartData['cart_id'],
            'customer_name' => $cartData['customer_name'],
            'customer_phone' => $cartData['customer_phone'],
            'cart_contents' => json_encode($cartData['cart_contents']),
            'cart_total' => $cartData['cart_total'],
            'abandoned_at' => Carbon::now(),
            'status' => 'active',
        ]);

        // Schedule messages
        $this->scheduleMessages($abandonedCart, $settings);

        return $abandonedCart;
    }

    // app/Services/AbandonedCartService.php
    protected function scheduleMessages(AbandonedCart $cart, AbandonedCartSetting $settings)
    {
        $campaignIds = $settings->campaign_ids;
        $days = $settings->schedule_days;
        $times = $settings->schedule_times;
        $maxReminders = min($settings->max_reminders, count($campaignIds));

        for ($i = 0; $i < $maxReminders; $i++) {
            $campaignId = $campaignIds[$i];
            $day = $days[$i];
            $time = $times[$i];

            // Calculate scheduled time
            $scheduledTime = Carbon::parse($cart->abandoned_at)->addDays($day)->setTimeFromTimeString($time);

            // Create payload for WhatsApp service
            $payload = $this->createPayload($cart);

            AbandonedCartMessage::create([
                'abandoned_cart_id' => $cart->id,
                'campaign_id' => $campaignId,
                'payload' => json_encode($payload),
                'scheduled_at' => $scheduledTime,
                'status' => 'scheduled',
            ]);
        }
    }
    protected function createPayload(AbandonedCart $cart)
    {
        return [
            'customer_name' => $cart->customer_name,
            'customer_phone' => $cart->customer_phone,
            'cart_total' => $cart->cart_total,
            'cart_contents' => is_string($cart->cart_contents) ? json_decode($cart->cart_contents, true) : $cart->cart_contents,
            'abandoned_at' => $cart->abandoned_at->toDateTimeString(),
            'cart_id' => $cart->cart_id,
        ];
    }

    public function sendScheduledMessage(AbandonedCartMessage $message)
    {
        $cart = $message->cart;

        // Skip if cart is already recovered
        if ($cart->status === 'recovered') {
            $message->update(['status' => 'cancelled']);
            return false;
        }

        try {
            $config = [
                'campaign_id' => $message->campaign_id,
                'wa_phone_variable' => 'customer_phone',
            ];

            $payload = json_decode($message->payload, true);

            $result = $this->whatsAppService->sendCampaignMessage($config, $payload, $cart->company_id);

            if ($result) {
                $message->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'response' => json_encode($result),
                ]);
                return true;
            } else {
                $message->update([
                    'status' => 'failed',
                    'response' => 'Failed to send message',
                ]);
                return false;
            }
        } catch (\Exception $e) {
            $message->update([
                'status' => 'failed',
                'response' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
