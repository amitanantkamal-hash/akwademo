<?php

namespace Modules\Wpbox\Http\Controllers;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Contacts\Models\Group;
use Modules\Wpbox\Models\Contact;
use Modules\Contacts\Models\Field;
use Modules\Wpbox\Jobs\SendMessage;
use Modules\Wpbox\Jobs\ProcessCampaign;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\AutoRetargetCampaign;
use Modules\Wpbox\Models\FileManager;
use Modules\Wpbox\Models\Message;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;

class CampaignsController extends Controller
{
    use Whatsapp;

    /**
     * Provide class.
     */
    private $provider = Campaign::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'campaigns.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::campaigns.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'campaigns';

    /**
     * Title of this crud.
     */
    private $title = 'campaign';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'campaigns';


    // public function index()
    // {

    //     $this->authChecker();

    //     if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
    //         return redirect(route('whatsapp.setup'));
    //     }

    //     $items = $this->provider::orderBy('id', 'desc')->whereNull('contact_id')->where('is_bot', false)->where('is_bot', false)->where('is_api', false)->where('is_reminder', false);
    //     if (isset($_GET['name']) && strlen($_GET['name']) > 1) {
    //         $items = $items->where('name',  'like', '%' . $_GET['name'] . '%');
    //     }
    //     $items = $items->paginate(100);


    //     return view($this->view_path . 'index', [
    //         'total_contacts' => Contact::count(),
    //         'setup' => [

    //             'title' => __('crud.item_managment', ['item' => __($this->titlePlural)]),
    //             'iscontent' => true,
    //             'action_link' => route($this->webroute_path . 'create'),
    //             'action_name' => __('Send new campaign'),
    //             'action_link2'=>route('wpbox.api.index', ['type' => 'api']),
    //             'action_name2'=>__('Manage API campaigns'),
    //             'items' => $items,
    //             'item_names' => $this->titlePlural,
    //             'webroute_path' => $this->webroute_path,
    //             'fields' => [],
    //             'custom_table' => true,
    //             'parameter_name' => $this->parameter_name,
    //             'parameters' => count($_GET) != 0
    //         ]
    //     ]);
    // }

    public function index()
    {
        $this->authChecker();

        if (
            $this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes'
            || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes'
        ) {
            return redirect(route('whatsapp.setup'));
        }

        $query = $this->provider::orderBy('id', 'desc')
            ->whereNull('contact_id')
            ->where('is_bot', false)
            ->where('is_api', false)
            ->where('is_reminder', false);

        if (isset($_GET['name']) && strlen($_GET['name']) > 1) {
            $query = $query->where('name', 'like', '%' . $_GET['name'] . '%');
        }

        // Clone query for stats (without pagination)
        $allItems = (clone $query)->get();
        // Paginate for listing
        $items = $query->paginate(10);

        // ---- Overall Stats (all campaigns) ----
       // $allItems = (clone $allItems)->get();
        $overallStats = $this->calculateStats($allItems);

        // ---- Last 30 Days Stats ----
        $last30DaysItems = (clone $query)
            ->where('created_at', '>=', now()->subDays(30))
            ->get();

        $last30DaysStats = $this->calculateStats($last30DaysItems);

        return view($this->view_path . 'index', [
            'total_contacts' => Contact::count(),
            'setup' => [
                'title' => __('Campaigns'),
                'iscontent' => true,
                'items' => $items,
                'stats' => $overallStats,
                'last30DaysStats' => $last30DaysStats, // <-- new
            ]
        ]);
    }

    // Helper function to calculate stats
    protected function calculateStats($items)
    {
        $totalCampaigns = $items->count();
        $totalSent = $items->sum('send_to');
        $totalDelivered = $items->sum('delivered_to');
        $totalRead = $items->sum('read_by');
        $totalClicked = $items->sum('clicked');

        $deliveryRate = $totalSent > 0 ? round(($totalDelivered / $totalSent) * 100, 1) : 0;
        $readRate = $totalDelivered > 0 ? round(($totalRead / $totalDelivered) * 100, 1) : 0;
        $engagementRate = $totalDelivered > 0 ? round((($totalRead + $totalClicked) / $totalDelivered) * 100, 1) : 0;

        $scheduledCampaigns = $items->filter(function ($campaign) {
            return $campaign->timestamp_for_delivery > now();
        })->count();

        $completedCampaigns = $totalCampaigns - $scheduledCampaigns;

        return [
            'totalCampaigns' => $totalCampaigns,
            'totalSent' => $totalSent,
            'totalDelivered' => $totalDelivered,
            'totalRead' => $totalRead,
            'totalClicked' => $totalClicked,
            'deliveryRate' => $deliveryRate,
            'readRate' => $readRate,
            'engagementRate' => $engagementRate,
            'scheduledCampaigns' => $scheduledCampaigns,
            'completedCampaigns' => $completedCampaigns,
        ];
    }


