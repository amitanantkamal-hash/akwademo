<?php

namespace Modules\SmartClick\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Modules\SmartClick\Models\SmartClickSchedule;

class ProcessSmartClickActions extends Command
{
    protected $signature = 'smartclick:process';
    protected $description = 'Process scheduled SmartClick actions';
    
    public function handle()
    {
        $schedules = SmartClickSchedule::with(['contact', 'action'])
            ->where('scheduled_at', '<=', now())
            ->where('is_completed', false)
            ->whereHas('contact', function ($query) {
                $query->where('subscribed', 1);
            })
            ->get();
            
        foreach ($schedules as $schedule) {
            DB::transaction(function () use ($schedule) {
                $this->executeAction($schedule);
                
                $schedule->update([
                    'is_completed' => true,
                    'completed_at' => now()
                ]);
            });
        }
        
        $this->info('Processed ' . $schedules->count() . ' actions');
    }
    
    private function executeAction(SmartClickSchedule $schedule)
    {
        $action = $schedule->action;
        $contact = $schedule->contact;
        
        switch ($action->action_type) {
            case 'add_tags':
                $tags = json_decode($action->action_value, true);
                $contact->addTags($tags);
                break;
                
            case 'remove_tags':
                $tags = json_decode($action->action_value, true);
                $contact->removeTags($tags);
                break;
                
            case 'add_groups':
                $groupIds = json_decode($action->action_value, true);
                $contact->groups()->syncWithoutDetaching($groupIds);
                break;
                
            case 'remove_groups':
                $groupIds = json_decode($action->action_value, true);
                $contact->groups()->detach($groupIds);
                break;
                
            case 'custom_field':
                $fieldData = json_decode($action->action_value, true);
                // Assuming you have a custom_fields column or relationship
                // This would need to be implemented based on your structure
                break;
                
            case 'whatsapp':
                // Check if contact can receive WhatsApp
                if ($contact->canReceiveWhatsApp()) {
                    $this->sendWhatsAppMessage($contact, $action->action_value);
                    $contact->last_smart_whatsapp_sent_at = now();
                    $contact->save();
                }
                break;
        }
    }
    
    private function sendWhatsAppMessage($contact, $template)
    {
        // Implement your WhatsApp API integration here
        // This is a placeholder for your WhatsApp sending logic
        \Log::info("Sending WhatsApp message to {$contact->phone} with template: {$template}");
        
        // Example implementation (pseudo-code):
        /*
        $whatsappService = new WhatsAppService();
        $whatsappService->sendTemplate(
            $contact->phone,
            $template,
            [
                'name' => $contact->name,
                // other template variables
            ]
        );
        */
    }
}