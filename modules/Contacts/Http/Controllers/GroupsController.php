<?php

namespace Modules\Contacts\Http\Controllers;

use Modules\Contacts\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupsController extends Controller
{
    /**
     * Provide class.
     */
    private $provider = Group::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'contacts.groups.';

    /**
     * View path.
     */
    private $view_path = 'contacts::groups.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'group';

    /**
     * Title of this crud.
     */
    private $title = 'Group';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'groups';

    private function getFields($class = 'col-md-4')
    {
        $fields = [];

        //Add name field
        $fields[0] = ['class' => $class, 'ftype' => 'input', 'name' => 'Name', 'id' => 'name', 'placeholder' => 'Enter name', 'required' => true];

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
        
        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }

        $query = $this->provider::withCount('contacts')->latest();

        if (request()->has('name') && strlen(request('name')) > 1) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        if (request()->has('size') && request('size') != 'all') {
            switch (request('size')) {
                case 'small':
                    $query->having('contacts_count', '<', 50);
                    break;
                case 'medium':
                    $query->having('contacts_count', '>=', 50)->having('contacts_count', '<=', 100);
                    break;
                case 'large':
                    $query->having('contacts_count', '>', 100);
                    break;
            }
        }

       $items = $query->paginate(config('settings.paginate'))->appends(request()->query());

        $viewData = [
            'setup' => [
                'usefilter' => true,
                'title' => __('Groups'),
                'action_link' => route($this->webroute_path . 'create'),
                'action_name' => __('Add Group'),
                'items' => $items,
                'item_names' => $this->titlePlural,
                'webroute_path' => $this->webroute_path,
                'fields' => $this->getFields(),
                'filterFields' => $this->getFilterFields(),
                'custom_table' => true,
                'parameter_name' => $this->parameter_name,
                'parameters' => request()->query() ? true : false,
                'breadcrumbs' => [[__('Contacts'), route('contacts.index')], [__('crud.item_managment', ['item' => __($this->titlePlural)]), '#']],
            ],
            'setup_create' => [
                'title' => __('Groups'),
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'iscontent' => true,
                'action' => route($this->webroute_path . 'store'),
                'breadcrumbs' => [[__('Contacts'), route('contacts.index')]],
            ],
            'fields_create' => $this->getFields(),
        ];

        return view($this->view_path . 'index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();

        return view('general.form-client', [
            'setup' => [
                'title' => __('crud.new_item', ['item' => __($this->title)]),
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'iscontent' => true,
                'action' => route($this->webroute_path . 'store'),
                'breadcrumbs' => [[__('Contacts'), route('contacts.index')]],
            ],
            'fields' => $this->getFields(),
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

        //Create new contact
        $contact = $this->provider::create([
            'name' => $request->name,
        ]);
        $contact->save();

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
    public function editOld(group $group)
    {
        $this->authChecker();

        $fields = $this->getFields();
        $fields[0]['value'] = $group->name;

        $parameter = [];
        $parameter[$this->parameter_name] = $group->id;

        return view($this->view_path . 'edit', [
            'setup' => [
                'title' => __('crud.edit_item_name', ['item' => __($this->title), 'name' => $group->name]),
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'iscontent' => true,
                'isupdate' => true,
                'action' => route($this->webroute_path . 'update', $parameter),
            ],
            'fields' => $fields,
        ]);
    }

    public function edit($id)
    {
        $fields = $this->getFields();
        $group = Group::findOrFail($id);
        $fields[0]['value'] = $group->name;
        return view($this->view_path . 'partials.edit_form', [
            'fields' => $fields,
            'action' => route($this->webroute_path . 'update', $group->id),
            'method' => 'PUT',
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
        $item->update();

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
        return response()->json(['success' => true, 'message' => 'Selected group deleted successfully.']);
    }

    public function destroyWithContact($id)
    {
        $this->authChecker();
        try {
            $group = Group::findOrFail($id);
            $group->deleteGroupAndContacts();

            return response()->json(['success' => true, 'message' => 'Group and associated contacts deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting group: ' . $e->getMessage()], 500);
        }
    }
}
