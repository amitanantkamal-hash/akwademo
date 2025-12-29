<?php

namespace Modules\Wpbox\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Wpbox\Models\RepliesListButton;
use Modules\Contacts\Models\Group;

class RepliesListButtonController extends Controller
{

    //

    /**
     * Provide class.
     */
    private $provider = RepliesListButton::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'list_button_template.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::replies.list_button_template.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'button';

    /**
     * Title of this crud.
     */
    private $title = 'list button template';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'listbuttontemplate';

    private function getFields($class = 'col-md-4')
    {
        $fields = [];

        //Add name field
        $fields[0] = ['class' => $class, 'ftype' => 'input', 'name' => 'Group name', 'id' => 'name', 'placeholder' => ' ', 'required' => true];
        $fields[1] = ['class' => $class, 'ftype' => 'input', 'name' => 'Button text', 'id' => 'button_text', 'placeholder' => ' ', 'required' => true, 'max'=> '20', 'additionalInfo' => __('max 20 characters allowed')];

        $fields[2] = ['ftype' => 'TemplateListButton'];

        //Return fields
        return $fields;
    }


    private function getFilterFields()
    {
        $fields = $this->getFields('col-md-3');
        $fields[0]['required'] = true;
        $fields[1]['required'] = true;
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
            'title' => __('Interactive - List group'),
            'fa_icon' => 'fad fa-pager',
            'action_name' => __('Add List Group'),
            'action_link' => route($this->webroute_path . 'create'),
            'action_hint' => __('Create new list group'),
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

        $page_number = (int)($request->current_page - 1) ?? 0;
        $per_page = $request->per_page ?? 10;
        $total_items = $request->total_items;
        $keyword = $request->keyword ?? '';

        if ($keyword && !empty($keyword)) {

            if ($page_number == 0) {
                $result = $this->provider::where('name', 'LIKE', "%{$keyword}%")->where('button_text', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->limit($per_page)->offset(0)->get();
            } else {
                $offset_num = $page_number * $per_page;
                $result = $this->provider::where('name', 'LIKE', "%{$keyword}%")->where('button_text', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->limit($per_page)->offset($offset_num)->get();
            }
        } else {

            if ($page_number == 0) {
                $result = $this->provider::orderBy('id', 'desc')->limit($per_page)->offset(0)->get();
            } else {
                $offset_num = $page_number * $per_page;
                $result = $this->provider::orderBy('id', 'desc')->limit($per_page)->offset($offset_num)->get();
            }
        }

        if (empty($result)) return false;

        $data = [
            "result" => $result
        ];

        return  response()->json([
            "total_items" => (int)$total_items,
            "data" => (string)view($this->view_path . 'ajax_list', $data)

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();

        $fields = $this->getFields('col-md-12'); //Brij Mohan Negi Update col-md-12
        //Brij MOhan Negi Update
        // $groups = Group::pluck('name', 'id');
        // $fields[1]['groups'] = $groups;

        // //Brij MOhan Negi Update
        // $users = $this->getCompany()->users()->pluck('name', 'id');
        // $fields[1]['users'] = $users;

        return view('general.form', [
            'setup' => [
                'title' => __('Create Interactive - List button group'), //__('crud.new_item', ['item'=>__('text bot')]), //Brij Mohan Negi Update
                'fa_icon' => 'fad fa-pager',
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'action_icon' => 'fa fa-arrow-left', //Brij Mohan Negi Update
                'iscontent' => true,
                'action' => route($this->webroute_path . 'store')
            ],
            'fields' => $fields
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
            'button_text' => $request->button_text,

        ]);

        $section_name = $request->section_name;
        $options = $request->options;

        $list_section_template = [];

        foreach ($section_name as $key => $section) {

            if (!empty($section)) {
                $section_item = ['title' => $section, 'rows' => []];

                if (!isset($section) || $section == "") {
                    // ms([
                    //     "status" => "error",
                    //     "message" => sprintf( __("Section %s: Section name is required") , $key )
                    // ]);
                }

                if (!isset($options[$key]) || count($options[$key]) == 0 || !isset($options[$key]['name']) || !isset($options[$key]['desc'])) {
                    // ms([
                    //     "status" => "error",
                    //     "message" => sprintf( __("Section %s: Add at least one option") , $key )
                    // ]);
                }

                if (count($options[$key]['name']) != count($options[$key]['desc'])) {
                    // ms([
                    //     "status" => "error",
                    //     "message" => sprintf( __("Section %s: Invalid input data") , $key )
                    // ]);
                }

                foreach ($options[$key]['name'] as $option_key => $option_value) {
                    $option_value = trim($option_value);
                    if ($option_value == "") {
                        // ms([
                        //     "status" => "error",
                        //     "message" => __('The option name is required')
                        // ]);
                    }

                    $section_item['rows'][] = [
                        "title" => $option_value,
                        "rowId" => uniqid(),
                        "description" => $options[$key]['desc'][$option_key]
                    ];
                }

                $sections_arr[] = $section_item;
            }
        }

        $list_section_template = [
            "sections" => $sections_arr
        ];


        $field->template = json_encode($list_section_template);

        $field->save();

        return redirect()->route($this->webroute_path . 'index')->withStatus(__('crud.item_has_been_added', ['item' => __($this->title)]));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(RepliesListButton $button)
    {
        $this->authChecker();

        $fields = $this->getFields('col-md-12');
        $fields[0]['value'] = $button->name;
        $fields[1]['value'] = $button->button_text;
        $fields[2]['template'] = $button->template;

        $parameter = [];
        $parameter[$this->parameter_name] = $button->id;

        return view($this->view_path . 'edit', [
            'setup' => [
                'title' =>  __('Edit list buttons group'), //__('crud.edit_item_name', ['item' => __($this->title), 'name' => $reply->name]),
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
        $item->button_text = $request->button_text;

        $section_name = $request->section_name;
        $options = $request->options;

        $list_section_template = [];

        foreach ($section_name as $key => $section) {

            if (!empty($section)) {
                $section_item = ['title' => $section, 'rows' => []];

                if (!isset($section) || $section == "") {
                    // ms([
                    //     "status" => "error",
                    //     "message" => sprintf( __("Section %s: Section name is required") , $key )
                    // ]);
                }

                if (!isset($options[$key]) || count($options[$key]) == 0 || !isset($options[$key]['name']) || !isset($options[$key]['desc'])) {
                    // ms([
                    //     "status" => "error",
                    //     "message" => sprintf( __("Section %s: Add at least one option") , $key )
                    // ]);
                }

                // if (count($options[$key]['name']) != count($options[$key]['desc'])) {
                //     // ms([
                //     //     "status" => "error",
                //     //     "message" => sprintf( __("Section %s: Invalid input data") , $key )
                //     // ]);
                // }

                foreach ($options[$key]['name'] as $option_key => $option_value) {
                    $option_value = trim($option_value);
                    if ($option_value == "") {
                        // ms([
                        //     "status" => "error",
                        //     "message" => __('The option name is required')
                        // ]);
                    } else {
                        $section_item['rows'][] = [
                            "title" => $option_value,
                            "rowId" => uniqid(),
                            "description" => $options[$key]['desc'][$option_key]
                        ];
                    }
                }

                $sections_arr[] = $section_item;
            }
        }

        $list_section_template = [
            "sections" => $sections_arr
        ];

        $item->template = json_encode($list_section_template);

        $item->update();
        // Brij MOhan Negi Update

        return redirect()->route($this->webroute_path . 'index')->withStatus(__('crud.item_has_been_updated', ['item' => __($this->title)]));
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
        return redirect()->route($this->webroute_path . 'index')->withStatus(__('crud.item_has_been_removed', ['item' => __($this->title)]));
    }

    public function fetch_interactive(Request $request)
    {
        $this->authChecker();
        $item = null;
        if ($request->id) {
            $item = $this->provider::where('id', $request->id)->first();
        }

        return json_encode([
            "status" => "success",
            "result" => $item,
        ]);
    }
}