    public function show(Campaign $campaign)
    {

        //Get countries we have send to
        $contact_ids = $campaign->messages()->select(['contact_id'])->pluck('contact_id')->toArray();
        $countriesCount = DB::table('contacts')
            ->join('countries', 'contacts.country_id', '=', 'countries.id')
            ->selectRaw('count(contacts.id) as number_of_messages, country_id, countries.name, countries.lat, countries.lng')
            ->whereIn('contacts.id', $contact_ids)
            ->groupBy('contacts.country_id')
            ->get()->toArray();

        $dataToSend = [
            'total_contacts' => Contact::count(),
            'item' => $campaign,
            'contacts' => Contact::all(),
            'setup' => [

                'campaign_id' => $campaign->id,
                'countriesCount' => $countriesCount,
                'title' => __('Campaign: ') . " " . $campaign->name,
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => "" . __('Back'),
                'items' => $campaign->messages()->paginate(config('settings.paginate')),
                'item_names' => $this->titlePlural,
                'webroute_path' => $this->webroute_path,
                'fields' => [],
                'custom_table' => true,
                'parameter_name' => $this->parameter_name,
                'parameters' => count($_GET) != 0
            ]
        ];

        if ($campaign->is_bot) {
            $dataToSend['setup']['title'] = __('Bot') . " " . $campaign->name;
            $dataToSend['setup']['action_name'] = __('Back to bots');
            $dataToSend['setup']['action_link'] = route('replies.index', ['type' => 'bot']);
        } else if ($campaign->is_api) {
            $dataToSend['setup']['title'] = __('API') . " " . $campaign->name;
            $dataToSend['setup']['action_name'] = __('Back to Api');
            $dataToSend['setup']['action_link'] = route('wpbox.api.index', ['type' => 'api']);
        } else {
            //Regular campaign
            //If there is at lease 1 pending message, show action to pause campaign
            /*$pendingMessages = $campaign->messages()->where('status', 0)->count();
            if ($pendingMessages > 0 && $campaign->is_active) {
                $dataToSend['setup']['action_link2'] = route($this->webroute_path . 'pause', $campaign->id);
                $dataToSend['setup']['action_name2'] = __('Pause campaign');
            } else if ($pendingMessages > 0) {
                $dataToSend['setup']['action_link2'] = route($this->webroute_path . 'resume', $campaign->id);
                $dataToSend['setup']['action_name2'] = __('Resume campaign');
            }
            $dataToSend['setup']['action_link3'] = route($this->webroute_path . 'report', $campaign->id);
            $dataToSend['setup']['action_name3'] = __('Download report');*/

            $statusCounts = $campaign->messages()
                ->selectRaw("
              SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as scheduled,
              SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as sending,
              SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as sent,
              SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as delivered,
              SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as `read`,
              SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) as failed
          ")
                ->first();


            $pendingMessages = $statusCounts->scheduled;
            $sendingCount = $statusCounts->sending;
            $sentCount = $statusCounts->sent;
            $deliveredCount = $statusCounts->delivered;
            $readCount = $statusCounts->read;
            $failedCount = $statusCounts->failed;

            $dataToSend['setup']['pendingMessages'] = $pendingMessages;
            $dataToSend['setup']['sendingCount'] = $sendingCount;
            $dataToSend['setup']['sentCount'] = $sentCount;
            $dataToSend['setup']['deliveredCount'] = $deliveredCount;
            $dataToSend['setup']['readCount'] = $readCount;
            $dataToSend['setup']['failedCount'] = $failedCount;

            if ($pendingMessages > 0 && $campaign->is_active) {
                $dataToSend['setup']['action_link2'] = route($this->webroute_path . 'pause', $campaign->id);
                $dataToSend['setup']['action_name2'] = "⏸️ " . __('Pause campaign');
            } else if ($pendingMessages > 0) {
                $dataToSend['setup']['action_link2'] = route($this->webroute_path . 'resume', $campaign->id);
                $dataToSend['setup']['action_name2'] = "▶️ " . __('Resume campaign');
            }
            //$dataToSend['setup']['action_link3']=route($this->webroute_path.'report',$campaign->id);
            $dataToSend['setup']['action_id3'] = "downloadReportBtn";
            $dataToSend['setup']['action_name3'] = "<i class='ki-outline ki-exit-up fs-2'></i>" . __('Download report');
        }
        return view($this->view_path . 'show', $dataToSend);
    }

