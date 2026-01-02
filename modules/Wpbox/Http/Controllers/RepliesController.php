<?php

namespace Modules\Wpbox\Http\Controllers;

use Modules\Wpbox\Models\FileManager;
use Modules\Wpbox\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\RepliesButton;
use Modules\Wpbox\Models\RepliesListButton;
use Modules\Wpbox\Models\Template;

class RepliesController extends Controller
{
    private $provider = Reply::class;
    private $webroute_path = 'replies.';
    private $view_path = 'wpbox::replies.';
    private $parameter_name = 'reply';
    private $title = 'reply';
    private $titlePlural = 'replies';

    /**
     * Get fields configuration based on type
     */
    private function getFields($class = 'col-md-4 mt-2', $type = 'bot')
    {
        $fields = [['class' => $class, 'ftype' => 'input', 'name' => 'Name', 'id' => 'name', 'placeholder' => 'Enter name', 'required' => true], ['class' => $class, 'ftype' => 'textarea', 'name' => 'Reply text', 'id' => 'text', 'placeholder' => 'Enter reply text', 'required' => true, 'additionalInfo' => __('Text that will be send to contact. You can also use {{ name }},{{ phone }} on any other custom field name')]];

        // Add type field with appropriate options
        $typeOptions = [
            '1' => __('Just a quick reply'),
            '2' => __('Reply bot: On exact match'),
            '3' => __('Reply bot: When message contains'),
        ];

        if ($type !== 'catalog') {
            $typeOptions['4'] = __('Welcome reply - when client send the first message');
        }

        $fields[] = [
            'class' => $class,
            'value' => '1',
            'ftype' => 'select',
            'name' => 'Reply type',
            'id' => 'type',
            'placeholder' => 'Select reply type',
            'data' => $typeOptions,
            'required' => true,
        ];

        // Add trigger field
        $fields[] = [
            'class' => $class,
            'ftype' => 'input',
            'name' => 'Trigger',
            'id' => 'trigger',
            'placeholder' => 'Enter bot reply trigger',
            'required' => false,
        ];

        // Add additional fields for bots
        if ($type !== 'qr') {
            if ($type === 'catalog') {
                $fields[] = [
                    'class' => $class,
                    'additionalInfo' => 'Optional, footer text',
                    'ftype' => 'input',
                    'name' => 'Footer',
                    'id' => 'footer',
                    'placeholder' => 'Enter footer',
                    'required' => false,
                ];
            } else {
                // Regular bot fields
                $botFields = [
                    ['class' => $class, 'additionalInfo' => 'Optional, header text', 'ftype' => 'input', 'name' => 'Header', 'id' => 'header', 'placeholder' => 'Enter header', 'required' => false],
                    ['class' => $class, 'additionalInfo' => 'Optional, footer text', 'ftype' => 'input', 'name' => 'Footer', 'id' => 'footer', 'placeholder' => 'Enter footer', 'required' => false],
                    ['class' => $class, 'separator' => 'Option 1: Bot with reply buttons', 'additionalInfo' => 'Optional, button1 text', 'ftype' => 'input', 'name' => 'Button1', 'id' => 'button1', 'placeholder' => 'Enter button1', 'required' => false],
                    ['class' => $class, 'additionalInfo' => 'Optional, button1 ID', 'ftype' => 'input', 'name' => 'Button1 ID', 'id' => 'button1_id', 'placeholder' => 'Enter button1 ID', 'required' => false],
                    ['class' => $class, 'additionalInfo' => 'Optional, button2 text', 'ftype' => 'input', 'name' => 'Button2', 'id' => 'button2', 'placeholder' => 'Enter button2', 'required' => false],
                    ['class' => $class, 'additionalInfo' => 'Optional, button2 ID', 'ftype' => 'input', 'name' => 'Button2 ID', 'id' => 'button2_id', 'placeholder' => 'Enter button2 ID', 'required' => false],
                    ['class' => $class, 'additionalInfo' => 'Optional, button3 text', 'ftype' => 'input', 'name' => 'Button3', 'id' => 'button3', 'placeholder' => 'Enter button3', 'required' => false],
                    ['class' => $class, 'additionalInfo' => 'Optional, button3 ID', 'ftype' => 'input', 'name' => 'Button3 ID', 'id' => 'button3_id', 'placeholder' => 'Enter button3 ID', 'required' => false],
                    ['class' => $class, 'separator' => 'Option 2: Bot with button link - CTA URL', 'additionalInfo' => 'The button name', 'ftype' => 'input', 'name' => 'Button name', 'id' => 'button_name', 'placeholder' => 'Enter button name', 'required' => false],
                    ['class' => $class, 'additionalInfo' => 'Button URL - Link', 'ftype' => 'input', 'name' => 'Button link', 'id' => 'button_url', 'placeholder' => 'Enter button url', 'required' => false],
                ];
                $fields = array_merge($fields, $botFields);
            }
        }

        return $fields;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authChecker();

        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }

