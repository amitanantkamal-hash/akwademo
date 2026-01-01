<?php

namespace Modules\Contacts\Http\Controllers;

use Modules\Contacts\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Modules\Contacts\Exports\ContactsExport;
use Modules\Contacts\Imports\ContactsImport;
use Modules\Contacts\Imports\ContactsRead;
use Modules\Contacts\Imports\HeaderImport;
use Modules\Contacts\Models\Country;
use Modules\Contacts\Models\Field;
use Modules\Contacts\Models\Group;
use Illuminate\Support\Facades\DB;
use Modules\LeadManager\Models\Lead;

class Main extends Controller
{
    /**
     * Provide class.
     */
    private $provider = Contact::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'contacts.';

    /**
     * View path.
     */
    private $view_path = 'contacts::contacts.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'contact';

    /**
     * Title of this crud.
     */
    private $title = 'contact';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'contacts';

    private function hasAccessToAIBots()
    {
        $allowedPluginsPerPlan = auth()->user()->company ? auth()->user()->company->getPlanAttribute()['allowedPluginsPerPlan'] : [];
        if ($allowedPluginsPerPlan == null || in_array('flowiseai', $allowedPluginsPerPlan)) {
            return true;
        } else {
            return false;
        }
    }

    private function getFields($class = 'col-md-4', $getCustom = true)
    {
        $fields = [];

        //Avatar
        $fields[0] = ['class' => $class, 'ftype' => 'image', 'name' => 'Avatar', 'id' => 'avatar', 'style' => 'width: 200px; height:200', 'required' => false];

        //Add name field
        $fields[1] = ['class' => $class, 'ftype' => 'input', 'name' => 'Name', 'id' => 'name', 'placeholder' => 'User Name', 'required' => true];

        //Add phone field
        $fields[2] = ['class' => $class, 'ftype' => 'input', 'type' => 'phone', 'name' => 'WhatsApp number', 'id' => 'phone', 'placeholder' => '91XXXXXXXXXX', 'required' => true];

        //Groups
        $fields[3] = ['class' => $class, 'multiple' => true, 'classselect' => '', 'ftype' => 'select', 'name' => 'Groups', 'id' => 'groups[]', 'placeholder' => 'Select group', 'data' => Group::get()->pluck('name', 'id'), 'required' => true];

        //Country
        $fields[4] = ['class' => $class, 'ftype' => 'select', 'name' => 'Country', 'id' => 'country_id', 'placeholder' => 'Select country', 'data' => Country::get()->pluck('name', 'id'), 'required' => true];

        //AI Bot enabled
        $customFieldStart = 4;

        if ($this->hasAccessToAIBots()) {
            $customFieldStart = 5;
            $fields[5] = ['class' => $class, 'ftype' => 'bool', 'name' => 'Enable AI bot Replies', 'id' => 'enabled_ai_bot', 'placeholder' => 'AI Bot replies enabled', 'required' => false];
        }

        if ($getCustom) {
            $customFields = Field::get()->toArray();
            $i = $customFieldStart;
            foreach ($customFields as $filedkey => $customField) {
                $i++;
                $fields[$i] = ['class' => $class, 'ftype' => 'input', 'type' => $customField['type'], 'name' => __($customField['name']), 'id' => 'custom[' . $customField['id'] . ']', 'placeholder' => __($customField['name']), 'required' => false];
            }
        }

        //Return fields
        return $fields;
    }

