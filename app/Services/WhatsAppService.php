<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Company;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Traits\Contacts;
use Modules\Wpbox\Traits\Whatsapp;

class WhatsAppService
{
    use Contacts;
    use Whatsapp;
    
    public function sendCampaignMessage(array $config, array $payload, int $companyId)
    {
        // Get phone number (static or variable-based)

        $autoretarget_enabled = $config['autoretarget_enabled'] ?? null;
        $autoretarget_campaign_id = $config['autoretarget_campaign_id'] ?? null;

        $phone = $config['wa_phone'] ?? '';
        if (isset($config['wa_phone'])) {
            $phone = $this->processPhoneTemplate($config['wa_phone'], $payload);
        }

        // Normalize phone - remove all non-digit characters
        $phone = $this->normalizePhone($phone);

        // Skip if no phone
        if (!$phone) {
            throw new \Exception('Phone number is required for contact creation');
        }
        // Validate required parameters
        if (empty($phone)) {
            Log::error('Missing phone number for WhatsApp message', ['config' => $config]);
            return false;
        }

        if (empty($config['campaign_id'])) {
            Log::error('Missing campaign ID for WhatsApp message', ['config' => $config]);
            return false;
        }

        try {
            // Get company
            $company = Company::find($companyId);
            if (!$company) {
                Log::error('Company not found', ['company_id' => $companyId]);
                return false;
            }

            // Process payload template
            $waPayload = $this->processTemplate($config['wa_payload'] ?? '{}', $payload);
            
                    // Normalize phone number: remove all non-digit characters except leading '+'
            $inputPhone = preg_replace('/\D+/', '', $phone); // Keep only digits


            // Check for existing contacts with either format
            // $existingContact = $this->provider::where('phone', $normalizedPhone)->orWhere('phone', ltrim($normalizedPhone, '+'))->first();

            // if ($existingContact) {
                // Get or create contact
            $contact = $this->getOrMakeContact($inputPhone, $company, $inputPhone);

            // Retrieve campaign
            $campaign = Campaign::find($config['campaign_id']);
            if (!$campaign) {
                Log::error('Campaign not found', ['campaign_id' => $config['campaign_id']]);
                return false;
            }

            if($autoretarget_enabled == 1 && $autoretarget_campaign_id){

                $campaign->autoretarget_enabled = 1;
                $campaign->autoretarget_campaign_id =  $autoretarget_campaign_id;
                $campaign->save();

                $contact->is_replied = false;
                $contact->replied_at = null;
                $contact->template_sent_at = now();
                $contact->last_campaign_id = $campaign->id;
                $contact->save();
            }

            // Merge payload data into contact's extra_value
            $contact['extra_value'] = array_merge($contact['extra_value'] ?? [], json_decode($waPayload, true) ?: []);


            // Generate WhatsApp message
            $message = $campaign->makeMessages(null, $contact);

            // Send via WhatsApp
            $this->sendCampaignMessageToWhatsApp($message);

            Log::info('WhatsApp Message Sent', [
                'status' => 'success',
                'wa_phone' => $phone,
                'message_id' => $message->id,
                'message_wamid' => $message->fb_message_id,
            ]);

            return [
                'status' => 'success',
                'message_id' => $message->id,
                'message_wamid' => $message->fb_message_id,
            ];
        } catch (\Exception $e) {
            Log::error('WhatsApp sending failed', [
                'error' => $e->getMessage(),
                'config' => $config,
                'payload' => $payload,
            ]);
            return false;
        }
    }

     private function processPhoneTemplate(string $phoneTemplate, array $payload): string
    {
        // If no variables in template, return as static phone number
        if (strpos($phoneTemplate, '{{') === false) {
            return $phoneTemplate;
        }
        
        // Process template with variables
        return preg_replace_callback('/{{\s*(.*?)\s*}}/', function($matches) use ($payload) {
            $value = $this->getValueByDotNotation($payload, $matches[1]);
            return $value ?? '';
        }, $phoneTemplate);
    }

    protected function getValueByDotNotation(array $context, string $key)
    {
        // Debug: Log the key we're trying to access
        Log::debug("Getting value by dot notation", [
            'key' => $key,
            'context_keys' => array_keys($context)
        ]);
        
        // Handle direct top-level keys
        if (array_key_exists($key, $context)) {
            return $context[$key];
        }
        
        $keys = explode('.', $key);
        $value = $context;

        foreach ($keys as $part) {
            // Debug: Log current traversal state
            Log::debug("Traversing dot notation", [
                'current_part' => $part,
                'current_keys' => is_array($value) ? array_keys($value) : 'N/A',
                'current_value' => $value
            ]);
            
            // Check if we can traverse deeper
            if (is_array($value) && (isset($value[$part]) || array_key_exists($part, $value))) {
                $value = $value[$part];
            } else {
                // Key doesn't exist at this level
                Log::warning("Key not found in dot notation path", [
                    'missing_key' => $part,
                    'full_path' => $key,
                    'available_keys' => is_array($value) ? array_keys($value) : 'N/A'
                ]);
                return null;
            }
        }

        return $value;
    }


    private function normalizePhone($phone): string
    {
        if (!$phone) {
            return '';
        }
        return preg_replace('/\D/', '', $phone); // Remove all non-digit characters
    }

    /**
     * Replace placeholders in template using payload data
     */
    public function processTemplate(string $template, array $payload): string
    {
        return preg_replace_callback(
            '/\{\{\s*(.*?)\s*\}\}/',
            function ($matches) use ($payload) {
                $value = data_get($payload, trim($matches[1]), $matches[0]);

                // Handle array values by converting to JSON
                if (is_array($value) || is_object($value)) {
                    return json_encode($value);
                }

                return $value;
            },
            $template,
        );
    }

    /**
     * Send request to WhatsApp service
     */
    protected function sendRequest(array $data): bool
    {
        $baseUrl = config('services.dotflo.base_url', 'http://sendinai.com');
        $endpoint = "{$baseUrl}/api/wpbox/sendcampaigns";

        try {
            $response = Http::timeout(15)->retry(2, 100)->post($endpoint, $data);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'campaign_id' => $data['campaing_id'],
                    'phone' => $data['phone'],
                ]);
                return true;
            }

            Log::error('WhatsApp API error response', [
                'status' => $response->status(),
                'response' => $response->body(),
                'request' => $data,
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp connection failed', [
                'error' => $e->getMessage(),
                'endpoint' => $endpoint,
                'request' => $data,
            ]);
            return false;
        }
    }
}
