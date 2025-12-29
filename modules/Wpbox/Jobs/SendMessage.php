<?php

namespace Modules\Wpbox\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Modules\Wpbox\Models\Message;
use App\Jobs\Middleware\RateLimited;
use App\Models\Company;
use Modules\Contacts\Models\Contact;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $maxExceptions = 2;
    public $timeout = 120;
    public $backoff = [30, 60, 120];

    // Only store IDs instead of full models
    protected $messageId;
    protected $companyId;
    protected $contactId;
    protected $campaignId;

    public function __construct(Message $message)
    {
        // Store only IDs for serialization
        $this->messageId = $message->id;
        $this->companyId = $message->campaign->company->id;
        $this->contactId = $message->contact->id;
        $this->campaignId = $message->campaign->id;
    
      
        
        // Set queue priority
        $jobOut = $this->onQueue($this->getQueuePriority());
    }

    public function middleware()
    {
        return [new RateLimited];
    }

    private function getQueuePriority()
    {
        // Reload relationships from database
        $company = Company::find($this->companyId);
        
        if (!$company) return 'low_priority';
        
        if ($company->is_enterprise) return 'high_priority';
        if ($company->is_premium) return 'medium_priority';

        return 'low_priority';
    }

    public function handle()
    {
        // Reload all models from database
        $message = Message::find($this->messageId);
        $company = Company::find($this->companyId);
        $contact = Contact::find($this->contactId);
        
        if (!$message || !$company || !$contact) {
            $this->handleError("Required data not found");
            return;
        }

        $url = "https://graph.facebook.com/v19.0/".$company->getConfig('whatsapp_phone_number_id','').'/messages';
        $accessToken = $company->getConfig('whatsapp_permanent_access_token','');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $contact->phone,
                'type' => 'template',
                'template' => [
                    "name" => $message->campaign->template->name,
                    "language" => ["code" => $message->campaign->template->language],
                    "components" => json_decode($message->components)
                ]
            ]);

            $this->processResponse($response, $message);
            
        } catch (\Exception $e) {
            $this->handleError($e->getMessage(), $message);
        }
    }

    private function processResponse($response, $message)
    {
        $statusCode = $response->status();
        $content = $response->json();

        $message->created_at = now();

        if ($statusCode === 200 && isset($content['messages'])) {
            $message->fb_message_id = $content['messages'][0]['id'];
            $message->status = 1; // Sent
        } else {
            $error = $content['error']['message'] ?? 'Unknown error';
            $this->handleError("API Error: {$error} (Status: {$statusCode})", $message);
        }

        $message->save();
    }

    private function handleError($error, $message = null)
    {
        if ($message) {
            $message->error = $error;
            $message->status = 5; // Failed
            $message->save();
        }
        
        if ($this->attempts() < $this->tries) {
            $this->release(30);
        }
    }

    public function failed(\Throwable $exception)
    {
        if ($message = Message::find($this->messageId)) {
            $message->update([
                'status' => 5,
                'error' => "Job Failed: ".$exception->getMessage()
            ]);
        }
    }
}