    private function getFilterFields()
    {
        $fields = $this->getFields('col-md-3', false);
        unset($fields[0]);
        $fields[1]['required'] = false;
        $fields[2]['required'] = false;

        $fields[3]['required'] = false;
        $fields[3]['multiple'] = false;
        $fields[3]['id'] = 'group';
        unset($fields[3]['multiple']);

        $fields[4]['required'] = false;
        $fields[4]['multiple'] = false;
        unset($fields[4]['multiple']);

        unset($fields[5]);

        $fields[5] = ['class' => 'col-md-3', 'ftype' => 'select', 'name' => 'Subscribed', 'id' => 'subscribed', 'placeholder' => 'Select status', 'data' => ['1' => 'Subscribed', '0' => 'Opted out'], 'required' => false];

        //unset($fields[2]);
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
    // public function index()
    // {
    //     $items = $this->provider::with(['fields', 'groups']);

    //     // Name filter
    //     if (request()->has('name') && strlen(request('name')) > 0) {
    //         $items->where('name', 'like', '%' . request('name') . '%');
    //     }

    //     // Phone filter
    //     if (request()->has('phone') && strlen(request('phone')) > 0) {
    //         $items->where('phone', 'like', '%' . request('phone') . '%');
    //     }

    //     // Email filter (assuming it's stored in fields)
    //     if (request()->has('email') && strlen(request('email')) > 0) {
    //         $items->whereHas('fields', function ($query) {
    //             $query->where('name', 'Email')->where('value', 'like', '%' . request('email') . '%');
    //         });
    //     }

    //     // Group filter
    //     if (request()->has('group') && request('group') != '') {
    //         $items->whereHas('groups', function ($query) {
    //             $query->where('groups.id', request('group'));
    //         });
    //     }

    //     // Subscription status filter
    //     if (request()->has('subscribed') && request('subscribed') !== '') {
    //         $items->where('subscribed', request('subscribed'));
    //     }

    //     // Country filter
    //     if (request()->has('country_id') && request('country_id') != '') {
    //         $items->where('country_id', request('country_id'));
    //     }
    //     $totalItems = $items->count();
    //     // $items = $items->paginate(config('settings.paginate'));
    //     $items = $items->paginate(config('settings.paginate'))->appends(request()->query());

    //     // Rest of your controller logic...

    //     $groups = Group::pluck('name', 'id');
    //     return view($this->view_path . 'index', [
    //         'setup' => [
    //             'usefilter' => true,
    //             'title' => __('crud.item_managment', ['item' => __($this->titlePlural)]),
    //             'subtitle' => $totalItems == 1 ? __('1 Contact') : $totalItems . ' ' . __('Contacts'),
    //             'action_link' => route($this->webroute_path . 'create'),
    //             'action_name' => __('crud.add_new_item', ['item' => __($this->title)]),
    //             'action_link2' => route($this->webroute_path . 'groups.index'),
    //             'action_name2' => __('Groups'),
    //             'action_link3' => route($this->webroute_path . 'fields.index'),
    //             'action_name3' => __('Fields'),
    //             'action_link4' => route($this->webroute_path . 'index', ['report' => true]),
    //             'action_name4' => __('Export'),
    //             'items' => $items,
    //             'item_names' => $this->titlePlural,
    //             'webroute_path' => $this->webroute_path,
    //             'fields' => $this->getFields(),
    //             'filterFields' => $this->getFilterFields(),
    //             'custom_table' => true,
    //             'parameter_name' => $this->parameter_name,
    //             'parameters' => count($_GET) != 0,
    //             'groups' => Group::get(),
    //         ],
    //         'groupsM' => $groups,
    //         'setup_create' => [
    //             'title' => __('crud.new_item', ['item' => __($this->title)]),
    //             'action_link' => route($this->webroute_path . 'index'),
    //             'action_name' => __('crud.back'),
    //             'iscontent' => true,
    //             'action' => route($this->webroute_path . 'store'),
    //         ],
    //         'fields_create' => $this->getFields(),
    //         'countries' => Country::all(),
    //     ]);
    // }

    public function index()
    {
        $this->authChecker();

        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }

        $items = $this->provider::with(['fields', 'groups'])->orderBy('created_at', 'desc');

        // Calculate stats before applying filters (global stats)
        $totalContacts = $this->provider::count();
        $subscribedCount = $this->provider::where('subscribed', true)->count();
        $unsubscribedCount = $this->provider::where('subscribed', false)->count();
        $weeklyContacts = $this->provider::where('created_at', '>=', now()->subWeek())->count();

        // Agent stats - check if user relationship exists and handle gracefully
        $agentStats = null;

        // Option 1: Check if contacts belong to users (without role check)
        if (method_exists($this->provider, 'user')) {
            try {
                $agentStats = \App\Models\User::whereHas('contacts')
                    ->withCount([
                        'contacts',
                        'contacts as subscribed_contacts' => function ($query) {
                            $query->where('subscribed', true);
                        },
                        'contacts as weekly_contacts' => function ($query) {
                            $query->where('contacts.created_at', '>=', now()->subWeek());
                        }
                    ])
                    ->get()
                    ->map(function ($user) {
                        return (object)[
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'total_contacts' => $user->contacts_count,
                            'subscribed_contacts' => $user->subscribed_contacts,
                            'weekly_contacts' => $user->weekly_contacts,
                        ];
                    });
            } catch (\Exception $e) {
                // If there's any error, set to empty collection
                $agentStats = collect();
            }
        }

        // Apply filters (keep your existing filter logic)
        if (request()->has('name') && strlen(request('name')) > 0) {
            $items->where('name', 'like', '%' . request('name') . '%');
        }

        if (request()->has('phone') && strlen(request('phone')) > 0) {
            $items->where('phone', 'like', '%' . request('phone') . '%');
        }

        if (request()->has('email') && strlen(request('email')) > 0) {
            $items->whereHas('fields', function ($query) {
                $query->where('name', 'Email')->where('value', 'like', '%' . request('email') . '%');
            });
        }

        if (request()->has('group') && request('group') != '') {
            $items->whereHas('groups', function ($query) {
                $query->where('groups.id', request('group'));
            });
        }

        if (request()->has('subscribed') && request('subscribed') !== '') {
            $items->where('subscribed', request('subscribed'));
        }

        if (request()->has('country_id') && request('country_id') != '') {
            $items->where('country_id', request('country_id'));
        }

        $totalItems = $items->count();

        // Check for AJAX request
        if (request()->ajax()) {
            $perPage = request('per_page', config('settings.paginate'));
            $items = $items->paginate($perPage);
            return response()->json([
                'html' => view('contacts::contacts.partials.rows', [
                    'items' => $items,
                    'webroute_path' => $this->webroute_path,
                    'parameter_name' => $this->parameter_name,
                ])->render(),
                'pagination' => view('contacts::contacts.partials.pagination', [
                    'items' => $items,
                    'per_page' => $perPage,
                ])->render(),
                'current_page' => $items->currentPage(),
                'per_page' => $perPage,
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
                'hasMorePages' => $items->hasMorePages(),
            ]);
        }

        // Regular request - paginate normally
        $items = $items->paginate(config('settings.paginate'))->appends(request()->query());
        $groups = Group::pluck('name', 'id');

        return view($this->view_path . 'index', [
            'setup' => [
                'usefilter' => true,
                'title' => __('Contacts'),
                'subtitle' => $totalItems == 1 ? __('1 Contact') : $totalItems . ' ' . __('Contacts'),
                'action_link' => route($this->webroute_path . 'create'),
                'action_name' => __('crud.add_new_item', ['item' => __($this->title)]),
                'action_link2' => route($this->webroute_path . 'groups.index'),
                'action_name2' => __('Groups'),
                'action_link3' => route($this->webroute_path . 'fields.index'),
                'action_name3' => __('Fields'),
                'action_link4' => route($this->webroute_path . 'index', ['report' => true]),
                'action_name4' => __('Export'),
                'items' => $items,
                'item_names' => $this->titlePlural,
                'webroute_path' => $this->webroute_path,
                'fields' => $this->getFields(),
                'filterFields' => $this->getFilterFields(),
                'custom_table' => true,
                'parameter_name' => $this->parameter_name,
                'parameters' => count($_GET) != 0,
                'groups' => Group::get(),
            ],
            'groupsM' => $groups,
            'setup_create' => [
                'title' => __('crud.new_item', ['item' => __($this->title)]),
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'iscontent' => true,
                'action' => route($this->webroute_path . 'store'),
            ],
            'fields_create' => $this->getFields(),
            'countries' => Country::all(),

            // Add the stats variables here
            'totalContacts' => $totalContacts,
            'subscribedCount' => $subscribedCount,
            'unsubscribedCount' => $unsubscribedCount,
            'weeklyContacts' => $weeklyContacts,
            'agentStats' => $agentStats,
        ]);
    }

    // public function indexAdd()
    // {
    //     $this->authChecker();

    //     $items = $this->provider::orderBy('id', 'desc');
    //     if (isset($_GET['name']) && strlen($_GET['name']) > 1) {
    //         $items = $items->where('name', 'like', '%' . $_GET['name'] . '%');
    //     }
    //     if (isset($_GET['phone']) && strlen($_GET['phone']) > 1) {
    //         $items = $items->where('phone', 'like', '%' . $_GET['phone'] . '%');
    //     }

