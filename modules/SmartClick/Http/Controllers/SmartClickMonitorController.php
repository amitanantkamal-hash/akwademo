<?php

namespace Modules\SmartClick\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Group;
use Modules\SmartClick\Models\SmartClickAction;
use Modules\SmartClick\Models\SmartClickMonitor;
use Modules\SmartClick\Models\SmartClickSchedule;
use Modules\SmartClick\Models\SmartClickTrigger;

class SmartClickMonitorController extends Controller
{
    public function index()
    {
        $monitors = SmartClickMonitor::with(['actions', 'triggers'])->get();
        return view('smart-click::index', compact('monitors'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('smart-click::create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'triggers' => 'nullable|string',
            'actions' => 'required|array',
            'actions.*.type' => 'required|in:add_tags,remove_tags,add_groups,remove_groups,custom_field,whatsapp',
            'actions.*.value' => 'required|string',
            'actions.*.delay' => 'nullable|integer|min:0',
            'actions.*.order' => 'integer',
        ]);

        DB::transaction(function () use ($validated) {
            $monitor = SmartClickMonitor::create(['name' => $validated['name']]);

            // Add triggers if provided
            if (!empty($validated['triggers'])) {
                $keywords = array_map('trim', explode(',', $validated['triggers']));
                foreach ($keywords as $keyword) {
                    if (!empty($keyword)) {
                        SmartClickTrigger::create([
                            'monitor_id' => $monitor->id,
                            'keyword' => strtolower($keyword),
                        ]);
                    }
                }
            }

            foreach ($validated['actions'] as $actionData) {
                SmartClickAction::create([
                    'monitor_id' => $monitor->id,
                    'action_type' => $actionData['type'],
                    'action_value' => $actionData['value'],
                    'delay_minutes' => $actionData['delay'] ?? 0,
                    'order' => $actionData['order'] ?? 0,
                ]);
            }
        });

        return redirect()->route('smartclick.index')->with('success', 'Monitor created successfully.');
    }

    public function applyToContacts(SmartClickMonitor $monitor, Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
        ]);

        $contacts = Contact::whereIn('id', $request->contacts)->where('subscribed', 1)->get();

        foreach ($contacts as $contact) {
            $this->scheduleActionsForContact($monitor, $contact);
        }

        return response()->json(['message' => 'Monitor applied to selected contacts']);
    }

    private function scheduleActionsForContact(SmartClickMonitor $monitor, Contact $contact)
    {
        $actions = $monitor->actions()->orderBy('order')->get();
        $baseTime = now();

        foreach ($actions as $action) {
            $scheduledTime = $baseTime->copy()->addMinutes($action->delay_minutes);

            SmartClickSchedule::create([
                'contact_id' => $contact->id,
                'monitor_id' => $monitor->id,
                'action_id' => $action->id,
                'scheduled_at' => $scheduledTime,
            ]);

            // Update base time for next action if it's sequential
            $baseTime = $scheduledTime;
        }
    }

    public function stopForContact(Contact $contact)
    {
        $contact->stopPromotions();

        return response()->json(['message' => 'Promotions stopped for contact']);
    }

    public function show(SmartClickMonitor $monitor)
    {
        $monitor->load(['actions', 'triggers']);
        return view('smart-click::show', compact('monitor'));
    }

    public function destroy(SmartClickMonitor $monitor)
    {
        DB::transaction(function () use ($monitor) {
            $monitor->schedules()->delete();
            $monitor->actions()->delete();
            $monitor->triggers()->delete();
            $monitor->delete();
        });

        return redirect()->route('smart-click::index')->with('success', 'Monitor deleted successfully.');
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
