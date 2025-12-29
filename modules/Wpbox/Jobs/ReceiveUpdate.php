<?php

namespace Modules\Wpbox\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Wpbox\Models\Message;
use Modules\Wpbox\Models\Campaign;

class ReceiveUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $maxExceptions = 2;
    public $timeout = 30;
    public $backoff = [5, 10, 15];

    public function __construct(protected $value)
    {
        // Always highest priority
        $this->onQueue('high_priority');
    }

    public function handle()
    {   
        $value = $this->value;
        $status = $value['statuses'][0]['status'] ?? null;
        $messageFBID = $value['statuses'][0]['id'] ?? null;

        if (!$messageFBID || !$status) return;

        $message = Message::where('fb_message_id', $messageFBID)->first();
        if (!$message) return;

        $this->updateMessageStatus($message, $status);
        $this->updateCampaignStats($message, $status);
    }

    private function updateMessageStatus($message, $status)
    {
        $statusMap = [
            'sent' => 2,
            'delivered' => 3,
            'read' => 4,
            'failed' => 5
        ];

        if (isset($statusMap[$status]) && $message->status < $statusMap[$status]) {
            $message->status = $statusMap[$status];
            
            if ($status === 'failed') {
                $message->error = $value['statuses'][0]['errors'][0]['message'] ?? 'Delivery failed';
            }
            
            $message->update();
        }
    }

    private function updateCampaignStats($message, $status)
    {
        if (!$message->campaign_id) return;
        
        $campaign = Campaign::find($message->campaign_id);
        if (!$campaign) return;

        $statUpdates = [
            'sent' => 'sended_to',
            'delivered' => 'delivered_to',
            'read' => 'read_by'
        ];

        if (isset($statUpdates[$status])) {
            $campaign->increment($statUpdates[$status]);
        }
    }

    public function failed(\Throwable $exception)
    {
        \Log::error("ReceiveUpdate failed: ".$exception->getMessage(), [
            'value' => $this->value
        ]);
    }
}