    //     if (isset($_GET['group']) && strlen($_GET['group'] . '') > 0) {
    //         $items = $items->whereHas('groups', function ($query) {
    //             $query->where('groups.id', $_GET['group']);
    //         });
    //     }
    //     if (isset($_GET['country_id']) && strlen($_GET['country_id']) > 0) {
    //         $items = $items->where('country_id', $_GET['country_id']);
    //     }

    //     //Check subscribed
    //     if (isset($_GET['subscribed']) && strlen($_GET['subscribed']) > 0) {
    //         $items = $items->where('subscribed', $_GET['subscribed']);
    //     }

    //     if (isset($_GET['report'])) {
    //         //dd($items->with(['fields','groups'])->get());
    //         return $this->exportCSV($items->with(['fields', 'groups'])->get());
    //     }
    //     $totalItems = $items->count();
    //     $items = $items->paginate($totalItems);

    //     return view($this->view_path . 'index-addfield', [
    //         'setup' => [
    //             'usefilter' => true,
    //             'title' => __('crud.item_managment', ['item' => __($this->titlePlural)]),
    //             'subtitle' => $totalItems == 1 ? __('1 Contact') : $totalItems . ' ' . __('Contacts'),
    //             'action_link' => route($this->webroute_path . 'create'),
    //             'action_name' => __('crud.add_new_item', ['item' => __($this->title)]),
    //             'action_link2' => route($this->webroute_path . 'groups.index'),
    //             'action_name2' => __('Groups'),
    //             'action_link3' => route($this->webroute_path . 'fields.index'),
    //             'action_name3' => __('Fields'),
    //             'action_link4' => route($this->webroute_path . 'index', ['report' => true]),
    //             'action_name4' => __('Export'),
    //             'items' => $items,
    //             'item_names' => $this->titlePlural,
    //             'webroute_path' => $this->webroute_path,
    //             'filterFields' => $this->getFilterFields(),
    //             'custom_table' => true,
    //             'parameter_name' => $this->parameter_name,
    //             'parameters' => count($_GET) != 0,
    //             'groups' => Group::where('company_id', auth()->user()->company->id)->get(),
    //             'camposAdicionales' => field::where('company_id', auth()->user()->company->id)->get(),
    //             'contacts' => Contact::where('company_id', auth()->user()->company->id)->get(),
    //         ],
    //     ]);
    // }

    // public function export(Request $request)
    // {
    //     $this->authChecker();

    //     // Build query with all filters
    //     $query = $this->provider::query();

    //     // Apply all your existing filters
    //     if ($request->has('name') && strlen($request->name) > 1) {
    //         $query->where('name', 'like', '%' . $request->name . '%');
    //     }

    //     if ($request->has('phone') && strlen($request->phone) > 1) {
    //         $query->where('phone', 'like', '%' . $request->phone . '%');
    //     }

    //     if (request()->has('email') && strlen(request('email')) > 0) {
    //         $query->whereHas('fields', function ($query) {
    //             $query->where('name', 'Email')->where('value', 'like', '%' . request('email') . '%');
    //         });
    //     }

    //     if (request()->has('group') && request('group') != '') {
    //         $query->whereHas('groups', function ($query) {
    //             $query->where('groups.id', request('group'));
    //         });
    //     }

    //     if (request()->has('subscribed') && request('subscribed') !== '') {
    //         $query->where('subscribed', request('subscribed'));
    //     }

    //     if (request()->has('country_id') && request('country_id') != '') {
    //         $query->where('country_id', request('country_id'));
    //     }

    //     // Add all other filters from your indexAdd method...

    //     // Get the final data
    //     $data = $query->with(['fields', 'groups'])->get();

    //     // Generate file name
    //     $fileName = 'contacts_export_' . date('Y-m-d_His') . '.csv';

    //     // Set headers
    //     $headers = [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    //     ];

    //     // CSV generation callback
    //     $callback = function () use ($data) {
    //         $file = fopen('php://output', 'w');

    //         // Headers
    //         fputcsv($file, ['ID', 'Name', 'Phone', 'Subscribed', 'Groups', 'Fields', 'Created At']);

    //         // Data
    //         foreach ($data as $item) {
    //             fputcsv($file, [$item->id, $item->name, $item->phone, $item->subscribed ? 'Yes' : 'No', $item->groups->pluck('name')->implode(', '), $item->fields->pluck('value')->implode(', '), $item->created_at->format('Y-m-d H:i:s')]);
    //         }

    //         fclose($file);
    //     };

    //     return response()->stream($callback, 200, $headers);
    // }

    public function export(Request $request)
    {
        $this->authChecker();

        // Build query with all filters
        $query = $this->provider::query();

        // Apply filters from request
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }

        if ($request->filled('email')) {
            $query->whereHas('fields', function ($q) use ($request) {
                $q->where('name', 'Email')->where('value', 'like', '%' . $request->input('email') . '%');
            });
        }

        if ($request->filled('group')) {
            $query->whereHas('groups', function ($q) use ($request) {
                $q->where('groups.id', $request->input('group'));
            });
        }

