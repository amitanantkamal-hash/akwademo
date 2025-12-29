<?php

namespace Modules\Wpbox\Http\Controllers;

use Modules\Wpbox\Models\RepliesButton;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Contacts\Models\Group;

//Brij MOhan Negi Update
class RepliesButtonController extends Controller
{
    //

    /**
     * Provide class.
     */
    private $provider = RepliesButton::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'button_template.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::replies.button_template.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'button';

    /**
     * Title of this crud.
     */
    private $title = 'button template';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'buttontemplate';

    private function getFields($class = 'col-md-4')
    {
        $fields = [];

        //Add name field
        $fields[0] = ['class' => $class, 'ftype' => 'input', 'name' => 'Group name', 'id' => 'name', 'placeholder' => 'Enter button group name', 'required' => true];

        $fields[1] = ['ftype' => 'TemplateButton'];

        //Return fields
        return $fields;
    }

    private function getFilterFields()
    {
        $fields = $this->getFields('col-md-3');
        $fields[0]['required'] = true;
        return $fields;
    }

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authChecker();

        // Verify WhatsApp setup
        $company = $this->getCompany();
        if ($company->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $company->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect()->route('whatsapp.setup');
        }

        // Get paginated items
        $items = $this->provider
            ::where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(request()->query()); // Use config value with fallback

        // Build datatable structure

        // Setup view data
        $setup = [
            'title' => __('Interactive - Button group'),
            'fa_icon' => 'fad fa-pager',
            'action_name' => __('Add Button Group'),
            'action_link' => route($this->webroute_path . 'create'),
            'action_hint' => __('Create new button group'),
            'items' => $items,
            'item_names' => $this->titlePlural,
            'webroute_path' => $this->webroute_path,
            'fields' => $this->getFields('col-md-3'),
            'filterFields' => $this->getFilterFields(),
            'custom_table' => true,
            'parameter_name' => $this->parameter_name,
            'parameters' => request()->query->count() > 0,
        ];

