<?php

namespace Modules\Wpbox\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Contacts\Models\Contact as ContactsContact;
use Modules\Wpbox\Models\Contact as WpboxContact;
use Modules\Wpbox\Models\AutoRetargetCampaign;
use Modules\Wpbox\Models\AutoRetargetLog;
use Modules\Wpbox\Models\AutoRetargetMessage;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Traits\Whatsapp;
use Illuminate\Support\Facades\Log;

class SendAutoRetargetMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Whatsapp;

    protected $contact;
    protected $autoRetargetMessage;
    protected $autoretargetCampaign;
    protected $originalCampaign;

    public function __construct(
        ContactsContact $contact, 
        AutoRetargetMessage $autoRetargetMessage, 
        AutoRetargetCampaign $autoretargetCampaign, 
        Campaign $originalCampaign
    ) {
        $this->contact = $contact;
        $this->autoRetargetMessage = $autoRetargetMessage;
        $this->autoretargetCampaign = $autoretargetCampaign;
        $this->originalCampaign = $originalCampaign;
    }

    public function handle()
    {
        try {
            // Get the campaign to send
            $campaignToSend = $this->autoRetargetMessage->campaign;

            if (!$campaignToSend) {
                Log::error("No campaign found for AutoRetarget message ID: {$this->autoRetargetMessage->id}");
                return;
            }

            Log::info("Sending campaign: {$campaignToSend->name} to contact: {$this->contact->phone}");

            // Get the Wpbox contact (the type expected by makeMessages)
            $wpboxContact = WpboxContact::find($this->contact->id);
            
            if (!$wpboxContact) {
                Log::error("Wpbox contact not found for contact ID: {$this->contact->id}");
                return;
            }

            // Create the message using the campaign's method with the correct contact type
            $message = $campaignToSend->makeMessages(null, $wpboxContact);
            
            // Use your existing WhatsApp sending functionality
            $result = $this->sendCampaignMessageToWhatsApp($message);

            // Log the sent campaign
            AutoRetargetLog::create([
                'autoretarget_campaign_id' => $this->autoretargetCampaign->id,
                'campaign_id' => $this->originalCampaign->id,
                'contact_id' => $this->contact->id,
                'autoretarget_message_id' => $this->autoRetargetMessage->id,
                'sent_at' => now(),
                'status' => $result['status'] === 'success' ? 'sent' : 'failed',
                'response' => json_encode($result),
            ]);

            if ($result['status'] === 'success') {
                Log::info("Successfully sent AutoRetarget campaign '{$campaignToSend->name}' to contact: {$this->contact->phone}");
            } else {
                Log::error("Failed to send AutoRetarget campaign '{$campaignToSend->name}' to contact: {$this->contact->phone}");
                Log::error('Error: ' . $result['message']);
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending AutoRetarget campaign: ' . $e->getMessage());

            AutoRetargetLog::create([
                'autoretarget_campaign_id' => $this->autoretargetCampaign->id,
                'campaign_id' => $this->originalCampaign->id,
                'contact_id' => $this->contact->id,
                'autoretarget_message_id' => $this->autoRetargetMessage->id,
                'sent_at' => now(),
                'status' => 'failed',
                'response' => $e->getMessage(),
            ]);
        }
    }
}