        if ($request->has('subscribed') && $request->input('subscribed') !== '') {
            $query->where('subscribed', $request->input('subscribed'));
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->input('country_id'));
        }

        // Get the final data
        $data = $query->with(['fields', 'groups'])->get();

        // Generate file name
        $fileName = 'contacts_export_' . date('Y-m-d_His') . '.csv';

        // Generate CSV content
        $output = fopen('php://temp', 'w');

        // Headers
        fputcsv($output, ['ID', 'Name', 'Phone', 'Subscribed', 'Groups', 'Fields', 'Created At']);

        // Data
        foreach ($data as $item) {
            fputcsv($output, [
                $item->id,
                $item->name,
                $item->phone,
                $item->subscribed ? 'Yes' : 'No',
                $item->groups->pluck('name')->implode(', '),
                $item->fields->pluck('value')->implode(', '),
                $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '',
            ]);
        }


        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        // Return response with headers
        return response($csvContent, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Content-Length', strlen($csvContent));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexContact($id)
    {
        $this->authChecker();
        // $items_contact = $this->provider::with(['fields', 'groups'])->orderBy('id', 'desc');
        // $items_contact = $items_contact->where('id', $id);
        // $totalItems = $items_contact->count();
        // $items_contact = $items_contact->paginate($totalItems);
        //dd($items_contact[0]->groups);
        $contact = Contact::with('fields', 'groups')->where('id', $id)->get();
        $contacts = Contact::with('fields', 'groups')->whereNull('deleted_at')->get();
        $country = Country::find($contact[0]['country_id']);
        $groups = Group::get();
        $countries = Country::all();
        $camposAdicionales = field::where('company_id', auth()->user()->company->id)->get();

        //dd($contact->groups());
        return view($this->view_path . 'index-contact', [
            'contacts' => $contacts,
            'contact' => $contact,
            'country' => $country,
            'groups' => $groups,
            'countries' => $countries,
            'camposAdicionales' => $camposAdicionales,
        ]);
    }

    public function togglesubs($id)
    {
        $this->authChecker();
        $contact = $this->provider::find($id);

        if (!$contact) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => __('crud.item_not_found'),
                ],
                404,
            );
        }
        $contact->subscribed = $contact->subscribed == 0 ? 1 : 0;
        $contact->save();
        // Return a JSON response
        return response()->json(
            [
                'status' => 'success',
                'message' => __('Subscription status updated successfully.', ['item' => __($this->titlePlural)]),
                'new_status' => $contact->subscribed,
            ],
            200,
        );
    }

    public function exportCSV($contactsToDownload)
    {
        $items = [];
        $cf = Field::get();
        foreach ($contactsToDownload as $key => $contact) {
            $item = [
                'id' => $contact->id,
                'name' => $contact->name,
                'phone' => $contact->phone,
                'avatar' => $contact->avatar,
            ];

            foreach ($cf as $keycf => $scf) {
                $item[$scf->name] = '';
                foreach ($contact->fields as $key => $value) {
                    if ($scf->name == $value['name']) {
                        $item[$value['name']] = $value['pivot']['value'];
                    }
                }
            }

            array_push($items, $item);
        }
        return Excel::download(new ContactsExport($items), 'contacts_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();
        return view($this->view_path . 'edit', [
            'setup' => [
                'title' => __('crud.new_item', ['item' => __($this->title)]),
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'iscontent' => true,
                'action' => route($this->webroute_path . 'store'),
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

        // Normalize phone number: remove all non-digit characters except leading '+'
        $inputPhone = preg_replace('/\D+/', '', $request->phone); // Keep only digits
        //$normalizedPhone = '+' . ltrim($inputPhone, '0'); // Ensure leading '+' and remove leading zeros if necessary

        // Check for existing contacts with either format
        $existingContact = $this->provider::where('phone', $inputPhone)->orWhere('phone', ltrim($inputPhone, '+'))->first();

        if ($existingContact) {
            return response()->json(
                [
                    'errors' => [
                        'phone' => ['Contact with this phone number already exists.'],
                    ],
                ],
                422,
            );
        }

        // Create new contact with normalized phone
        $contact = $this->provider::create([
            'name' => $request->name,
            'phone' => $inputPhone,
            'country_id' => $request->country_id,
        ]);

        // Handle avatar upload if present
        if ($request->hasFile('avatar')) {
            if (config('settings.use_s3_as_storage', false)) {
                $contact->avatar = Storage::disk('s3')->url($request->avatar->storePublicly('uploads/' . $contact->company_id . '/contacts', 's3'));
            } else {
                $contact->avatar = Storage::disk('public_media_upload')->url($request->avatar->store(null, 'public_media_upload'));
            }
            $contact->update();
        }

        // Attach groups if provided
        if ($request->has('groups')) {
            $contact->groups()->attach($request->groups);
        }

        // Sync custom fields if provided
        if (isset($request->custom)) {
            $this->syncCustomFieldsToContact($request->custom, $contact);
        }

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
    public function edit(Contact $contact)
    {
        $this->authChecker();

        $fields = $this->getFields();
        $fields[0]['value'] = $contact->avatar;
        $fields[1]['value'] = $contact->name;
        $fields[2]['value'] = $contact->phone;

        $fields[3]['multipleselected'] = $contact->groups->pluck('id')->toArray();
        $fields[4]['value'] = $contact->country_id;

        if ($this->hasAccessToAIBots()) {
            $fields[5]['value'] = $contact->enabled_ai_bot . '' == '1';
        }

        $customFieldsValues = $contact->fields->toArray();
        foreach ($customFieldsValues as $key => $fieldWithPivot) {
            foreach ($fields as $key => &$formField) {
                if ($formField['id'] == 'custom[' . $fieldWithPivot['id'] . ']') {
                    $formField['value'] = $fieldWithPivot['pivot']['value'];
                }
            }
        }

        $parameter = [];
        $parameter[$this->parameter_name] = $contact->id;
        $title = $contact->name;
        return view($this->view_path . 'edit', [
            'setup' => [
                'title' => $title . ' - ' . ($contact->subscribed == '1' ? __('Subscribed') : __('Opted out')),
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'iscontent' => true,
                'isupdate' => true,
                'action' => route($this->webroute_path . 'update', $parameter),
            ],
            'fields' => $fields,
        ]);
    }

    public function addField(Request $request)
    {
        // Crear un nuevo campo personalizado
        $field = Field::create([
            'name' => $request->input('field_name'),
            'type' => $request->input('field_type'),
        ]);
        return redirect()->back()->with('success', 'Custom field created successfully.');
    }

    public function storeContact(Request $request)
    {
        $this->authChecker();
        $validatedData = $request->validate([
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'company_id' => 'nullable|exists:groups,id',
            'country_id' => 'nullable|string|max:3',
            'phone' => 'nullable|string|max:15',
            'enabled_ia_bot' => 'nullable|boolean',
        ]);

        $contact = Contact::create($validatedData);

        if ($request->hasFile('avatar')) {
            if (config('settings.use_s3_as_storage', false)) {
                $contact->avatar = Storage::disk('s3')->url($request->file('avatar')->storePublicly("uploads/{$contact->company_id}/contacts", 's3'));
            } else {
                $contact->avatar = Storage::disk('public_media_upload')->url($request->file('avatar')->store(null, 'public_media_upload'));
            }
            $contact->country_id = $request->country_id;
            $contact->save();
        }

        if ($request->has('groups')) {
            $contact->groups()->attach($request->groups);
        }

        if (isset($request->custom)) {
            $this->syncCustomFieldsToContact($request->custom, $contact);
        }
        return redirect()->route('contacts.index')->with('success', 'Contact added successfully');
    }

    public function editList(Request $request)
    {
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        $group = Group::findOrFail($request->group_id);

        $group->name = $validatedData['group_name'];

        $group->save();

        return redirect()->back()->with('success', 'El nombre del grupo ha sido actualizado exitosamente.');
    }
    public function storeList(Request $request)
    {
        $validatedData = $request->validate([
            'list_name' => 'required|string|max:255',
        ]);

        $companyId = auth()->user()->company->id;

        $group = new Group();
        $group->name = $validatedData['list_name'];
        $group->company_id = $companyId;
        $group->save();

        return redirect()->back()->with('success', 'Lista guardada exitosamente.');
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
        //dd($request);
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->name = $request->name;
        $item->lastname = $request->lastname;
        $inputPhone = preg_replace('/\D+/', '', $request->phone); // Keep only digits
        $item->phone = $inputPhone;
        $item->country_id = $request->country_id;
        if ($this->hasAccessToAIBots()) {
            $item->enabled_ai_bot = $request->enabled_ai_bot == 'true';
        }

        if ($request->has('avatar')) {
            if (config('settings.use_s3_as_storage', false)) {
                //S3
                $item->avatar = Storage::disk('s3')->url($request->avatar->storePublicly('uploads/' . $item->company_id . '/contacts', 's3'));
            } else {
                $item->avatar = Storage::disk('public_media_upload')->url($request->avatar->store(null, 'public_media_upload'));
            }
        }
        if ($request->avatar_remove == 1) {
            $item->avatar = '';
        }

        $item->update();
        if (isset($request->custom)) {
            $this->syncCustomFieldsToContact($request->custom, $item);
        }
        if (!empty($request->groups)) {
            // Attaching groups to the contact
            $item->groups()->sync($request->groups);
            /* $groups = json_decode($request->groups, true); // Decodifica el JSON
            $groupIds = array_column($groups, 'value'); // Extrae solo los valores (IDs)
            // Attaching groups to the contact
            $contact->groups()->attach($request->groups);
            $item->groups()->sync($groupIds);
            */
        } else {
            $item->groups()->sync([]);
        }
        // $item->update();

        return redirect()
            ->route($this->webroute_path . 'index')
            ->withStatus(__('crud.item_has_been_updated', ['item' => __($this->title)]));
    }

    public function syncCustomFieldsToContact($fields, $contact)
    {
        //dd($fields);
        $contact->fields()->sync([]);
        foreach ($fields as $key => $value) {
            if ($value) {
                $contact->fields()->attach($key, ['value' => $value]);
            }
        }
        $contact->update();
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

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('crud.item_has_been_removed', ['item' => __($this->title)]),
            ]);
        }

        return redirect()
            ->route($this->webroute_path . 'index')
            ->withStatus(__('crud.item_has_been_removed', ['item' => __($this->title)]));
    }

    // public function bulkremove($ids)
    // {
    //     $this->authChecker();
    //     $ids = explode(',', $ids);
    //     $this->provider::destroy($ids);

    //     // Return a JSON response
    //     return response()->json(
    //         [
    //             'status' => 'success',
    //             'message' => __('crud.items_have_been_removed', ['item' => __($this->titlePlural)]),
    //         ],
    //         200,
    //     );
    // }

    // public function subscribe($ids)
    // {
    //     $this->authChecker();
    //     $ids = explode(',', $ids);
    //     $this->provider::whereIn('id', $ids)->update(['subscribed' => 1]);

    //     // Return a JSON response
    //     return response()->json(
    //         [
    //             'status' => 'success',
    //             'message' => __('crud.item_has_been_updated', ['item' => __($this->titlePlural)]),
    //         ],
    //         200,
    //     );
    // }

    // public function unsubscribe($ids)
    // {
    //     $this->authChecker();
    //     $ids = explode(',', $ids);
    //     $this->provider::whereIn('id', $ids)->update(['subscribed' => 0]);

    //     // Return a JSON response
    //     return response()->json(
    //         [
    //             'status' => 'success',
    //             'message' => __('crud.item_has_been_updated', ['item' => __($this->titlePlural)]),
    //         ],
    //         200,
    //     );
    // }

    // public function assigntogroup($ids)
    // {
    //     $this->authChecker();
    //     $ids = explode(',', $ids);
    //     $group = Group::find($_GET['group_id']);

    //     if (!$group) {
    //         // Group not found, return an error response
    //         return response()->json(
    //             [
    //                 'status' => 'error',
    //                 'message' => __('No group selected'),
    //             ],
    //             404,
    //         );
    //     }

    //     $group->contacts()->syncWithoutDetaching($ids);

    //     // Return a JSON response
    //     return response()->json(
    //         [
    //             'status' => 'success',
    //             'message' => __('crud.items_has_been_updated', ['item' => __($this->titlePlural)]),
    //         ],
    //         200,
    //     );
    // }

    // public function removefromgroup($ids)
    // {
    //     $this->authChecker();
    //     $ids = explode(',', $ids);
    //     $group = Group::find($_GET['group_id']);

    //     if (!$group) {
    //         // Group not found, return an error response
    //         return response()->json(
    //             [
    //                 'status' => 'error',
    //                 'message' => __('No group selected'),
    //             ],
    //             404,
    //         );
    //     }

    //     $group->contacts()->detach($ids);

    //     // Return a JSON response
    //     return response()->json(
    //         [
    //             'status' => 'success',
    //             'message' => __('crud.items_has_been_updated', ['item' => __($this->titlePlural)]),
    //         ],
    //         200,
    //     );
    // }

    public function importindex()
    {
        $groups = Group::pluck('name', 'id');
        return view('contacts::' . $this->webroute_path . 'import', ['groups' => $groups]);
    }

    public function readDocument(Request $request)
    {
        $headers = Excel::toArray(new HeadingRowImport(), $request->csv);
        $excel = Excel::toArray(new ContactsRead(), $request->csv);
        return [
            'headers' => $headers[0][0],
            'data' => $excel[0],
        ];
    }

    // public function import(Request $request)
    // {
    //     $lastContact = $this->provider::orderBy('id', 'desc')->first();
    //     Excel::import(new ContactsImport(), $request->csv);

    //     //Assign to group
    //     if ($request->group) {
    //         //Get the contacts, that are newer than the previous id
    //         $contactToApply = null;

    //         //Find the contacts based on the phone in the attached csv
    //         $csvData = Excel::toArray(new ContactsImport(), $request->csv);
    //         $phoneNumbers = array_column($csvData[0], 'phone');
    //         //In each row of the csv, we have the phone number, add + at start
    //         $phoneNumbers = array_map(function ($phone) {
    //             return strpos($phone, '+') != false ? $phone : '+' . $phone;
    //         }, $phoneNumbers);
    //         $contactToApply = $this->provider::whereIn('phone', $phoneNumbers)->pluck('id');

    //         if ($contactToApply) {
    //             $group = Group::find($request->group);
    //             $group->contacts()->attach($contactToApply);
    //         }
    //     }
    //     return redirect()
    //         ->route($this->webroute_path . 'index')
    //         ->withStatus(__('Contacts imported'));
    // }

    // public function imports(Request $request)
    // {
    //     $result = [];
    //     $errors = [];
    //     $headers = $request->fields;
    //     $headerkeys = array_keys($request->fields);

    //     foreach ($request->contacts['data'] as $i => $item) {
    //         $newItem = [];
    //         foreach ($headerkeys as $headerKey) {
    //             $itemHeader = array_keys($item)[$headerKey];
    //             $newItem[$headers[$headerKey]] = $item[$itemHeader];
    //         }
    //         if (!array_key_exists('phone', $newItem) || !array_key_exists('name', $newItem)) {
    //             $errors[] = 'Error in the document: The columns "phone" and "name" must correspond to "phone" and "number" in step 2.';
    //             break;
    //         } elseif (strlen($newItem['phone']) < 1 && strlen($newItem['name']) < 1) {
    //             $errors[] = 'You must add data in row ' . ($i + 2) . ' of your document: The phone and name fields are required.';
    //             continue;
    //         } elseif (strlen($newItem['name']) < 1) {
    //             $errors[] = 'The name field is required in row ' . ($i + 2) . '.';
    //             continue;
    //         } elseif (strlen($newItem['phone']) < 1) {
    //             $errors[] = 'The phone field is required in row ' . ($i + 2) . '.';
    //             continue;
    //         }

    //         $newItem['phone'] = '+' . preg_replace('/[^0-9]/', '', $newItem['phone']);

    //         $prevContact = Contact::where('phone', $newItem['phone'])->first();
    //         if ($prevContact) {
    //             continue;
    //         }

    //         try {
    //             $newContact = new Contact($newItem);
    //             $newContact->save();
    //             if ($newContact) {
    //                 $result['success'][] = $newContact;
    //             } else {
    //                 $errors[] = $newContact;
    //             }
    //         } catch (\Exception $e) {
    //             $errors[] = $e;
    //             continue;
    //         }

    //         if (isset($request->group) && isset($newContact->id)) {
    //             try {
    //                 $group = Group::find($request->group);
    //                 $contact = Contact::find($newContact->id);

    //                 if (!$group->contacts->contains($contact)) {
    //                     $group->contacts()->save($contact);
    //                 }
    //             } catch (\Exception $e) {
    //                 $errors[] = $e;
    //                 continue;
    //             }
    //         }

    //         //Assign to group
    //         /* if ($request->group) {
    //             $lastContact = $this->provider::orderBy('id', 'desc')->first();
    //             //Get the contacts, that are newer than the previous id
    //             $contactToApply = null;
    //             if ($lastContact) {
    //                 $contactToApply = $this->provider::where('id', '>', $lastContact->id)->pluck('id');
    //             } else {
    //                 $contactToApply = $this->provider::pluck('id');
    //             }
    //             if ($contactToApply) {
    //                 $group = Group::find($request->group);
    //                 $group->contacts()->attach($contactToApply);
    //             }
    //             dd($lastContact, $contactToApply);
    //         } */
    //     }

    //     $result['errors'] = $errors;
    //     return $result;
    // }

    /**
     * Assign contacts to group
     */
    public function assigntogroup(Request $request)
    {
        $this->authChecker();

        $ids = $request->input('ids'); // Array of contact IDs
        $groupIds = $request->input('group_ids'); // Array of group IDs

        if (empty($groupIds)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => __('No group selected'),
                ],
                400,
            );
        }

        foreach ($groupIds as $groupId) {
            $group = Group::find($groupId);
            if ($group) {
                $group->contacts()->syncWithoutDetaching($ids); // Add contacts to each group
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => __('Contacts assigned to groups successfully!'),
        ]);
    }

    /**
     * Remove contacts from group
     */
    public function removefromgroup(Request $request)
    {
        $this->authChecker();

        $ids = $request->input('ids'); // Array of contact IDs
        $groupIds = $request->input('group_ids'); // Array of group IDs

        if (empty($groupIds)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => __('No group selected'),
                ],
                400,
            );
        }

        foreach ($groupIds as $groupId) {
            $group = Group::find($groupId);
            if ($group) {
                $group->contacts()->detach($ids); // Remove contacts from each selected group
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => __('Contacts removed from groups successfully!'),
        ]);
    }

    /**
     * Bulk remove contacts
     */
    public function bulkremove(Request $request)
    {
        $this->authChecker();
        $ids = $request->input('contact_ids');
        $this->provider::destroy($ids);

        return response()->json(
            [
                'status' => 'success',
                'message' => __('Selected contacts have been removed successfully.', ['item' => __($this->titlePlural)]),
            ],
            200,
        );
    }

    /**
     * Bulk subscribe contacts
     */
    public function bulksubscribe(Request $request)
    {
        $this->authChecker();
        $ids = $request->input('ids');
        $this->provider::whereIn('id', $ids)->update(['subscribed' => 1]);

        return response()->json(
            [
                'status' => 'success',
                'message' => __('Selected contacts have been successfully subscribed.', ['item' => __($this->titlePlural)]),
            ],
            200,
        );
    }

    /**
     * Bulk unsubscribe contacts
     */
    public function bulkunsubscribe(Request $request)
    {
        $this->authChecker();
        $ids = $request->input('ids');
        $this->provider::whereIn('id', $ids)->update(['subscribed' => 0]);

        return response()->json(
            [
                'status' => 'success',
                'message' => __('Selected contacts have been successfully unsubscribed', ['item' => __($this->titlePlural)]),
            ],
            200,
        );
    }

    public function paginateContacts(Request $request)
    {
        $contacts = Contact::paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.contacts', compact('contacts'))->render(),
            ]);
        }

        return view('contacts.index', compact('contacts'));
    }

    public function newimportindex()
    {
        $this->authChecker();

        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }
        $groups = Group::pluck('name', 'id');
        return view('contacts::' . $this->webroute_path . 'newimport', ['groups' => $groups]);
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 100000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    // public function importChunk(Request $request)
    // {
    //     $csvData = $this->csvToArray($request->csv_chunk);

    //     // Get existing fields with normalized names
    //     $existingFields = Field::all()
    //         ->mapWithKeys(function ($field) {
    //             $normalizedName = strtolower(trim($field->name));
    //             return [$normalizedName => $field->id];
    //         })
    //         ->toArray();

    //     $countryCodes = Country::pluck('id', 'phone_code')->toArray();
    //     $standardFields = ['name', 'phone', 'avatar', 'company_id', 'country_id'];

    //     $newContacts = [];
    //     $contactsToUpdate = [];
    //     $customFieldsData = [];
    //     $allPossiblePhones = [];

    //     // Collect phone variations
    //     foreach ($csvData as $obj) {
    //         $originalPhone = $obj['phone'];
    //         $normalizedPhone = strpos($originalPhone, '+') !== false ? $originalPhone : '+' . $originalPhone;
    //         $allPossiblePhones = array_merge($allPossiblePhones, [$normalizedPhone, $originalPhone]);
    //     }

    //     // Get existing contacts
    //     $existingContacts = $this->provider
    //         ::whereIn('phone', $allPossiblePhones)
    //         ->get()
    //         ->keyBy('phone')
    //         ->map(function ($contact) {
    //             return ['id' => $contact->id, 'name' => $contact->name];
    //         })
    //         ->toArray();

    //     foreach ($csvData as $obj) {
    //         $originalPhone = $obj['phone'];
    //         $phone = strpos($originalPhone, '+') !== false ? $originalPhone : '+' . $originalPhone;

    //         // Contact existence check
    //         $existingEntry = $existingContacts[$phone] ?? ($existingContacts[$originalPhone] ?? null);

    //         if ($existingEntry) {
    //             // Name update check
    //             if ($existingEntry['name'] !== $obj['name']) {
    //                 $contactsToUpdate[] = [
    //                     'id' => $existingEntry['id'],
    //                     'name' => $obj['name'],
    //                 ];
    //             }
    //         } else {
    //             // New contact creation
    //             $country_id = $this->getCountryByPhoneNumber($phone, $countryCodes);
    //             $newContacts[$phone] = [
    //                 'name' => $obj['name'],
    //                 'phone' => $phone,
    //                 'tmp_group_id' => $request->group_id,
    //                 'company_id' => session('company_id', null),
    //                 'country_id' => $country_id,
    //                 'created_at' => now(),
    //             ];
    //         }

    //         // Custom field processing
    //         foreach ($obj as $fieldName => $value) {
    //             $normalizedFieldName = strtolower(trim($fieldName));

    //             if (!in_array($normalizedFieldName, $standardFields) && !empty($value)) {
    //                 // Field creation with normalized name
    //                 if (!isset($existingFields[$normalizedFieldName])) {
    //                     $field = Field::firstOrCreate(
    //                         ['name' => $normalizedFieldName], // Ensures case-insensitive uniqueness
    //                         ['type' => 'text'],
    //                     );
    //                     $existingFields[$normalizedFieldName] = $field->id;
    //                 }

    //                 $customFieldsData[] = [
    //                     'phone' => $phone,
    //                     'field_id' => $existingFields[$normalizedFieldName],
    //                     'value' => $value,
    //                 ];
    //             }
    //         }
    //     }

    //     // Bulk update names
    //     if (!empty($contactsToUpdate)) {
    //         $this->provider::upsert($contactsToUpdate, ['id'], ['name']);
    //     }

    //     // Insert new contacts
    //     if (!empty($newContacts)) {
    //         $this->provider::insert(array_values($newContacts));
    //     }

    //     // Get all contact IDs
    //     $allContactIds = $this->provider::whereIn('phone', $allPossiblePhones)->pluck('id', 'phone')->toArray();

    //     // Prepare custom field data
    //     $customFieldInserts = [];
    //     foreach ($customFieldsData as $fieldData) {
    //         if (isset($allContactIds[$fieldData['phone']])) {
    //             $customFieldInserts[] = [
    //                 'contact_id' => $allContactIds[$fieldData['phone']],
    //                 'custom_contacts_field_id' => $fieldData['field_id'],
    //                 'value' => $fieldData['value'],
    //             ];
    //         }
    //     }

    //     // Upsert custom fields
    //     if (!empty($customFieldInserts)) {
    //         DB::table('custom_contacts_fields_contacts')->upsert($customFieldInserts, ['contact_id', 'custom_contacts_field_id'], ['value']);
    //     }

    //     // Group assignment
    //     if ($request->group_id && !empty($allContactIds)) {
    //         $group = Group::find($request->group_id);
    //         $existingGroupContacts = $group->contacts()->pluck('contacts.id')->toArray();
    //         $newGroupContacts = array_diff(array_values($allContactIds), $existingGroupContacts);

    //         if (!empty($newGroupContacts)) {
    //             $group->contacts()->attach($newGroupContacts);
    //         }
    //     }

    //     // Cleanup temporary group ID
    //     if ($request->group_id) {
    //         $this->provider::where('tmp_group_id', $request->group_id)->update(['tmp_group_id' => null]);
    //     }

    //     return response()->json(['success' => true, 'message' => 'Contacts processed successfully']);
    // }

    public function importChunk(Request $request)
    {
        $csvData = $this->csvToArray($request->csv_chunk);

        // Helper to normalize phones (digits only)
        $normalizePhone = function ($phone) {
            return preg_replace('/\D+/', '', $phone);
        };

        // Get existing fields with normalized names
        $existingFields = Field::all()
            ->mapWithKeys(function ($field) {
                $normalizedName = strtolower(trim($field->name));
                return [$normalizedName => $field->id];
            })
            ->toArray();

        $countryCodes = Country::pluck('id', 'phone_code')->toArray();
        $standardFields = ['name', 'phone', 'avatar', 'company_id', 'country_id'];

        $newContacts = [];
        $contactsToUpdate = [];
        $customFieldsData = [];
        $allPossiblePhones = [];

        // Collect normalized phones (skip empty phones)
        foreach ($csvData as $obj) {
            $normalizedPhone = $normalizePhone($obj['phone']);
            if (!empty($normalizedPhone)) {
                $allPossiblePhones[] = $normalizedPhone;
            }
        }

        // Get existing contacts (all normalized phones)
        $existingContacts = $this->provider
            ::whereIn('phone', $allPossiblePhones)
            ->get()
            ->keyBy('phone')
            ->map(function ($contact) {
                return ['id' => $contact->id, 'name' => $contact->name];
            })
            ->toArray();

        foreach ($csvData as $obj) {
            $phone = $normalizePhone($obj['phone']);

            // Skip row if phone is empty
            if (empty($phone)) {
                continue;
            }

            // If name is empty, use phone instead
            $name = !empty($obj['name']) ? $obj['name'] : $phone;

            // Contact existence check
            $existingEntry = $existingContacts[$phone] ?? null;

            if ($existingEntry) {
                // Name update check
                if ($existingEntry['name'] !== $name) {
                    $contactsToUpdate[] = [
                        'id' => $existingEntry['id'],
                        'name' => $name,
                    ];
                }
            } else {
                // New contact creation
                $country_id = $this->getCountryByPhoneNumber($phone, $countryCodes);
                $newContacts[$phone] = [
                    'name' => $name,
                    'phone' => $phone,
                    'tmp_group_id' => $request->group_id,
                    'company_id' => session('company_id', null),
                    'country_id' => $country_id,
                    'created_at' => now(),
                ];
            }

            // Custom field processing
            foreach ($obj as $fieldName => $value) {
                $normalizedFieldName = strtolower(trim($fieldName));

                if (!in_array($normalizedFieldName, $standardFields) && !empty($value)) {
                    // Field creation with normalized name
                    if (!isset($existingFields[$normalizedFieldName])) {
                        $field = Field::firstOrCreate(['name' => $normalizedFieldName], ['type' => 'text']);
                        $existingFields[$normalizedFieldName] = $field->id;
                    }

                    $customFieldsData[] = [
                        'phone' => $phone,
                        'field_id' => $existingFields[$normalizedFieldName],
                        'value' => $value,
                    ];
                }
            }
        }

        // Bulk update names
        if (!empty($contactsToUpdate)) {
            $this->provider::upsert($contactsToUpdate, ['id'], ['name']);
        }

        // Insert new contacts
        if (!empty($newContacts)) {
            $this->provider::insert(array_values($newContacts));
        }

        // Get all contact IDs (with normalized phones)
        $allContactIds = $this->provider::whereIn('phone', $allPossiblePhones)->pluck('id', 'phone')->toArray();

        // Prepare custom field data
        $customFieldInserts = [];
        foreach ($customFieldsData as $fieldData) {
            if (isset($allContactIds[$fieldData['phone']])) {
                $customFieldInserts[] = [
                    'contact_id' => $allContactIds[$fieldData['phone']],
                    'custom_contacts_field_id' => $fieldData['field_id'],
                    'value' => $fieldData['value'],
                ];
            }
        }

        // Upsert custom fields
        if (!empty($customFieldInserts)) {
            DB::table('custom_contacts_fields_contacts')->upsert($customFieldInserts, ['contact_id', 'custom_contacts_field_id'], ['value']);
        }

        // Group assignment
        if ($request->group_id && !empty($allContactIds)) {
            $group = Group::find($request->group_id);
            $existingGroupContacts = $group->contacts()->pluck('contacts.id')->toArray();
            $newGroupContacts = array_diff(array_values($allContactIds), $existingGroupContacts);

            if (!empty($newGroupContacts)) {
                $group->contacts()->attach($newGroupContacts);
            }
        }

        // Cleanup temporary group ID
        if ($request->group_id) {
            $this->provider::where('tmp_group_id', $request->group_id)->update(['tmp_group_id' => null]);
        }

        return response()->json(['success' => true, 'message' => 'Contacts processed successfully']);
    }

    /**
     * Optimized function to get country_id from phone number.
     */
    private function getCountryByPhoneNumber($phoneNumber, $countryCodes)
    {
        // Ensure phone number starts with "+"
        if (strpos($phoneNumber, '+') !== 0) {
            $phoneNumber = '+' . $phoneNumber;
        }

        // Sort country codes by length (longest first)
        uksort($countryCodes, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        // Match country code from longest to shortest
        foreach ($countryCodes as $code => $country_id) {
            if (strpos($phoneNumber, '+' . $code) === 0) {
                return $country_id;
            }
        }

        return null;
    }

    public function convertToLead(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
        ]);

        $companyId = auth()->user()->company_id;
        $userId = auth()->id();

        $convertedCount = 0;
        $skippedCount   = 0;
        $leadIds        = [];

        foreach ($request->contacts as $contactId) {
            $contact = Contact::find($contactId);

            if (!$contact) {
                continue; // skip if contact not found
            }

            $leadData = [
                'company_id'    => $companyId,
                'contact_id'    => $contact->id,
                'stage'         => 'New',
                'notifications' => 1,
            ];

            // Create lead if it doesn't exist
            $lead = Lead::firstOrCreate(
                ['company_id' => $companyId, 'contact_id' => $contact->id],
                $leadData
            );

            $leadIds[] = $lead->id;

            if (empty($contact->user_id)) {
                $contact->update(['user_id' => $userId]);
                $convertedCount++;
            } else {
                $skippedCount++;
            }
        }

        // Build message
        if ($convertedCount > 0) {
            $message = "{$convertedCount} contacts converted to leads";
            if ($skippedCount > 0) {
                $message .= ", {$skippedCount} not converted (already assigned).";
            } else {
                $message .= ".";
            }
        } else {
            $message = "0 contacts converted to leads. All were already assigned.";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'leads'   => $leadIds,
        ]);
    }
}
