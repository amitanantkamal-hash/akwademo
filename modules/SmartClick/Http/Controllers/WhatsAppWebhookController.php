<?php

namespace Modules\SmartClick\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Contacts\Models\Contact;
use Modules\SmartClick\Http\Controllers\SmartClickMonitorController;
use Modules\SmartClick\Models\SmartClickTrigger;

class WhatsAppWebhookController extends Controller
{
    public function handleIncomingMessage(Request $request)
    {
        // Extract message and sender from webhook
        $message = strtolower(trim($request->input('message')));
        $from = $request->input('from');
        
        // Find contact by phone number
        $contact = Contact::where('phone', $from)->first();
        
        if (!$contact) {
            // Contact not found, you might want to create a new contact
            return response()->json(['error' => 'Contact not found'], 404);
        }
        
        // Check if message matches any trigger keyword
        $trigger = SmartClickTrigger::where('keyword', $message)->first();
        
        if ($trigger) {
            $monitor = $trigger->monitor;
            
            // Apply the monitor to this contact
            $smartClickController = new SmartClickMonitorController();
            $smartClickController->scheduleActionsForContact($monitor, $contact);
            
            return response()->json(['message' => 'Monitor triggered for contact']);
        }
        
        // Handle special keywords
        switch ($message) {
            case 'stop promotions':
            case 'stop':
                $contact->stopPromotions();
                return response()->json(['message' => 'Promotions stopped for contact']);
                
            case 'start promotions':
            case 'start':
                $contact->subscribed = 1;
                $contact->save();
                return response()->json(['message' => 'Promotions started for contact']);
        }
        
        return response()->json(['message' => 'No action taken']);
    }
}