        $isQuickReplies = $request->has('type') && $request->get('type') === 'qr';
        $botType = $request->get('bot', 'regular');

        $items = $this->getItems($request, $isQuickReplies, $botType);
        $setup = $this->getSetupConfig($request, $items, $isQuickReplies, $botType);

        $items = $this->provider
            ::orderBy('id', 'desc')
            ->paginate(1)
            ->appends(request()->query());

        if ($isQuickReplies) {
            $fields_create = $this->getFields('col-md-6', 'qr');
            unset($fields_create[2]['data'][3], $fields_create[2]['data'][2], $fields_create[2]['data'][4]);

            return view($this->view_path . 'index', [
                'setup' => $setup,
                'setup_create' => [
                    'title' => __('crud.new_item', ['item' => __('Quick Reply')]),
                    'action_link' => route($this->webroute_path . 'index', ['type' => 'qr']),
                    'action_name' => __('crud.back'),
                    'iscontent' => true,
                    'action' => route($this->webroute_path . 'store'),
                ],
                'fields_create' => $fields_create,
                'view' => 'qr',
            ]);
        }

        return view($this->view_path . 'index', [
            'setup' => $setup,
            'view' => 'bot',
        ]);
    }

    /**
     * Get items based on request parameters
     */
    private function getItems(Request $request, $isQuickReplies, $botType)
    {
        if ($isQuickReplies) {
            return $this->provider::where('type', 1)->orderBy('id', 'desc')->where('flow_id', null)->paginate(config('settings.paginate'));
        }

        if ($botType === 'catalog') {
            $items = $this->provider::where('bot_type', 1)->where('type', '!=', 1)->where('flow_id', null)->orderBy('id', 'desc');

            $template = Template::where('type', 1)->pluck('id')->toArray();
            $template_bots = Campaign::with('Template')->whereIn('template_id', $template)->orderBy('id', 'desc')->whereNull('contact_id')->where('is_bot', true);

            return $items->get()->merge($template_bots->get());
        }

        $items = $this->provider::where('bot_type', 0)->where('type', '!=', 1)->where('flow_id', null)->orderBy('id', 'desc');

        $template_not = Template::where('type', 0)->pluck('id')->toArray();
        $template_bots = Campaign::with([
            'Template' => function ($query) {
                $query->where('type', 0);
            },
        ])
            ->orderBy('id', 'desc')
            ->whereNull('contact_id')
            ->where('is_bot', true);

        return $items->get()->merge($template_bots->get());
    }

    /**
     * Get setup configuration for the view
     */
    private function getSetupConfig(Request $request, $items, $isQuickReplies, $botType)
    {
        $setup = [
            'usefilter' => null,
            'items' => $items,
            'item_names' => $this->titlePlural,
            'webroute_path' => $this->webroute_path,
            'fields' => $this->getFields('col-md-3', $isQuickReplies ? 'qr' : 'bot'),
            'filterFields' => $this->getFilterFields(),
            'custom_table' => true,
            'parameter_name' => $this->parameter_name,
            'parameters' => count($request->query()) != 0,
            'hidePaging' => !$isQuickReplies,
        ];

        if ($botType === 'catalog') {
            $setup['title'] = __('Catalog Bots management');
            $setup['action_link'] = route($this->webroute_path . 'create', ['type' => 'bot', 'bot_type' => 'catalog']);
            $setup['action_name'] = __('Create message bot');
            $setup['bot_type'] = 'catalog';
        } else {
            $setup['title'] = __('Bots management');
            $setup['action_link'] = route($this->webroute_path . 'create', ['type' => 'bot']);
            $setup['action_name'] = __('Create message bot');
            $setup['action_link2'] = route('campaigns.create', ['type' => 'bot']);
            $setup['action_name2'] = __('Create template bot');
        }

        if ($isQuickReplies) {
            $setup['title'] = __('Quick Replies management');
            $setup['action_link'] = route($this->webroute_path . 'create', ['type' => 'reply']);
            $setup['action_name'] = __('Add quick replies');
            unset($setup['action_link2'], $setup['action_name2']);
        }

        return $setup;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authChecker();

        $isBot = request()->has('type') && request()->get('type') === 'bot';

        $fields = $this->getFields('col-md-12', $isBot ? 'bot' : 'qr');

        if ($isBot) {
            //Unset the 2nd field, first option
            // unset($fields[3]['data'][1]);
            // $fields[3]['value'] = 2;

            $buttons = RepliesButton::pluck('name', 'id');
            $fields[6]['buttons'] = $buttons;

            $listbuttons = RepliesListButton::pluck('name', 'id');
            $fields[6]['listbuttons'] = $listbuttons;

            return view($this->view_path . 'create', [
                'setup' => [
                    'title' => __('Create new bot'), //__('crud.new_item', ['item'=>__('text bot')]),
                    'fa_icon' => 'fad fa-user-robot',
                    'action_link' => route($this->webroute_path . 'index', ['type' => 'bot']),
                    'action_name' => __('crud.back'),
                    'action_icon' => 'fa fa-arrow-left',
                    'iscontent' => true,
                    'isBot' => true,
                    'action' => route($this->webroute_path . 'store'),
                ],
                'fields' => $fields,
            ]);
        } else {
            unset($fields[3]['data'][3]);
            unset($fields[3]['data'][2]);
            unset($fields[3]['data'][4]);
            return view($this->view_path . 'create', [
                'setup' => [
                    'title' => __('Create quick reply'), //__('crud.new_item', ['item'=>__('Quick Reply')]),
                    'fa_icon' => 'fad fa-reply-all',
                    'action_link' => route($this->webroute_path . 'index', ['type' => 'qr']),
                    'action_name' => __('crud.back'),
                    'action_icon' => 'fa fa-arrow-left',
                    'iscontent' => true,
                    'isBot' => false,
                    'action' => route($this->webroute_path . 'store'),
                ],
                'fields' => $fields,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $this->authChecker();
    //     //Create new field
    //     $field = $this->provider::create([
    //         'name' => $request->name,
    //         'text' => $request->caption_text,
    //         'type' => $request->type,
    //         'is_bot_active' => 1,
    //     ]);
    //     if ($request->type != 1) {

    //         $media = null;
    //         if ($request->header_type != 1) {

    //             if (isset($request->medias[0])) {
    //                 if (strpos($request->medias[0], "http") !== FALSE) {

    //                     $media_link = get_file_url($request->medias[0]);
    //                     if ($media_link) {
    //                         $media = $media_link;
    //                     }
    //                 } else {
    //                     $media_id =  $request->medias[0];
    //                     if ($media_id) {
    //                         $media = FileManager::where('ids', $media_id)->first(['file'])->file;
    //                         //force cdn refrence in sharable url cdn convert digitalocean
    //                         if (strpos($media, "digitaloceanspaces.com") !== FALSE) {
    //                             $do_cdn_path = env('DO_CDN_PATH');
    //                             $do_path = env('DO_PATH');
    //                             if ($do_cdn_path && $do_path) {
    //                                 $media = str_replace($do_path, $do_cdn_path, $media); //cdn path
    //                             }
    //                         }
    //                     }
    //                 }
    //             } else {
    //                 return json_encode([
    //                     "status" => "error",
    //                     "message" => "something went wrong",
    //                 ]);
    //             }
    //         }

    //         //Bot
    //         $field->trigger = $request->trigger;
    //         $field->header = $request->header_text;
    //         $field->footer = $request->footer_text;
    //         $field->header_type = $request->header_type;
    //         $field->media = $media;

    //         $template_group_id = '';
    //         $template_group = [];
    //         $action_type = $request->action_type_radio ?? 1;

    //         if ($action_type == 2) {
    //             $template_group_id = $request->btn_template_group_id;
    //         } elseif ($action_type == 3) {
    //             $template_group_id = $request->listbtn_template_group_id;
    //         }

    //         if (!empty($action_type) && $action_type != 1 && !empty($template_group_id)) {
    //             $template_group = [
    //                 "action_type" => $action_type,
    //                 "id" => $template_group_id,

    //             ];
    //         } else {
    //             $template_group = [
    //                 "action_type" => 1,
    //                 "id" => null,

    //             ];
    //         }

    //         $field->interactive_template_group = json_encode($template_group);
    //     }

    //     $field->save();

    //     if ($request->type != 1) {
    //         return redirect()->route($this->webroute_path . 'index')->withStatus(__('crud.item_has_been_added', ['item' => __($this->title)]));
    //     } else {
    //         return redirect()->route($this->webroute_path . 'quick')->withStatus(__('crud.item_has_been_added', ['item' => __($this->title)]));
    //     }
    // }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->authChecker();
        //for bot set for catalog
        $isCatalogBot = false;
        if ($request->bot_type) {
            $isCatalogBot = $request->bot_type == 'catalog' ? true : false;
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'caption_text' => 'required',
            'type' => 'required|integer',
            'trigger' => 'required_if:type,2,3',
            'header_text' => 'required_if:header,text|max:60',
            'footer_text' => 'max:60',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(
                    [
                        'errors' => $validator->errors(),
                    ],
                    422,
                );
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        // Create new field
        $field = $this->provider::create([
            'name' => $request->name,
            'text' => $request->caption_text,
            'type' => $request->type,
            'is_bot_active' => 1,
            'bot_type' => $isCatalogBot ?? 0,
        ]);

        if ($request->type != 1) {
            $media = null;

            if ($request->header_type != 1 && isset($request->medias[0])) {
                $media = $this->processMedia($request->medias[0]);
            }

            $field->trigger = $request->trigger;
            $field->header = $request->header_text;
            $field->footer = $request->footer_text;
            $field->header_type = $request->header;
            $field->media = $media;

            $action_type = $request->action_type_radio ?? 1;
            $template_group_id = '';

            if ($action_type == 2) {
                $template_group_id = $request->btn_template_group_id;
            } elseif ($action_type == 3) {
                $template_group_id = $request->listbtn_template_group_id;
            }

            $template_group = [
                'action_type' => $action_type,
                'id' => $template_group_id,
            ];

            $field->interactive_template_group = json_encode($template_group);
        }

        $field->save();

        // Prepare response
        $response = [
            'status' => 'success',
            'message' => __('crud.item_has_been_added', ['item' => __($this->title)]),
            'id' => $field->id,
        ];

        // Determine redirect URL
        if ($isCatalogBot) {
            $response['redirect'] = route($this->webroute_path . 'index', ['bot' => 'catalog']);
        } elseif ($request->type != 1) {
            $response['redirect'] = route($this->webroute_path . 'index');
        } else {
            $response['redirect'] = route($this->webroute_path . 'quick');
        }

        if ($request->ajax()) {
            return response()->json($response);
        } else {
            return redirect()->to($response['redirect'])->withStatus($response['message']);
        }
    }

    // Add this helper method to process media URLs
    private function processMedia($mediaUrl)
    {
        if (strpos($mediaUrl, 'http') !== false) {
            $media_link = get_file_url($mediaUrl);
            return $media_link ?: null;
        } else {
            $media = FileManager::where('ids', $mediaUrl)->first();
            if ($media) {
                $file = $media->file;
                // Force CDN reference for digitalocean
                if (strpos($file, 'digitaloceanspaces.com') !== false) {
                    $do_cdn_path = env('DO_CDN_PATH');
                    $do_path = env('DO_PATH');
                    if ($do_cdn_path && $do_path) {
                        $file = str_replace($do_path, $do_cdn_path, $file);
                    }
                }
                return $file;
            }
        }
        return null;
    }

    // For update method (should be similar to store)
    // public function update(Request $request, $id)
    // {
    //     // Similar structure to store method but with existing record
    //     // Return JSON response when request is AJAX
    // }

    //Activate bot
    public function activateBot(Reply $reply)
    {
        $reply->is_bot_active = true;
        $reply->save();
        return redirect()
            ->route('replies.index', ['type' => 'bot'])
            ->withStatus(__('Bot activated'));
    }

    //Deactivate bot
    public function deactivateBot(Reply $reply)
    {
        $reply->is_bot_active = false;
        $reply->save();
        return redirect()
            ->route('replies.index', ['type' => 'bot'])
            ->withStatus(__('Bot deactivated'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    // public function edit(Reply $reply)
    // {
    //     $this->authChecker();

    //     // $fields = $this->getFields('col-md-12', $reply->type == 1 ? 'qr' : 'bot');
    //     // $fields[0]['value'] = $reply->name;
    //     // $fields[1]['value'] = $reply->text;
    //     // $fields[2]['value'] = $reply->type;

    //     // if ($reply->type != 1) {
    //     //     $fields[3]['value'] = $reply->trigger;
    //     //     $fields[4]['value'] = $reply->header;
    //     //     $fields[5]['value'] = $reply->footer;
    //     //     $fields[6]['value'] = $reply->button1;

    //     //     $buttons = RepliesButton::pluck('name', 'id');
    //     //     $fields[6]['buttons'] = $buttons;

    //     //     $listbuttons = RepliesListButton::pluck('name', 'id');
    //     //     $fields[6]['listbuttons'] = $listbuttons;
    //     // }

    //     // $item = $this->provider::where('id', $reply->id)->first();
    //     $fields[6] = null;
    //     $parameter = [];
    //     $parameter[$this->parameter_name] = $reply->id;
    //     $title = '';

    //     $isBot = null;
    //     if ($reply->type == 1) {
    //         $title = 'Edit quik reply';
    //         $isBot = false;
    //     } else {
    //         $title = 'Edit chatbot';
    //         $isBot = true;
    //         $fields[6]['value'] = $reply->interactive_template_group;

    //         $action_type = json_decode($reply->interactive_template_group)->action_type;
    //         $button_id = json_decode($reply->interactive_template_group)->id;
    //         if ($action_type == 3) {
    //             $reply['button_info'] = RepliesListButton::where('id', $button_id)->first(['button_text']);
    //         } elseif ($action_type == 2) {
    //             $reply['button_info'] = RepliesButton::where('id', $button_id)->first(['template']);
    //         }

    //         $reply['action_type'] = $action_type;

    //         $buttons = RepliesButton::pluck('name', 'id');
    //         $fields[6]['buttons'] = $buttons;

    //         $listbuttons = RepliesListButton::pluck('name', 'id');
    //         $fields[6]['listbuttons'] = $listbuttons;
    //     }

    //     return view($this->view_path . 'edit', [
    //         'setup' => [
    //             'title' => __($title), //__('crud.edit_item_name', ['item' => __($this->title), 'name' => $reply->name]),
    //             'fa_icon' => 'fad fa-reply-all',
    //             'action_link' => route($this->webroute_path . 'index', ['type' => $reply->type == 1 ? 'qr' : 'bot']),
    //             'action_name' => __('crud.back'),
    //             'action_icon' => 'fa fa-arrow-left',
    //             'iscontent' => true,
    //             'item' => $reply,
    //             'isupdate' => true,
    //             'isBot' => $isBot,
    //             'action' => route($this->webroute_path . 'update', $parameter),
    //         ],
    //         'fields' => $fields,
    //     ]);
    // }

    public function edit(Reply $reply)
    {
        $this->authChecker();

        require_once public_path('phpqrcode-master/qrlib.php');
        // WhatsApp phone number and message
        $company = auth()->user()->company;
        $whatsapp_phone = Config::where('model_id', $company->id)->where('key', 'display_phone_number')->first();
        $whatsapp_phone = preg_replace('/[^a-zA-Z0-9\s]/', '', $whatsapp_phone->value);

        if ($whatsapp_phone) {
            // $phoneNumber = $whatsapp_phone;
            $triggerValues = explode(',', $reply->trigger); // Split the string by comma
            $firstValue = $triggerValues[0];
            $phoneNumber = str_replace([' ', '+'], '', $whatsapp_phone);

            // Generate the WhatsApp URL with the message
            $whatsappLink = "https://wa.me/$phoneNumber?text=$firstValue";

            // Create a temporary file for the QR code image
            $tempDir = sys_get_temp_dir();
            $filePath = $tempDir . '/whatsapp_qr.png';

            // Generate the QR code and save it to a file
            \QRcode::png($whatsappLink, $filePath, QR_ECLEVEL_L, 10);
        } else {
            $filePath = '';
        }

        $isBot = $reply->type != 1;
        $title = $isBot ? 'Edit chatbot' : 'Edit quick reply';

        // Initialize media variables
        $mediaPath = null;
        if ($reply->media) {
            $mediaPath = $this->getMediaPath($reply->media);
        }
        $fields = null;
        // Prepare button info if exists
        $buttonInfo = null;
        if ($isBot && $reply->interactive_template_group) {
            $buttons = RepliesButton::pluck('name', 'id');
            $fields[6]['buttons'] = $buttons;

            $listbuttons = RepliesListButton::pluck('name', 'id');
            $fields[6]['listbuttons'] = $listbuttons;

            $interactive = json_decode($reply->interactive_template_group);
            $reply->action_type = $interactive->action_type;

            if ($interactive->action_type == 3) {
                $buttonInfo = RepliesListButton::find($interactive->id);
            } elseif ($interactive->action_type == 2) {
                $buttonInfo = RepliesButton::find($interactive->id);
            }
        }

        return view($this->view_path . 'edit', [
            'setup' => [
                'title' => $title,
                'fa_icon' => 'fad fa-reply-all',
                'action_link' => route($this->webroute_path . 'index', ['type' => $isBot ? 'bot' : 'qr']),
                'action_name' => __('crud.back'),
                'action_icon' => 'fa fa-arrow-left',
                'iscontent' => true,
                'item' => $reply,
                'mediaPath' => $mediaPath,
                'buttonInfo' => $buttonInfo,
                'isupdate' => true,
                'isBot' => $isBot,
                'bot_type' => $reply->bot_type,
                'qr' => $filePath,
                'action' => route($this->webroute_path . 'update', [$reply->id]),
            ],
            'fields' => $fields,
        ]);
    }

    private function getMediaPath($media)
    {
        if (!$media) {
            return null;
        }

        // Handle DO Spaces
        if (strpos($media, 'digitaloceanspaces.com') !== false) {
            $do_cdn_path = env('DO_CDN_PATH');
            $do_path = env('DO_PATH');

            if ($do_cdn_path && $do_path) {
                return str_replace($do_path, $do_cdn_path, $media);
            }
        }

        return $media;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $this->authChecker();
    //     $item = $this->provider::findOrFail($id);

    //     $item->name = $request->name;
    //     $item->text = $request->caption_text;
    //     $item->type = $request->type;

    //     if ($request->type != 1) {
    //         $media = $item->media;
    //         if ($request->header_type != 1) {
    //             if (isset($request->medias[0])) {
    //                 if (strpos($request->medias[0], 'http') !== false) {
    //                     $media_link = get_file_url($request->medias[0]);
    //                     if ($media_link) {
    //                         $media = $media_link;
    //                     }
    //                 } else {
    //                     $media_id = $request->medias[0];
    //                     if ($media_id) {
    //                         $media = FileManager::where('ids', $media_id)->first(['file'])->file;
    //                         //force cdn refrence in sharable url cdn convert digitalocean
    //                         if (strpos($media, 'digitaloceanspaces.com') !== false) {
    //                             $do_cdn_path = env('DO_CDN_PATH');
    //                             $do_path = env('DO_PATH');
    //                             if ($do_cdn_path && $do_path) {
    //                                 $media = str_replace($do_path, $do_cdn_path, $media); //cdn path
    //                             }
    //                         }
    //                     }
    //                 }
    //             } else {
    //                 $media = $item->media;
    //             }
    //         }

    //         $item->trigger = $request->trigger;
    //         $item->header = $request->header_text;
    //         $item->footer = $request->footer_text;
    //         $item->header_type = $request->header_type;
    //         $item->media = $media;

    //         $template_group_id = '';
    //         $template_group = [];
    //         $action_type = $request->action_type_radio ?? 1;

    //         if ($action_type == 2) {
    //             $template_group_id = $request->btn_template_group_id;
    //         } elseif ($action_type == 3) {
    //             $template_group_id = $request->listbtn_template_group_id;
    //         }

    //         if (!empty($action_type) && $action_type != 1 && !empty($template_group_id)) {
    //             $template_group = [
    //                 'action_type' => $action_type,
    //                 'id' => $template_group_id,
    //             ];
    //         } else {
    //             $template_group = [
    //                 'action_type' => 1,
    //                 'id' => null,
    //             ];
    //         }

    //         $item->interactive_template_group = json_encode($template_group);
    //     }
    //     $item->update();
    //     if ($request->type != 1) {
    //         return redirect()
    //             ->route($this->webroute_path . 'index')
    //             ->withStatus(__('crud.item_has_been_updated', ['item' => __($this->title)]));
    //     } else {
    //         return redirect()
    //             ->route($this->webroute_path . 'quick')
    //             ->withStatus(__('crud.item_has_been_updated', ['item' => __($this->title)]));
    //     }
    // }

    public function update(Request $request, Reply $reply)
    {
        $this->authChecker();

        // Validate request
        $validator = Validator::make($request->all(), [
            'name'          => 'required|max:255',
            'caption_text'  => 'required',
            'type'          => 'required|integer',
            'trigger'       => 'required_if:type,2|required_if:type,3',
            'header_text'   => 'required_if:header,text|max:60',
            'footer_text'   => 'max:60',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update basic values
        $reply->name = $request->name;
        $reply->text = $request->caption_text;
        $reply->type = $request->type;

        // If NOT Quick Reply
        if ($request->type != 1) {

            // Handle Media
            $media = $reply->media;
            if ($request->header != 'none' && $request->has('medias') && isset($request->medias[0])) {
                $media = $this->processMedia($request->medias[0]);
            }

            $reply->trigger     = $request->trigger;
            $reply->footer      = $request->footer_text;
            $reply->header_type = $request->header;

            // Header text or media handling
            if ($request->header === 'TEXT') {
                $reply->header = $request->header_text;
                $reply->media = '';
            } else {
                $reply->header = '';
                $reply->media = $media;
            }

            // Interactive buttons
            $action_type = $request->action_type_radio ?? 1;
            $template_group_id = '';

            if ($action_type == 2) {
                $template_group_id = $request->btn_template_group_id;
            } elseif ($action_type == 3) {
                $template_group_id = $request->listbtn_template_group_id;
            }

            $reply->interactive_template_group = json_encode([
                'action_type' => $action_type,
                'id'          => $template_group_id,
            ]);
        } else {
            // Reset non-quick-reply fields
            $reply->trigger = null;
            $reply->header = null;
            $reply->footer = null;
            $reply->header_type = null;
            $reply->media = null;
            $reply->interactive_template_group = null;
        }

        $reply->save();

        // Prepare Redirect
        $response = [
            'status'  => 'success',
            'message' => __('crud.item_has_been_updated', ['item' => __($this->title)]),
        ];

        if ($reply->bot_type == 1) {
            $response['redirect'] = route($this->webroute_path . 'index', ['bot' => 'catalog']);
        } elseif ($request->type != 1) {
            $response['redirect'] = route($this->webroute_path . 'index');
        } else {
            $response['redirect'] = route($this->webroute_path . 'quick');
        }

        return $request->ajax()
            ? response()->json($response)
            : redirect()->to($response['redirect'])->withStatus($response['message']);
    }

    /**
     * Generate WhatsApp QR code for the reply
     */
    private function generateWhatsAppQRCode($reply)
    {
        $company = $this->getCompany();
        $whatsapp_phone = Config::where('model_id', $company->id)->where('key', 'whatsapp_phone')->first();

        if (!$whatsapp_phone) {
            return '';
        }

        require_once public_path('phpqrcode-master/qrlib.php');

        $phoneNumber = str_replace([' ', '+'], '', $whatsapp_phone->value);
        $triggerValues = explode(',', $reply->trigger);
        $firstValue = $triggerValues[0];
        $whatsappLink = "https://wa.me/$phoneNumber?text=$firstValue";

        $tempDir = sys_get_temp_dir();
        $filePath = $tempDir . '/whatsapp_qr_' . $reply->id . '.png';

        \QRcode::png($whatsappLink, $filePath, QR_ECLEVEL_L, 10);

        return $filePath;
    }

    /**
     * Get fields for edit form
     */
    private function getEditFields($reply)
    {
        $fields = $this->getFields('col-md-6', $reply->type == 1 ? 'qr' : ($reply->bot_type == 1 ? 'catalog' : 'bot'));

        $fields[0]['value'] = $reply->name;
        $fields[1]['value'] = $reply->text;
        $fields[2]['value'] = $reply->type;
        $fields[3]['value'] = $reply->trigger;

        if ($reply->type != 1) {
            $fieldIndex = 4;
            if ($reply->bot_type == 1) {
                $fields[$fieldIndex]['value'] = $reply->footer;
            } else {
                $fields[$fieldIndex++]['value'] = $reply->header;
                $fields[$fieldIndex++]['value'] = $reply->footer;
                $fields[$fieldIndex++]['value'] = $reply->button1;
                $fields[$fieldIndex++]['value'] = $reply->button1_id;
                $fields[$fieldIndex++]['value'] = $reply->button2;
                $fields[$fieldIndex++]['value'] = $reply->button2_id;
                $fields[$fieldIndex++]['value'] = $reply->button3;
                $fields[$fieldIndex++]['value'] = $reply->button3_id;
                $fields[$fieldIndex++]['value'] = $reply->button_name;
                $fields[$fieldIndex]['value'] = $reply->button_url;
            }
        }

        return $fields;
    }

    /**
     * AJAX endpoint for editing
     */
    public function editAjax($id)
    {
        $reply = $this->provider::find($id);
        if (!$reply) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Reply not found',
                ],
                404,
            );
        }

        $this->authChecker();
        $fields = $this->getEditFields($reply);

        return response()->json([
            'success' => true,
            'html' => view($this->view_path . 'partials.edit_form', [
                'fields' => $fields,
                'action' => route($this->webroute_path . 'update', [$this->parameter_name => $reply->id]),
                'method' => 'PUT',
            ])->render(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Validate authentication
            if (!auth()->check()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Unauthenticated',
                    ],
                    401,
                );
            }

            $this->authChecker();

            // Validate item existence
            $item = $this->provider::find($id);
            if (!$item) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => __('crud.item_not_found', ['item' => __($this->title)]),
                    ],
                    404,
                );
            }

            $item->delete();

            return response()->json([
                'success' => true,
                'message' => __('crud.item_has_been_removed', ['item' => __($this->title)]),
            ]);
        } catch (\Exception $e) {
            \Log::error("Delete Error: {$e->getMessage()}", [
                'id' => $id,
                'route' => request()->fullUrl(),
                'user' => auth()->id(),
            ]);

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Server error: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Get filter fields
     */
    private function getFilterFields()
    {
        $fields = $this->getFields('col-md-3', 'qr');
        $fields[0]['required'] = true;
        unset($fields[1], $fields[2], $fields[3]);
        return $fields;
    }

    /**
     * Auth checker function for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }
}
