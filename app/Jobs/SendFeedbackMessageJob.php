<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\Config;
use Modules\Catalogs\Models\Order;

class SendFeedbackMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $template;
    protected $businessName;

    public function __construct(Order $order, string $template, string $businessName)
    {
        $this->order = $order;
        $this->template = $template;
        $this->businessName = $businessName;
    }

    public function handle()
    {
        $companyId = $this->order->company_id;
        $deliveryDate = $this->order->delivered_at;

        if (is_string($deliveryDate)) {
            $deliveryDate = Carbon::parse($deliveryDate);
        }

        $deliveryDateFormatted = $deliveryDate instanceof Carbon ? $deliveryDate->format('M d, Y') : '';

        // Replace placeholders
        $message = str_replace(
            ['{{ name }}', '{{ order_number }}', '{{ delivery_date }}', '{{ company_name }}'],
            [$this->order->user_name ?? '', $this->order->reference_id ?? '', $deliveryDateFormatted, $this->businessName],
            $this->template
        );

        // WhatsApp credentials
        $whatsappAccessToken = Config::where('model_id', $companyId)
            ->where('key', 'whatsapp_permanent_access_token')
            ->value('value');

        $whatsappPhoneNumberId = Config::where('model_id', $companyId)
            ->where('key', 'whatsapp_phone_number_id')
            ->value('value');

        if (!$whatsappAccessToken || !$whatsappPhoneNumberId) {
            throw new \Exception("WhatsApp credentials not found for company {$companyId}");
        }

        $response = Http::withToken($whatsappAccessToken)->post(
            "https://graph.facebook.com/v19.0/{$whatsappPhoneNumberId}/messages",
            [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->order->phone_number,
                'type' => 'text',
                'text' => [
                    'preview_url' => true,
                    'body' => $message,
                ],
            ]
        );

        if ($response->failed()) {
            throw new \Exception('WhatsApp API error: ' . $response->body());
        }

        // Mark feedback sent
        $this->order->update(['feedback_msg' => 1]);
    }
}