    /**
     * Auth checker function for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }

    private function componentToVariablesList($template)
    {
        $jsonData = json_decode($template->components, true);

        $variables = [];
        foreach ($jsonData as $item) {

            if ($item['type'] == "HEADER" && $item['format'] == "TEXT") {
                preg_match_all('/{{(\d+)}}/', $item['text'], $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $id) {
                        $exampleValue = "";
                        try {
                            $exampleValue = $item['example']['header_text'][$id - 1];
                        } catch (\Throwable $th) {
                        }
                        $variables['header'][] = ['id' => $id, 'exampleValue' => $exampleValue];
                    }
                }
            } else if ($item['type'] == "HEADER" && $item['format'] == "DOCUMENT") {
                $variables['document'] = true;
            } else if ($item['type'] == "HEADER" && $item['format'] == "IMAGE") {
                $variables['image'] = true;
            } else if ($item['type'] == "HEADER" && $item['format'] == "VIDEO") {
                $variables['video'] = true;
            } else if ($item['type'] == "BODY") {
                preg_match_all('/{{(\d+)}}/', $item['text'], $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $id) {
                        $exampleValue = "";
                        try {
                            $exampleValue = $item['example']['body_text'][0][$id - 1];
                        } catch (\Throwable $th) {
                        }
                        $variables['body'][] = ['id' => $id, 'exampleValue' => $exampleValue];
                    }
                }
            } else if ($item['type'] == "BUTTONS") {
                foreach ($item['buttons'] as $keyBtn => $button) {
                    if ($button['type'] == "URL") {
                        preg_match_all('/{{(\d+)}}/', $button['url'], $matches);

                        if (!empty($matches[1])) {

                            foreach ($matches[1] as $id) {
                                $exampleValue = "";
                                try {
                                    $exampleValue = $button['url'];
                                    $exampleValue = str_replace("{{1}}", "", $exampleValue);
                                } catch (\Throwable $th) {
                                }
                                $variables['buttons'][$id - 1][] = ['id' => $id, 'exampleValue' => $exampleValue, 'type' => $button['type'], 'text' => $button['text']];
                            }
                        }
                    }
                    if ($button['type'] == "COPY_CODE") {
                        $exampleValue = $button['example'][0];
                        $variables['buttons'][$keyBtn][] = ['id' => $keyBtn, 'exampleValue' => $exampleValue, 'type' => $button['type'], 'text' => $button['text']];
                    }
                }
            }
        }
        return $variables;
    }

    // public function create(Request $request)
    // {
    //     $templates = [];
    //     foreach (Template::where('status', 'APPROVED')->get() as $key => $template) {
    //         $templates[$template->id] = $template->name . " - " . $template->language;
    //     }
    //     if (sizeof($templates) == 0) {
    //         //If there are 0 template,re-load them
    //         try {
    //             $this->loadTemplatesFromWhatsApp();
    //             foreach (Template::where('status', 'APPROVED')->get() as $key => $template) {
    //                 $templates[$template->id] = $template->name . " - " . $template->language;
    //             }
    //         } catch (\Throwable $th) {
    //             //throw $th;
    //         }
    //     }
    //     if (sizeof($templates) == 0) {
    //         //Redirect to templates
    //         return redirect()->route('templates.index')->withStatus(__('Please add a template first. Or wait some to be approved'));
    //     }
    //     $groups = Group::pluck('name', 'id');
    //     $groups[0] = __("Send to all contacts");
    //     $selectedTemplate = null;
    //     $variables = null;
    //     if (isset($_GET['template_id'])) {
    //         $selectedTemplate=Template::withoutGlobalScope(\App\Scopes\CompanyScope::class)->where('id',$_GET['template_id'])->first();
    //         $variables = $this->componentToVariablesList($selectedTemplate);
    //     }
    //     $isApiCampaignMaker = $request->has('type') && $request->type === 'api';
    //     $isReminderCampaignMaker = $request->has('type') && $request->type === 'reminder';
    //     $contactFields = [];
    //     if ($isApiCampaignMaker) {
    //         $contactFields[-3] = __('Use API defined value');
    //     }
    //     if ($isReminderCampaignMaker) {
    //         $contactFields[-4] = __('Start date');
    //         $contactFields[-5] = __('Start time');
    //         $contactFields[-6] = __('Start date and time');
    //         $contactFields[-7] = __('End date');
    //         $contactFields[-8] = __('End time');
    //         $contactFields[-9] = __('End date and time');
    //         $contactFields[-10] = __('External ID');
    //     }
    //     $contactFields[-2] = __('Use manually defined value');
    //     $contactFields[-1] = __('Contact name');
    //     $contactFields[0] = __('Contact phone');
    //     foreach (Field::pluck('name', 'id') as $key => $value) {
    //         $contactFields[$key] = $value;
    //     }
    //     $selectedContacts = 0;
    //     if (isset($_GET['group_id'])) {
    //         if ($_GET['group_id'] == "0") {
    //             $selectedContacts = Contact::where('subscribed', 1)->count();
    //         } else {
    //             $group = Group::findOrFail($_GET['group_id']);
    //             $selectedContacts = $group->contacts()->where('subscribed', 1)->count();
    //         }
    //     }
    //     $dataToSend = [
    //         'selectedContacts' => $selectedContacts,
    //         'selectedTemplate' => $selectedTemplate,
    //         'selectedTemplateComponents' => $selectedTemplate ? json_decode($selectedTemplate->components, true) : null,
    //         'contactFields' => $contactFields,
    //         'variables' => $variables,
    //         'groups' => $groups,
    //         'contacts' => Contact::pluck('name', 'id'),
    //         'templates' => $templates,
    //         'isBot' => $request->has('type') && $request->type === 'bot',
    //         'isAPI' => $isApiCampaignMaker,
    //         'isReminder' => $isReminderCampaignMaker
    //     ];
    //     if ($isReminderCampaignMaker) {
    //         $dataToSend['sources'] = \Modules\Reminders\Models\Source::pluck('name', 'id');
    //         $dataToSend['sources'] = collect([0 => __('All')])->union($dataToSend['sources']);
    //     }
    //     return view($this->view_path . 'create', $dataToSend);
    // }


    public function createAjax(Request $request)
    {
        $templates = [];
        foreach (Template::where('status', 'APPROVED')->get() as $key => $template) {
            $templates[$template->id] = $template->name . " - " . $template->language;
        }
        if (sizeof($templates) == 0) {
            //If there are 0 template,re-load them
            try {
                $this->loadTemplatesFromWhatsApp();
                foreach (Template::where('status', 'APPROVED')->get() as $key => $template) {
                    $templates[$template->id] = $template->name . " - " . $template->language;
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        if (sizeof($templates) == 0) {
            //Redirect to templates
            return redirect()->route('templates.index')->withStatus(__('Please add a template first. Or wait some to be approved'));
        }
        $groups = Group::pluck('name', 'id');
        $groups[0] = __("Send to all contacts");
        $selectedTemplate = null;
        $variables = null;
        if (isset($_GET['template_id'])) {
            $selectedTemplate = Template::where('id', $_GET['template_id'])->first();
            $variables = $this->componentToVariablesList($selectedTemplate);
        }
        $isApiCampaignMaker = $request->has('type') && $request->type === 'api';
        $isReminderCampaignMaker = $request->has('type') && $request->type === 'reminder';
        $contactFields = [];
        if ($isApiCampaignMaker) {
            $contactFields[-3] = __('Use API defined value');
        }
        if ($isReminderCampaignMaker) {
            $contactFields[-4] = __('Start date');
            $contactFields[-5] = __('Start time');
            $contactFields[-6] = __('Start date and time');
            $contactFields[-7] = __('End date');
            $contactFields[-8] = __('End time');
            $contactFields[-9] = __('End date and time');
            $contactFields[-10] = __('External ID');
        }
        $contactFields[-2] = __('Use manually defined value');
        $contactFields[-1] = __('Contact name');
        $contactFields[0] = __('Contact phone');
        foreach (Field::pluck('name', 'id') as $key => $value) {
            $contactFields[$key] = $value;
        }
        $selectedContacts = 0;
        if (isset($_GET['group_id'])) {
            if ($_GET['group_id'] == "0") {
                $selectedContacts = Contact::where('subscribed', 1)->count();
            } else {
                $group = Group::findOrFail($_GET['group_id']);
                $selectedContacts = $group->contacts()->where('subscribed', 1)->count();
            }
        }
        $dataToSend = [
            'selectedContacts' => $selectedContacts,
            'selectedTemplate' => $selectedTemplate,
            'selectedTemplateComponents' => $selectedTemplate ? json_decode($selectedTemplate->components, true) : null,
            'contactFields' => $contactFields,
            'variables' => $variables,
            'groups' => $groups,
            'contacts' => Contact::pluck('name', 'id'),
            'templates' => $templates,
            'isBot' => $request->has('type') && $request->type === 'bot',
            'isAPI' => $isApiCampaignMaker,
            'isReminder' => $isReminderCampaignMaker
        ];
        if ($isReminderCampaignMaker) {
            $dataToSend['sources'] = \Modules\Reminders\Models\Source::pluck('name', 'id');
            $dataToSend['sources'] = collect([0 => __('All')])->union($dataToSend['sources']);
        }
        return view($this->view_path . 'create-modal', $dataToSend);
    }


    // public function store(Request $request)
    // {
    //     //Create the campaign
    //     $campaign = $this->provider::create([
    //         'name' => $request->has('name') ? $request->name : "template_message_" . now(),
    //         'timestamp_for_delivery' => $request->has('send_now') ? null : $request->send_time,
    //         'variables' => $request->has('paramvalues') ? json_encode($request->paramvalues) : "",
    //         'variables_match' => json_encode($request->parammatch),
    //         'template_id' => $request->template_id,
    //         'group_id' => $request->group_id . "" == "0" ? null : $request->group_id,
    //         'contact_id' => $request->contact_id,
    //         'total_contacts' => Contact::count(),
    //     ]);

    //     //Check if type is bot
    //     $isBot = $request->has('type') && $request->type === 'bot';
    //     if ($isBot) {
    //         $campaign->is_bot = true;
    //         $campaign->bot_type = $request->reply_type;
    //         $campaign->trigger = $request->trigger;
    //         $campaign->save();
    //     }

    //     $isAPI = $request->has('type') && $request->type === 'api';
    //     if ($isAPI) {
    //         $campaign->is_api = true;
    //         $campaign->save();
    //     }

    //     $isReminder = $request->has('type') && $request->type === 'reminder';
    //     if ($isReminder) {
    //         $campaign->is_reminder = true;
    //         $campaign->save();

    //         //Create the reminder
    //         $reminder = \Modules\Reminders\Models\Remineder::create([
    //             'campaign_id' => $campaign->id,
    //             'name' => $request->has('name') ? $request->name : "template_message_" . now(),
    //             'source_id' => $request->source_id == 0 ? null : $request->source_id,
    //             'type' => $request->reminder_type,
    //             'time' => $request->reminder_time,
    //             'time_type' => $request->reminder_unit,
    //             'status' => 1,
    //         ]);
    //     }

    //     // if ($request->hasFile('pdf')) {
    //     //     $campaign->media_link = $this->saveDocument(
    //     //         "",
    //     //         $request->pdf,
    //     //     );
    //     //     $campaign->update();
    //     // }
    //     // if ($request->hasFile('imageupload')) {
    //     //     $campaign->media_link = $this->saveDocument(
    //     //         "",
    //     //         $request->imageupload,
    //     //     );
    //     //     $campaign->update();
    //     // }

    //     if (isset($request->medias[0])) {

    //         if (strpos($request->medias[0], "http") !== FALSE) {

    //             $media_link = get_file_url($request->medias[0]);
    //             if ($media_link) {
    //                 $campaign->media_link = $media_link;
    //                 $campaign->update();
    //             }
    //         } else {

    //             $media_id = $request->medias[0];
    //             if ($media_id) {
    //                 $media_result = FileManager::where('ids', $media_id)->first();

    //                 if ($media_result) {
    //                     $media_link = get_file_url($media_result->file);

    //                     if ($media_link) {
    //                         if (strpos($media_link, "digitaloceanspaces.com") !== FALSE) {
    //                             //force cdn refrence in sharable url cdn convert
    //                             $do_cdn_path = env('DO_CDN_PATH');
    //                             $do_path = env('DO_PATH');
    //                             if ($do_cdn_path && $do_path) {
    //                                 $media_link = str_replace($do_path, $do_cdn_path, $media_link); //cdn path
    //                             }
    //                         }

    //                         $campaign->media_link = $media_link;

    //                         $campaign->update();
    //                     }
    //                 }
    //             }
    //         }
    //     }




    //     if ($isBot) {
    //         //Bot campaign
    //         return redirect()->route('replies.index', ['type' => 'bot'])->withStatus(__('You have created a new bot.'));
    //     } else if ($isAPI) {
    //         //API campaign
    //         return redirect()->route('wpbox.api.index', ['type' => 'api'])->withStatus(__('You have created new API Campaigns.'));
    //     } else if ($isReminder) {
    //         //Reminder campaign
    //         return redirect()->route('reminders.reminders.index')->withStatus(__('You have created a new reminder.'));
    //     } else {
    //         //Regular campaign
    //         //Make the actual messages
    //         $campaign->makeMessages($request);

    //         if ($request->has('contact_id')) {
    //             return redirect()->route('chat.index')->withStatus(__('Message will be send shortly. Please note that if new contact, it will not appear in this list until the contact start interacting with you!'));
    //         } else {
    //             return redirect()->route($this->webroute_path . 'index')->withStatus(__('Campaign is ready to be send'));
    //         }
    //     }
    // }



    public function sendSchuduledMessages()
    {
        //Find all unsent Messages that are within the timeline
        $limit = 100;

        //campaign_sending_batch
        try {
            $limit = (int) config('wpbox.campaign_sending_batch', 100);

            //Limit must be number
            if (!is_numeric($limit)) {
                $limit = 100;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        $messagesToBeSend = Message::where('status', 0)
            ->where('scchuduled_at', '<', Carbon::now())
            ->whereIn('campaign_id', function ($query) {
                $query->select('id')
                    ->from('wa_campaings')
                    ->where('is_active', true);
            })
            ->limit($limit)
            ->get();
        foreach ($messagesToBeSend as $key => $message) {
            if (config('wpbox.campaign_sending_type', 'normal') == "normal") {
                //Old way - send all at once
                $this->sendCampaignMessageToWhatsApp($message);
            } else {
                dispatch(new SendMessage($message));
            }
        }
    }

    //Delete campaign, only if type is BOT
    public function destroy($id)
    {
        Campaign::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }


    public function destroys(Campaign $campaign)
    {
        try {
            // Check if campaign can be deleted
            if (!$campaign->is_bot && !$campaign->is_api) {
                return response()->json([
                    'success' => false,
                    'message' => __('You can only delete bot or API campaigns'),
                ], 403);
            }

            // Delete the campaign
            $campaign->delete();

            // Determine success message and redirect path
            $message = $campaign->is_api
                ? __('API Campaign deleted')
                : __('Bot deleted');

            $redirectPath = $campaign->is_api
                ? route('wpbox.api.index', ['type' => 'api'])
                : route('replies.index', ['type' => 'bot']);

            // Return JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => $redirectPath
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    //Activate bot
    public function activateBot(Campaign $campaign)
    {
        $campaign->is_bot_active = true;
        $campaign->save();
        return redirect()->route('replies.index', ['type' => 'bot'])->withStatus(__('Bot activated'));
    }

    //Deactivate bot
    public function deactivateBot(Campaign $campaign)
    {
        $campaign->is_bot_active = false;
        $campaign->save();
        return redirect()->route('replies.index', ['type' => 'bot'])->withStatus(__('Bot deactivated'));
    }

    //Pause campaign
    public function pause(Campaign $campaign)
    {
        $campaign->is_active = false;
        $campaign->save();
        return redirect()->route($this->webroute_path . 'show', $campaign)->withStatus(__('Campaign paused'));
    }

    //Resume campaign
    public function resume(Campaign $campaign)
    {
        $campaign->is_active = true;
        $campaign->save();
        return redirect()->route($this->webroute_path . 'show', $campaign)->withStatus(__('Campaign resumed'));
    }

    //Download report
    /*public function report(Campaign $campaign)
    {
        $filename = "report_campaign_" . $campaign->id . "_" . now() . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Name', 'Phone', 'Country', 'Status', 'Sent at', 'Last status update', 'Extra'));
        foreach ($campaign->messages as $key => $message) {
            //Status
            $status = "";

            $error = $message->error;
            $orgStatus = $message->getOriginal('status');

            if ($orgStatus == 0) {
                $status = "PENDING_SENT";
            } else if ($orgStatus == 1 || $orgStatus == 2) {
                $status = "SENT";
            } else if ($orgStatus == 3) {
                $status = "DELIVERED";
            } else if ($orgStatus == 4) {
                $status = "READ";
            } else if ($orgStatus == 5) {
                $status = "FAILED";
            }
            
            try {
                fputcsv($handle, array($message->contact->name, $message->contact->phone, $message->contact->country->name, $status, $message->scchuduled_at ? $message->scchuduled_at : $message->created_at, $message->updated_at, $error));
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    } */

