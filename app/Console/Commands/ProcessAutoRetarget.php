<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Contacts\Models\Contact;
use Modules\Wpbox\Models\AutoRetargetCampaign;
use Modules\Wpbox\Models\AutoRetargetLog;
use Modules\Wpbox\Models\AutoRetargetMessage;
use Modules\Wpbox\Models\Campaign;
use App\Models\Company;
use Modules\Wpbox\Traits\Whatsapp;
use Modules\Wpbox\Jobs\SendAutoRetargetMessageJob;

class ProcessAutoRetarget extends Command
{
    use Whatsapp;

    protected $signature = 'autoretarget:process';
    protected $description = 'Process AutoRetarget messages for campaigns';

    public function handle()
    {
        $this->info('Starting AutoRetarget processing...');

        // Check database connection first
        try {
            DB::connection()->getPdo();
            $this->info('Database connection established successfully.');
        } catch (\Exception $e) {
            $this->error('Could not connect to the database. Error: ' . $e->getMessage());
            Log::error('Database connection error: ' . $e->getMessage());
            return 1;
        }

        try {
            // Get campaigns with AutoRetarget enabled and that have an autoretarget campaign ID
            $campaigns = Campaign::where('autoretarget_enabled', true)
                ->whereNotNull('autoretarget_campaign_id')
                ->get();

            if ($campaigns->isEmpty()) {
                $this->info('No AutoRetarget campaigns found.');
                return 0;
            }

            $this->info("Found {$campaigns->count()} AutoRetarget campaigns to process.");

            foreach ($campaigns as $campaign) {
                $this->processCampaign($campaign);
            }

            $this->info('AutoRetarget processing completed.');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error processing AutoRetarget: ' . $e->getMessage());
            Log::error('AutoRetarget processing error: ' . $e->getMessage());
            return 1;
        }
    }

    private function processCampaign(Campaign $campaign)
    {
        $this->info("Processing campaign: {$campaign->name}");

        // Get the autoretarget campaign using the ID from the campaign
        $autoretargetCampaign = AutoRetargetCampaign::where('id', $campaign->autoretarget_campaign_id)
            ->where('is_active', 1)
            ->first();


        if (!$autoretargetCampaign) {
            $this->error("No AutoRetarget campaign found for ID: {$campaign->autoretarget_campaign_id}");
            return;
        }

        // Load the messages for the autoretarget campaign
        $autoretargetCampaign->load('messages.campaign');

        // Find contacts who received this campaign but haven't replied
        $contacts = Contact::where('last_campaign_id', $campaign->id)
            ->where('is_replied', false)
            ->get();

        $this->info("Found {$contacts->count()} contacts for retargeting");

        if ($contacts->isEmpty()) {
            $this->info("No contacts found for campaign: {$campaign->name}. Disabling AutoRetarget for this campaign.");

            // Disable AutoRetarget for this campaign
            $campaign->update(['autoretarget_enabled' => false]);

            return;
        }

        foreach ($contacts as $contact) {
            $this->processContact($contact, $campaign, $autoretargetCampaign);
        }
    }

    private function processContact(Contact $contact, Campaign $campaign, AutoRetargetCampaign $autoretargetCampaign)
    {
        // Use template_sent_at as the time the campaign message was sent
        // Convert to Carbon instance if it's a string
        $sentAt = $contact->template_sent_at;

        if (!$sentAt) {
            $this->info("No sent time found for contact: {$contact->phone}");
            return;
        }

        // Convert to Carbon instance if it's a string
        if (is_string($sentAt)) {
            $sentAt = Carbon::parse($sentAt);
        }

        foreach ($autoretargetCampaign->messages as $autoRetargetMessage) {
            $this->processMessage($contact, $autoRetargetMessage, $sentAt, $autoretargetCampaign, $campaign);
        }
    }

    private function processMessage(Contact $contact, AutoRetargetMessage $autoRetargetMessage, $sentAt, AutoRetargetCampaign $autoretargetCampaign, Campaign $originalCampaign)
    {
        // Check if message was already sent
        $alreadySent = AutoRetargetLog::where('contact_id', $contact->id)
            ->where('autoretarget_message_id', $autoRetargetMessage->id)
            ->exists();

        if ($alreadySent) {
            $this->info("Message already sent to contact: {$contact->phone}");
            return;
        }

        // Calculate when the message should be sent
        $sendDateTime = $sentAt->copy()
            ->addDays($autoRetargetMessage->delay_days)
            ->setTimeFromTimeString($autoRetargetMessage->send_time);

        // Check if it's time to send the message
        if (now()->gte($sendDateTime)) {
            $this->info("Dispatching job to send message to contact: {$contact->phone}");

            // Dispatch job instead of sending directly
            SendAutoRetargetMessageJob::dispatch(
                $contact,
                $autoRetargetMessage,
                $autoretargetCampaign,
                $originalCampaign
            );
        } else {
            $this->info("Message for contact {$contact->phone} scheduled for: {$sendDateTime}");
        }
    }
}
