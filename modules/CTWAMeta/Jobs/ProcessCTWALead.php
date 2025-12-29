<?php

namespace Modules\CTWAMeta\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\CTWAMeta\Models\CTWALead;
use Modules\Bluai\Services\WhatsAppService; // Replace with your WhatsApp service
use Illuminate\Support\Facades\Log;

class ProcessCTWALead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lead;

    /**
     * Create a new job instance.
     *
     * @param CTWALead $lead
     */
    public function __construct(CTWALead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // 1. Ensure lead is not already processed
            if ($this->lead->processed) {
                Log::info("Lead {$this->lead->leadgen_id} already processed.");
                return;
            }

            // 2. Parse lead field data
            $fieldData = json_decode($this->lead->field_data, true);
            $leadInfo = $this->extractLeadInfo($fieldData);

            // 3. Example: create a contact in your system
            $contact = $this->createOrUpdateContact($leadInfo);

            // 4. Example: send WhatsApp message if configured
            if (!empty($leadInfo['phone'])) {
                $this->sendWhatsAppMessage($leadInfo, $contact);
            }

            // 5. Mark lead as processed
            $this->lead->processed = true;
            $this->lead->processed_at = now();
            $this->lead->save();

            Log::info("Lead {$this->lead->leadgen_id} processed successfully.");

        } catch (\Exception $e) {
            Log::error("Failed to process lead {$this->lead->leadgen_id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Extract useful lead info from Facebook field_data array.
     */
    protected function extractLeadInfo(array $fieldData): array
    {
        $info = [];
        foreach ($fieldData as $field) {
            if (isset($field['name']) && isset($field['values'][0])) {
                $info[$field['name']] = $field['values'][0];
            }
        }
        return $info;
    }

    /**
     * Create or update contact in your system.
     */
    protected function createOrUpdateContact(array $leadInfo)
    {
        $contactModel = config('bluai.contact_model'); // your contact model
        if (!$contactModel) {
            Log::warning('Contact model not configured.');
            return null;
        }

        $contact = $contactModel::updateOrCreate(
            ['phone' => $leadInfo['phone'] ?? null],
            [
                'name' => $leadInfo['full_name'] ?? ($leadInfo['name'] ?? 'Unknown'),
                'email' => $leadInfo['email'] ?? null,
                'company_id' => $this->lead->company_id,
                'meta_account_id' => $this->lead->meta_account_id,
            ]
        );

        return $contact;
    }

    /**
     * Send WhatsApp message using your service.
     */
    protected function sendWhatsAppMessage(array $leadInfo, $contact = null)
    {
        try {
            $waServiceClass = config('bluai.whatsapp_service'); // your WhatsApp service class
            if (!$waServiceClass) {
                Log::warning('WhatsApp service not configured.');
                return;
            }

            $waService = new $waServiceClass();

            $message = "📩 Hello {$leadInfo['full_name'] ?? ($leadInfo['name'] ?? '')}, we received your inquiry. We'll contact you shortly.";

            $waService->sendMessage([
                'phone' => $leadInfo['phone'],
                'message' => $message,
            ]);

            Log::info("WhatsApp message sent to {$leadInfo['phone']}.");

        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message', [
                'phone' => $leadInfo['phone'] ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