    public function report(Request $request, Campaign $campaign)
    {
        $filter = $request->input('filter');

        $filteredMessages = $campaign->messages()->when($filter !== 'all', function ($query) use ($filter) {
            switch ($filter) {
                case 'pending':
                    return $query->where('status', 0);
                case 'ignored':
                    return $query->where('status', 3);
                case 'read':
                    return $query->where('status', 4);
                case 'read_ignored':
                    return $query->whereIn('status', [3, 4]);
                case 'sent':
                    return $query->whereIn('status', [1, 2]);
                case 'failed':
                    return $query->where('status', 5);
                default:
                    return $query;
            }
        })->get();

        if ($filteredMessages->count() === 0) {
            return response()->json(['error' => 'No audience available for the selected filter.'], 400);
        }

        $filename = "report_campaign_" . $campaign->id . "_" . now()->format('YmdHis') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Name', 'Phone', 'Country', 'Status', 'Sent at', 'Last status update', 'Extra']);

        foreach ($filteredMessages as $message) {
            $status = match ($message->status) {
                0 => "PENDING_SENT",
                1, 2 => "SENT",
                3 => "DELIVERED",
                4 => "READ",
                5 => "FAILED",
                default => "UNKNOWN"
            };

            // Check if contact exists
            $contactName = $message->contact?->name ?? 'N/A';
            $contactPhone = $message->contact?->phone ?? 'N/A';
            $countryName = $message->contact?->country?->name ?? 'N/A';

            fputcsv($handle, [
                $contactName,
                $contactPhone,
                $countryName,
                $status,
                $message->scchuduled_at ?? $message->created_at,
                $message->updated_at,
                $message->error
            ]);
        }

        fclose($handle);
        return response()->download($filename, $filename, ['Content-Type' => 'text/csv'])->deleteFileAfterSend(true);
    }