        return view($this->view_path . 'index', [
            'setup' => $setup,
        ]);
    }

    public function ajax_list(Request $request)
    {
        $this->authChecker();

        $page_number = (int) ($request->current_page - 1) ?? 0;
        $per_page = $request->per_page ?? 10;
        $total_items = $request->total_items;
        $keyword = $request->keyword ?? '';

        if ($keyword && !empty($keyword)) {
            if ($page_number == 0) {
                $result = $this->provider
                    ::where('name', 'LIKE', "%{$keyword}%")
                    ->where('template', 'LIKE', "%{$keyword}%")
                    ->orderBy('id', 'desc')
                    ->limit($per_page)
                    ->offset(0)
                    ->get();
            } else {
                $offset_num = $page_number * $per_page;
                $result = $this->provider
                    ::where('name', 'LIKE', "%{$keyword}%")
                    ->where('template', 'LIKE', "%{$keyword}%")
                    ->orderBy('id', 'desc')
                    ->limit($per_page)
                    ->offset($offset_num)
                    ->get();
            }
        } else {
            if ($page_number == 0) {
                $result = $this->provider::orderBy('id', 'desc')->limit($per_page)->offset(0)->get();
            } else {
                $offset_num = $page_number * $per_page;
                $result = $this->provider::orderBy('id', 'desc')->limit($per_page)->offset($offset_num)->get();
            }
        }

        if (empty($result)) {
            return false;
        }

        $data = [
            'result' => $result,
        ];

        return response()->json([
            'total_items' => (int) $total_items,
            'data' => (string) view($this->view_path . 'ajax_list', $data),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $this->authChecker();

    //     $fields = $this->getFields('col-md-12'); //Brij Mohan Negi Update col-md-12
    //     //Brij MOhan Negi Update
    //     $groups = Group::pluck('name', 'id');
    //     $fields[1]['groups'] = $groups;

    //     //Brij MOhan Negi Update
    //     $users = $this->getCompany()->users()->pluck('name', 'id');
    //     $fields[1]['users'] = $users;

    //     return view('general.form', [
    //         'setup' => [
    //             'title' => __('Create Interactive - Button group'), //__('crud.new_item', ['item'=>__('text bot')]), //Brij Mohan Negi Update
    //             'fa_icon' => 'fad fa-pager',
    //             'action_link' => route($this->webroute_path . 'index'),
    //             'action_name' => __('crud.back'),
    //             'action_icon' => 'fa fa-arrow-left', //Brij Mohan Negi Update
    //             'iscontent' => true,
    //             'action' => route($this->webroute_path . 'store'),
    //         ],
    //         'fields' => $fields,
    //     ]);
    // }

    public function create()
{
    $this->authChecker();
    
    $groups = Group::pluck('name', 'id');
    $users = $this->getCompany()->users()->pluck('name', 'id');

    return view('wpbox::replies.button_template.create', [
        'setup' => [
            'title' => __('Create Interactive - Button group'),
            'fa_icon' => 'fad fa-pager',
            'action_link' => route($this->webroute_path . 'index'),
            'action_name' => __('crud.back'),
            'action_icon' => 'fa fa-arrow-left',
            'action' => route($this->webroute_path . 'store'),
        ],
        'groups' => $groups,
        'users' => $users,
    ]);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authChecker();

        //Create new field
        $field = $this->provider::create([
            'name' => $request->name,
        ]);

        $btn_msg_type = $request->btn_msg_type;
        $btn_msg_display_text = $request->btn_msg_display_text;
        $user_press_the_button = $request->user_press_the_button;
        $add_tags = array_map('strtolower', (array) $request->add_tags);
        $remove_tags = array_map('strtolower', (array) $request->remove_tags);
        $conversation_groups = $request->conversation_groups;
        $conversation_user = $request->conversation_user;
        $webhook_url = $request->webhook_url;
        $default_button_action = $request->default_button_action;
        $start_flow = $request->start_flow;

        $btn_msg_link = $request->btn_msg_link;
        $btn_msg_call = $request->btn_msg_call;

        $btn_template = [];
        $item_button_message = [];

        if (!empty($btn_msg_type)) {
            foreach ($btn_msg_type as $key => $value) {
                $value = trim($value);

                switch ($value) {
                    case 1:
                        if (!isset($btn_msg_display_text[$key]) || $btn_msg_display_text[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => spri    ntf(__("Button %s: Please enter display text"), $key)
                            // ]);
                            break;
                        }

                        $item_button_message[] = [
                            'index' => $key,
                            'quickReplyButton' => [
                                'displayText' => $btn_msg_display_text[$key],
                                'id' => uniqid(),
                                'user_press_the_button' => $user_press_the_button[$key],
                                'add_tags' => $add_tags[$key] ?? '',
                                'remove_tags' => $remove_tags[$key] ?? '',
                                'conversation_groups' => $conversation_groups[$key] ?? '',
                                'conversation_user' => $conversation_user[$key] ?? '',
                                'webhook_url' => $webhook_url[$key] ?? '',
                                'default_button_action' => $default_button_action[$key] ?? '',
                                'start_flow' => $start_flow[$key] ?? '',
                            ],
                        ];
                        break;

                    case 2:
                        if (!isset($btn_msg_display_text[$key]) || $btn_msg_display_text[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Please enter display text"), $key)
                            // ]);

                            break;
                        }

                        if (!isset($btn_msg_link[$key]) || filter_var($btn_msg_link[$key], FILTER_VALIDATE_URL) === false) {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Invalid URL"), $key)
                            // ]);
                            break;
                        }

                        $item_button_message[] = [
                            'index' => $key,
                            'urlButton' => [
                                'displayText' => $btn_msg_display_text[$key],
                                'url' => $btn_msg_link[$key],
                            ],
                        ];
                        break;

                    case 3:
                        if (!isset($btn_msg_display_text[$key]) || $btn_msg_display_text[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Please enter display text"), $key)
                            // ]);
                            break;
                        }
                        // || !isValidTelephoneNumber($btn_msg_call[$key])
                        if (!isset($btn_msg_call[$key])) {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Invalid phone number"), $key)
                            // ]);

                            break;
                        }

                        if ($btn_msg_call[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Phone number is required"), $key)
                            // ]);

                            break;
                        }

                        $item_button_message[] = [
                            'index' => $key,
                            'callButton' => [
                                'displayText' => $btn_msg_display_text[$key],
                                'phoneNumber' => $btn_msg_call[$key],
                            ],
                        ];
                        break;

                    default:
                        // ms([
                        //     "status" => "error",
                        //     "message" => __('The type button item incorrect')
                        // ]);
                        break;
                }

                if ($value == '') {
                    // ms([
                    //     "status" => "error",
                    //     "message" => __('The option name is required')
                    // ]);
                }
            }

            $btn_template = [
                'templateButtons' => $item_button_message,
            ];
        }

        $field->template = json_encode($btn_template);

        $field->save();

        return redirect()
            ->route($this->webroute_path . 'index')
            ->withStatus(__('crud.item_has_been_added', ['item' => __($this->title)]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(RepliesButton $button)
    {
        $this->authChecker();

        $fields = $this->getFields('col-md-12');
        $fields[0]['value'] = $button->name;
        $fields[1]['template'] = $button->template;

        //Brij MOhan Negi Update
        $groups = Group::pluck('name', 'id');
        $fields[1]['groups'] = $groups;

        //Brij MOhan Negi Update
        $users = $this->getCompany()->users()->pluck('name', 'id');
        $fields[1]['users'] = $users;

        $parameter = [];
        $parameter[$this->parameter_name] = $button->id;

        return view($this->view_path . 'edit', [
            'setup' => [
                'title' => __('Edit buttons group'), //__('crud.edit_item_name', ['item' => __($this->title), 'name' => $reply->name]),
                'fa_icon' => 'fad fa-reply-all', //Brij Mohan Negi Update
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'action_icon' => 'fa fa-arrow-left',
                'iscontent' => true,
                'isupdate' => true,
                'action' => route($this->webroute_path . 'update', $parameter),
            ],
            'fields' => $fields,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->name = $request->name;

        $btn_msg_type = $request->btn_msg_type;
        $btn_msg_display_text = $request->btn_msg_display_text;
        $user_press_the_button = $request->user_press_the_button;
        $add_tags = $request->add_tags;
        $remove_tags = $request->remove_tags;
        $conversation_groups = $request->conversation_groups;
        $conversation_user = $request->conversation_user;
        $webhook_url = $request->webhook_url;
        $default_button_action = $request->default_button_action;
        $start_flow = $request->start_flow;

        $btn_msg_link = $request->btn_msg_link;
        $btn_msg_call = $request->btn_msg_call;

        $btn_template = [];
        $item_button_message = [];

        if (!empty($btn_msg_type)) {
            foreach ($btn_msg_type as $key => $value) {
                $value = trim($value);

                switch ($value) {
                    case 1:
                        if (!isset($btn_msg_display_text[$key]) || $btn_msg_display_text[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => spri    ntf(__("Button %s: Please enter display text"), $key)
                            // ]);
                            break;
                        }

                        $item_button_message[] = [
                            'index' => $key,
                            'quickReplyButton' => [
                                'displayText' => $btn_msg_display_text[$key],
                                'id' => uniqid(),
                                'user_press_the_button' => $user_press_the_button[$key],
                                'add_tags' => strtolower($add_tags[$key]) ?? '',
                                'remove_tags' => strtolower($remove_tags[$key]) ?? '',
                                'conversation_groups' => $conversation_groups[$key] ?? '',
                                'conversation_user' => $conversation_user[$key] ?? '',
                                'webhook_url' => $webhook_url[$key] ?? '',
                                'default_button_action' => $default_button_action[$key] ?? '',
                                'start_flow' => $start_flow[$key] ?? '',
                            ],
                        ];
                        break;

                    case 2:
                        if (!isset($btn_msg_display_text[$key]) || $btn_msg_display_text[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Please enter display text"), $key)
                            // ]);

                            break;
                        }

                        if (!isset($btn_msg_link[$key]) || filter_var($btn_msg_link[$key], FILTER_VALIDATE_URL) === false) {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Invalid URL"), $key)
                            // ]);
                            break;
                        }

                        $item_button_message[] = [
                            'index' => $key,
                            'urlButton' => [
                                'displayText' => $btn_msg_display_text[$key],
                                'url' => $btn_msg_link[$key],
                            ],
                        ];
                        break;

                    case 3:
                        if (!isset($btn_msg_display_text[$key]) || $btn_msg_display_text[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Please enter display text"), $key)
                            // ]);
                            break;
                        }
                        // || !isValidTelephoneNumber($btn_msg_call[$key])
                        if (!isset($btn_msg_call[$key])) {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Invalid phone number"), $key)
                            // ]);

                            break;
                        }

                        if ($btn_msg_call[$key] == '') {
                            // ms([
                            //     "status" => "error",
                            //     "message" => sprintf(__("Button %s: Phone number is required"), $key)
                            // ]);

                            break;
                        }

                        $item_button_message[] = [
                            'index' => $key,
                            'callButton' => [
                                'displayText' => $btn_msg_display_text[$key],
                                'phoneNumber' => $btn_msg_call[$key],
                            ],
                        ];
                        break;

                    default:
                        // ms([
                        //     "status" => "error",
                        //     "message" => __('The type button item incorrect')
                        // ]);
                        break;
                }

                if ($value == '') {
                    // ms([
                    //     "status" => "error",
                    //     "message" => __('The option name is required')
                    // ]);
                }
            }

            $btn_template = [
                'templateButtons' => $item_button_message,
            ];
        }

        $item->template = json_encode($btn_template);

        $item->update();
        // Brij MOhan Negi Update

        return redirect()
            ->route($this->webroute_path . 'index')
            ->withStatus(__('crud.item_has_been_updated', ['item' => __($this->title)]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => __(
                'Interactive - Button group
 has been deleted!',
                ['item' => __($this->title)],
            ),
        ]);
    }

    public function fetch_interactive(Request $request)
    {
        $this->authChecker();
        $item = null;
        if ($request->id) {
            $item = $this->provider::where('id', $request->id)->first();
        }

        return json_encode([
            'status' => 'success',
            'result' => $item,
        ]);
    }
}