    private function filterMessage($message, $filter)
    {
        return match ($filter) {
            'pending' => $message->getOriginal('status') == 0,
            'sent' => in_array($message->getOriginal('status'), [1, 2]),
            'read' => $message->getOriginal('status') == 4,
            'failed' => $message->getOriginal('status') == 5,
            'ignored' => $message->getOriginal('status') == 3,
            'read_ignored' => in_array($message->getOriginal('status'), [3, 4]),
            default => true
        };
    }

    public function create(Request $request)
    {
        //catalog
        $type = $request->templates_type ?? 0;
        $groupId = $request->group ?? 0;

        $templates = [];

        $templatesList = Template::where('type', $type)
            ->where('status', 'APPROVED')
            ->get();

        foreach ($templatesList as $template) {
            $templates[$template->id] = $template->name . " - " . $template->language;
        }

        if (empty($templates)) {
            // If there are 0 templates, re-load them
            try {
                $this->loadTemplatesFromWhatsApp();

                // Re-fetch after loading
                $templatesList = Template::where('type', $type)
                    ->where('status', 'APPROVED')
                    ->get();

                foreach ($templatesList as $template) {
                    $templates[$template->id] = $template->name . " - " . $template->language;
                }
            } catch (\Throwable $th) {
                // Optionally log the error
                // Log::error($th);
            }
        }

        if (sizeof($templates) == 0) {
            //Redirect to templates
            return redirect()->route('templates.index')->withStatus(__('Please add a template first. Or wait some to be approved'));
        }

        $groups = null;
        if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_assigned_group_only', 'false') != 'false') {
            $groups = Group::where('user_id', auth()->user()->id)->pluck('name', 'id');
        } else {
            $groups = Group::pluck('name', 'id');
        }

        $groups[0] = __("Send to all contacts");


        $selectedTemplate = null;
        $variables = null;
        if (isset($_GET['template_id'])) {
            $selectedTemplate = Template::withoutGlobalScope(\App\Scopes\CompanyScope::class)->where('id', $_GET['template_id'])->first();
            $variables = $this->componentToVariablesList($selectedTemplate);
        }

        $isApiCampaignMaker = $request->has('type') && $request->type === 'api';
        $isReminderCampaignMaker = $request->has('type') && $request->type === 'reminder';

        $contactFields = [];
        if ($isApiCampaignMaker) {
            $contactFields[-3] = __('Use API defined value');
        }

        if ($isReminderCampaignMaker) {
            //Add Start date, Start time, Start Date And time, End date, End time and End date and time
            $contactFields[-4] = __('Start date');
            $contactFields[-5] = __('Start time');
            $contactFields[-6] = __('Start date and time');
            $contactFields[-7] = __('End date');
            $contactFields[-8] = __('End time');
            $contactFields[-9] = __('End date and time');
            $contactFields[-10] = __('External ID');
        }

        $contactFields[-2] = __('Use manually defined value');
        $contactFields[-1] = __('Contact name');
        $contactFields[0] = __('Contact phone');
        foreach (Field::pluck('name', 'id') as $key => $value) {
            $contactFields[$key] = $value;
        }

        $campaignResendId = $request->resend ?? null;
        $rType = $request->rtype ?? null;
        $statusMapping = [
            'SENT' => [1, 2],
            'READ_IGNORED' => [3, 4],
            'IGNORED' => [3],
            'READ' => [4],
            'FAILED' => [5]
        ];

        $selectedContacts = 0;
        if ($campaignResendId) {
            if ($rType === 'all') {
                $selectedContacts = Message::where('campaign_id', $campaignResendId)->count();
            } else {
                $statuses = $statusMapping[strtoupper($rType)] ?? [];

                $selectedContacts = Message::where('campaign_id', $campaignResendId)
                    ->whereIn('status', $statuses)
                    ->count();
            }
        } else {
            if (isset($_GET['group_id'])) {
                if ($_GET['group_id'] == "0") {
                    if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_assigned_contacts_only', 'false') != 'false') {
                        $selectedContacts = Contact::where('user_id', auth()->user()->id)->where('subscribed', 1)->count();
                    } else {
                        $selectedContacts = Contact::where('subscribed', 1)->count();
                    }
                } else {
                    $group = Group::findOrFail($_GET['group_id']);
                    $selectedContacts = $group->contacts()->where('subscribed', 1)->count();
                }
            }
        }
        // In the create method, add this line to get AutoRetarget campaigns
        $autoretargetCampaigns = AutoRetargetCampaign::where('is_active', true)->get();

        $company_id = $this->getCompany()->id;

        $dataToSend = [
            'selectedContacts' => $selectedContacts,
            'campaignResendId' => $campaignResendId,
            'rtype' => $rType,
            'selectedTemplate' => $selectedTemplate,
            'selectedTemplateComponents' => $selectedTemplate ? json_decode($selectedTemplate->components, true) : null,
            'contactFields' => $contactFields,
            'variables' => $variables,
            'groups' => $groups,
            'templates_type'  => $type, //catalog
            'contacts' => Contact::pluck('name', 'id'),
            'company_id' => $company_id,
            'templates' => $templates,
            'isBot' => $request->has('type') && $request->type === 'bot',
            'isAPI' => $isApiCampaignMaker,
            'isReminder' => $isReminderCampaignMaker,
            'autoretargetCampaigns' => $autoretargetCampaigns,
            'autoretarget_enabled' => $request->has('autoretarget_enabled'),
            'autoretarget_campaign_id' => $request->autoretarget_campaign_id
        ];

        if ($isReminderCampaignMaker) {
            $dataToSend['sources'] = \Modules\Reminders\Models\Source::pluck('name', 'id');
            //Prepend the all source
            $dataToSend['sources'] = collect([0 => __('All')])->union($dataToSend['sources']);
        }

        return view($this->view_path . 'create', $dataToSend);
    }

    public function MessageSendstore(Request $request)
    {

        $data = $request->all();
        $templateId = $data['template_id'];
        $contactId = $data['contact_id'];
        $paramValues = $data['paramvalues'] ?? [];
        $companyId = auth()->user()->company->id;
        $campaign = $this->provider::create([
            'name' => $request->has('name') ? $request->name : "template_message_" . now(),
            'timestamp_for_delivery' => $request->has('send_now') ? null : $request->send_time,
            'variables' => $request->has('paramvalues') ? json_encode($request->paramvalues) : "",
            'variables_match' => json_encode($request->parammatch),
            'template_id' => $request->template_id,
            'group_id' => $request->group_id . "" == "0" ? null : $request->group_id,
            'contact_id' => $request->contact_id,
            'total_contacts' => Contact::count(),
        ]);
        $message_data = $campaign->makeMessagesContact($request);


        // Fetch access token and phone number ID for WhatsApp Business API
        $whatsappPermanentAccessToken = Config::where('model_id', $companyId)
            ->where('key', 'whatsapp_permanent_access_token')
            ->first();

        $whatsappPhoneNumberId = Config::where('model_id', $companyId)
            ->where('key', 'whatsapp_phone_number_id')
            ->first();

        if (!$whatsappPermanentAccessToken || !$whatsappPhoneNumberId) {
            return response()->json(['status' => 'error', 'message' => 'Configuration not found'], 400);
        }

        $accessToken = $whatsappPermanentAccessToken->value;
        $whatsappBusinessPhoneNumberId = $whatsappPhoneNumberId->value;

        $template = Template::where('id', $templateId)->first();

        // Fetch contact details
        $contact = Contact::findOrFail($contactId);

        // Prepare components dynamically based on parameter values
        $components = [];
        if (isset($paramValues['body'])) {
            $bodyParameters = [];
            foreach ($paramValues['body'] as $index => $value) {
                $bodyParameters[] = [
                    'type' => 'text',
                    'text' => $value,
                ];
            }

            $components[] = $message_data['components'];
        }

        // WhatsApp API endpoint
        $apiUrl = 'https://graph.facebook.com/v17.0/' . $whatsappBusinessPhoneNumberId . '/messages';

        // Prepare message payload
        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $contact->phone,
            'type' => 'template',
            'template' => [
                'name' => $template->name,
                'language' => [
                    'code' => 'en_US',
                ],
                'components' => json_decode($message_data['components']),
            ],
        ];



        // Send HTTP POST request to the WhatsApp API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        // Handle response
        if ($response->successful()) {
            $responseData = $response->json();

            // Save message record
            $message = new Message();
            $message->fb_message_id = $responseData['messages'][0]['id'] ?? null;
            $message->contact_id = $contactId;
            $message->company_id = $contact->company_id;
            $message->value = $message_data['value'];
            $message->status = 2; // Sent
            $message->components = $message_data['components'];
            $message->is_message_by_contact = 0;
            $message->message_type = 1;
            $message->save();

            return redirect()->route('contacts.index')->withStatus(__('Message Send'));

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Message sent successfully',
            //     'response' => $responseData,
            // ]);
        } else {
            $responseData = $response->json();

            // Save error record
            $message = new Message();
            $message->contact_id = $contactId;
            $message->company_id = $contact->company_id;
            $message->error = $responseData['error']['message'] ?? 'Unknown error';
            $message->status = 0; // Failed
            $message->save();

            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Failed to send message',
            //     'response' => $responseData,
            // ], $response->status());

            return redirect()->route('contacts.index')->withStatus(__('Message pending'));
        }
    }

    ///catalog
    public function createSlider(Request $request)
    {

        $type = $request->templates_type ?? 0;
        $groupId = $request->group ?? 0;
        $templates = [];
        foreach (Template::where('components', 'like', '%' . 'header_handle' . '%')->where('type', $type)->get() as $key => $template) {
            $templates[$template->id] = $template->name . " - " . $template->language;
        }
        if (sizeof($templates) == 0) {
            //If there are 0 template,re-load them
            try {
                $this->loadTemplatesFromWhatsApp();
                foreach (Template::where('components', 'like', '%' . 'header_handle' . '%')->where('type', '1')->get() as $key => $template) {
                    $templates[$template->id] = $template->name . " - " . $template->language;
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }



        if (sizeof($templates) == 0) {
            //Redirect to templates
            return redirect()->route('templates.index')->withStatus(__('Please add a template first. Or wait some to be approved'));
        }

        if ($groupId == 0) {
            $groups = Group::pluck('name', 'id');
            $groups[0] = __("Send to all contacts");
        } else {
            $groups = Group::where('id', $groupId)->pluck('name', 'id');
        }


        $selectedTemplate = null;
        $variables = null;
        if (isset($_GET['template_id'])) {
            $selectedTemplate = Template::where('id', $_GET['template_id'])->first();
            $variables = $this->componentToVariablesList($selectedTemplate);
        }

        $isApiCampaignMaker = $request->has('type') && $request->type === 'api';

        $contactFields = [];
        if ($isApiCampaignMaker) {
            $contactFields[-3] = __('Use API defined value');
        }

        $contactFields[-2] = __('Use manually defined value');
        $contactFields[-1] = __('Contact name');
        $contactFields[0] = __('Contact phone');
        foreach (Field::pluck('name', 'id') as $key => $value) {
            $contactFields[$key] = $value;
        }

        $selectedContacts = 0;
        if (isset($_GET['group_id'])) {
            if ($_GET['group_id'] == "0") {
                $selectedContacts = Contact::where('subscribed', 1)->count();
            } else {
                $group = Group::findOrFail($_GET['group_id']);
                $selectedContacts = $group->contacts()->where('subscribed', 1)->count();
            }
        }

        $company_id = $this->getCompany()->id;

        return view($this->view_path . 'slider', [
            'selectedContacts' => $selectedContacts,
            'selectedTemplate' => $selectedTemplate,
            'selectedTemplateComponents' => $selectedTemplate ? json_decode($selectedTemplate->components, true) : null,
            'contactFields' => $contactFields,
            'variables' => $variables,
            'groups' => $groups,
            'templates_type'  => $type,
            'contacts' => Contact::pluck('name', 'id'),
            'templates' => $templates,
            'company_id' => $company_id,
            'isBot' => $request->has('type') && $request->type === 'bot',
            'isAPI' => $isApiCampaignMaker,
        ]);
    }

    public function MessageSendcreate(Request $request)
    {

        $type = $request->templates_type ?? 0;
        $templates = [];
        foreach (Template::where('type', $type)->where('status', 'APPROVED')->get() as $key => $template) {
            $templates[$template->id] = $template->name . " - " . $template->language;
        }
        if (sizeof($templates) == 0) {
            //If there are 0 template,re-load them
            try {
                $this->loadTemplatesFromWhatsApp();
                foreach (Template::where('type', $type)->where('status', 'APPROVED')->get() as $key => $template) {
                    $templates[$template->id] = $template->name . " - " . $template->language;
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }



        if (sizeof($templates) == 0) {
            //Redirect to templates
            return redirect()->route('templates.index')->withStatus(__('Please add a template first. Or wait some to be approved'));
        }

        $groups = Group::pluck('name', 'id');
        $groups[0] = __("Send to all contacts");

        $selectedTemplate = null;
        $variables = null;
        if (isset($_GET['template_id'])) {
            $selectedTemplate = Template::where('id', $_GET['template_id'])->first();
            $variables = $this->componentToVariablesList($selectedTemplate);
        }

        $isApiCampaignMaker = $request->has('type') && $request->type === 'api';

        $contactFields = [];
        if ($isApiCampaignMaker) {
            $contactFields[-3] = __('Use API defined value');
        }

        $contactFields[-2] = __('Use manually defined value');
        $contactFields[-1] = __('Contact name');
        $contactFields[0] = __('Contact phone');
        foreach (Field::pluck('name', 'id') as $key => $value) {
            $contactFields[$key] = $value;
        }

        $selectedContacts = 0;
        if (isset($_GET['group_id'])) {
            if ($_GET['group_id'] == "0") {
                $selectedContacts = Contact::where('subscribed', 1)->count();
            } else {
                $group = Group::findOrFail($_GET['group_id']);
                $selectedContacts = $group->contacts()->where('subscribed', 1)->count();
            }
        }
        return view($this->view_path . 'messagenumbercreate', [
            'selectedContacts' => $selectedContacts,
            'selectedTemplate' => $selectedTemplate,
            'selectedTemplateComponents' => $selectedTemplate ? json_decode($selectedTemplate->components, true) : null,
            'contactFields' => $contactFields,
            'variables' => $variables,
            'groups' => $groups,
            'templates_type'  => $type,
            'contacts' => Contact::pluck('name', 'id'),
            'templates' => $templates,
            'isBot' => $request->has('type') && $request->type === 'bot',
            'isAPI' => $isApiCampaignMaker,
        ]);
    }

    public function store(Request $request)
    {
        try {

            $name = ($request->has('resend') && $request->has('rtype'))
                ? "smart_retargeting_" . $request->rtype . '_' . now()
                : ($request->has('name') ? $request->name : "template_message_" . now());

            $campaignResendId = $request->resend ?? null;
            $rType = $request->rtype ?? null;

            $campaign = $this->provider::create([
                'name' => $name,
                'timestamp_for_delivery' => $request->has('send_now') ? null : $request->send_time,
                'variables' => $request->has('paramvalues') ? json_encode($request->paramvalues) : "",
                'variables_match' => json_encode($request->parammatch),
                'template_id' => $request->template_id,
                'smart_retarget_id' => $campaignResendId,
                'smart_retarget_type' => $rType,
                'group_id' => $request->group_id . "" == "0" ? null : $request->group_id,
                'contact_id' => $request->contact_id,
                'total_contacts' => Contact::count(),
                'autoretarget_enabled' => $request->autoretarget_enabled ?? false,
                'autoretarget_campaign_id' => !empty($request->autoretarget_campaign_id) ? $request->autoretarget_campaign_id
                    : null,
            ]);

            if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_created_campaigns_only', 'false') != 'false') {
                $campaign->user_id = auth()->user()->id;
                $campaign->save();
            }

            // Process Bot, API, Reminder
            if ($request->has('type')) {
                switch ($request->type) {
                    case 'bot':
                        $campaign->is_bot = true;
                        $campaign->bot_type = $request->reply_type;
                        $campaign->trigger = $request->trigger;
                        $campaign->save();
                        break;

                    case 'api':
                        $campaign->is_api = true;
                        $campaign->save();
                        break;

                    case 'reminder':
                        $campaign->is_reminder = true;
                        $campaign->save();
                        \Modules\Reminders\Models\Remineder::create([
                            'campaign_id' => $campaign->id,
                            'name' => $request->has('name') ? $request->name : "template_message_" . now(),
                            'source_id' => $request->source_id == 0 ? null : $request->source_id,
                            'type' => $request->reminder_type,
                            'time' => $request->reminder_time,
                            'time_type' => $request->reminder_unit,
                            'status' => 1,
                        ]);
                        break;
                }
            }

            // Handle file uploads
            if (isset($request->medias[0])) {

                if (strpos($request->medias[0], "http") !== FALSE) {

                    $media_link = get_file_url($request->medias[0]);
                    if ($media_link) {
                        $campaign->media_link = $media_link;
                        $campaign->update();
                    }
                } else {

                    $media_id = $request->medias[0];
                    if ($media_id) {
                        $media_result = FileManager::where('ids', $media_id)->first();

                        if ($media_result) {
                            $media_link = get_file_url($media_result->file);

                            if ($media_link) {
                                if (strpos($media_link, "digitaloceanspaces.com") !== FALSE) {
                                    //force cdn refrence in sharable url cdn convert
                                    $do_cdn_path = env('DO_CDN_PATH');
                                    $do_path = env('DO_PATH');
                                    if ($do_cdn_path && $do_path) {
                                        $media_link = str_replace($do_path, $do_cdn_path, $media_link); //cdn path
                                    }
                                }

                                $campaign->media_link = $media_link;

                                $campaign->update();
                            }
                        }
                    }
                }
            }


            $isBot = $request->has('type') && $request->type === 'bot';
            $isAPI = $request->has('type') && $request->type === 'api';
            $isReminder = $request->has('type') && $request->type === 'reminder';
            if ($isBot) {
                //Bot campaign
                $redirect = route('replies.index', ['type' => 'bot']);
                $message = 'You have created a new bot.';
            } else if ($isAPI) {
                //API campaign
                $redirect = route('wpbox.api.index', ['type' => 'api']);
                $message = 'You have created new API Campaigns.';
            } else if ($isReminder) {
                //Reminder campaign
                $redirect = route('reminders.reminders.index');
                $message = 'You have created a new reminder.';
            } else {
                //Regular campaign
                // catalog
                // $template = Template::where('id',$request->template_id)->first();
                // if(isset($request['product_retailer_id']) && count($request['product_retailer_id']) > 0){
                //     $campaign->makeMessagesCarousel($request);
                // }elseif(isset($request['slider_id']) && $request['slider_id'] == 'slider'){
                //     $data21 = $campaign->makeMessagesCarouselSlider($request);
                // }
                // else{
                //     if($template->type == '1'){
                //         $campaign->makeMessagesCatalog($request);
                //     }
                //     else{
                //         $campaign->makeMessages($request);
                //     }
                // }
                // // $campaign->makeMessages($request);
                // $message = 'Campaign created successfully!';
                // $redirect = $request->has('contact_id') 
                //     ? route('chat.index') 
                //     : route($this->webroute_path . 'index');
                // Regular campaign - dispatch the master job
                ProcessCampaign::dispatch($campaign, $request->all());

                $message = 'Campaign created successfully!';
                $redirect = $request->has('contact_id')
                    ? route('chat.index')
                    : route($this->webroute_path . 'index');
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'redirect' => $redirect
                ]);
            }

            return redirect($redirect)->withStatus(__('Campaign is ready to be sent'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create campaign. ' . $e->getMessage()
            ], 500);
        }
    }

    //catalog
    public function reply(Request $req, $id, $button)
    {
        $campaign = Campaign::where('id', $id)->first();

        $messages = Message::where('campaign_id', $campaign->id)->get();
        $messageIDs = $messages->pluck('fb_message_id')->toArray();

        $messageReplies = Message::with('contact')->whereIn('fb_reply_message_id', $messageIDs)
            ->where('value', $button)
            ->where('is_message_by_contact', 1)
            ->paginate(config('settings.paginate'));

        $phoneNumbers = $messageReplies->pluck('contact.phone')->unique()->toArray();
        $company_id = $this->getCompany()->id;
        $contactToApply = Contact::where('company_id', $company_id)->whereIn('phone', $phoneNumbers)->pluck('id');

        $safeButton = preg_replace('/[^a-zA-Z0-9_]/', '', $button);

        $groupname = $campaign->name . '_' . $safeButton;

        $groupCheck =  Group::where('name', $groupname)->where('company_id', $company_id)->first();
        if (!$groupCheck) {
            $group = new Group();
            $group->name = $groupname;
            $group->company_id = $company_id;
            $group->save();
            $groupId = $group->id;
        } else {
            $groupId = $groupCheck->id;
        }

        if ($contactToApply) {
            $group = Group::find($groupId);
            $exists = $group->contacts()->whereIn('contact_id', $contactToApply)->exists();

            if (!$exists) {
                $group->contacts()->attach($contactToApply);
            }
        }


        return view($this->view_path . 'reply', ['setup' => [
            'countriesCount' => 34,
            'title' => __('Reply') . " : " . $button,
            'action_link' => route($this->webroute_path . 'index'),
            'action_name' => "📢 " . __('Back'),
            'action_link2' => route($this->webroute_path . 'create', [
                'templates_type' =>  0,
                'group' => $groupId
            ]),
            'action_name2' => __('Send new campaign') . " 📢",

            'items' => $messageReplies,
            'item_names' => $this->titlePlural,
            'webroute_path' => $this->webroute_path,
            'fields' => [],
            'custom_table' => true,
            'parameter_name' => $this->parameter_name,
            'parameters' => count($_GET) != 0,
        ]]);
    }
}
