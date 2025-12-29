<?php

namespace Modules\Whatsappflows\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Modules\Wpbox\Models\WhatsappFlowsModel;
use Modules\Wpbox\Models\WhatsAppFlowsSubmittion;
use Modules\Wpbox\Models\WhatsAppFlowsViewLayout;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FromCollectionExport;

class Main extends Controller
{
    /**
     * Provide class.
     */
    private $provider = WhatsappFlowsModel::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'whatsapp-flows.';

    /**
     * View path.
     */
    private $view_path = 'whatsappflows::';

    /**
     * Parameter name.
     */
    private $parameter_name = 'whatsapp-flows';

    /**
     * Title of this crud.
     */
    private $title = 'whatsapp flows';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'whatsapp flows';

    public $facebookAPI = 'https://graph.facebook.com/v21.0/';

    private function getToken(Company $company = null)
    {
        if ($company == null) {
            $company = $this->getCompany();
        }
        return $company->getConfig('whatsapp_permanent_access_token', '');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }

        // Start building the query
        $query = $this->provider::orderBy('created_at', 'desc');

        // Get the search and status from the request
        $search = request()->input('search');
        $status = request()->input('status');

        // Set default status to PUBLISHED if no status is specified
        $defaultStatus = 'PUBLISHED';

        if (!empty($search)) {
            $query->where('flow_name', 'like', '%' . $search . '%');
        }

        // Handle status filter (including "All Status")

        // Handle status filter
        if ($status == 'all') {
            // "All Status" selected - no filtering
            $defaultStatus = 'ALLStatus';
        } elseif ($status) {
            $query->where('status', $status);
        } else {
            // Default case: show published
            $query->where('status', $defaultStatus);
        }
        // Add the withCount for the relationship
        $items = $query->withCount('whatsAppFlowDataCount')->paginate(config('settings.paginate'));

        return view($this->view_path . 'index', [
            'setup' => [
                'title' => __('List of WhatsApp Flows'),
                'action_link' => route($this->webroute_path . 'load'),
                'action_icon' => '',
                'action_name' => __('Sync'),
                'action_link3' => route($this->webroute_path . 'create'),
                'action_icon3' => '',
                'action_name3' => '+ ' . __('Create flow'),
                'items' => $items,
                'item_names' => $this->titlePlural,
                'webroute_path' => $this->webroute_path,
                'fields' => [],
                'custom_table' => true,
                'parameter_name' => $this->parameter_name,
                'parameters' => count($_GET) != 0,
                'default_status' => $defaultStatus,
            ],
        ]);
    }

    public function loadTemplates()
    {
        if ($this->loadFlowsTemplatesFromWhatsApp()) {
            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('flow_has_been_updated', ['item' => __($this->titlePlural)]));
            // Process $responseData as needed
        } else {
            // Handle error response
            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('error', ['error' => 'Error']));
        }
    }

    public function loadFlowsTemplatesFromWhatsApp($after = '')
    {
        $company = auth()->user()->resolveCurrentCompany();

        $whatsapp_business_account_id = $company->getConfig('whatsapp_business_account_id', '');

        $url = $this->facebookAPI . $whatsapp_business_account_id . '/flows';
        $accessToken = $company->getConfig('whatsapp_permanent_access_token', '');

        $queryParams = [
            'fields' => 'id,name,categories,preview,status,validation_errors,json_version,data_api_version,endpoint_uri,whatsapp_business_account,application,health_status,assets',
            'limit' => 100,
        ];
        if ($after != '') {
            $queryParams['after'] = $after;
        }

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        $response = Http::withHeaders($headers)->get($url, $queryParams);

        if ($response->successful()) {
            $responseData = $response->json();

            if ($after == '') {
                WhatsappFlowsModel::query()->each(function ($model) {
                    try {
                        $model->delete();
                    } catch (\Throwable $th) {
                    }
                });
            }

            $companyID = $company->id;
            foreach ($responseData['data'] as $key => $flowTemplate) {
                try {
                    $entitiesID = null;
                    foreach ($flowTemplate['health_status']['entities'] as $entity) {
                        if ($entity['entity_type'] === 'FLOW') {
                            $entitiesID = $entity['id'];
                        }
                    }

                    $unique_screen_id = null;
                    $result = $this->fetchIdFromJson($flowTemplate['assets']['data'][0]['download_url']);
                    if ($result['status'] == 200) {
                        $unique_screen_id = $result['id'];
                    } else {
                        return redirect()
                            ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                            ->withStatus(__('error', ['error' => 'Error']));
                    }
                    // dd($result );
                    $data = [
                        'company_id' => $companyID,
                        'flow_name' => $flowTemplate['name'],
                        'whatsapp_flow_category' => json_encode($flowTemplate['categories']),
                        'whatsapp_bot_reply' => null,
                        'screen_id' => $unique_screen_id,
                        'form_title' => $flowTemplate['name'],
                        'unique_flow_id' => $flowTemplate['id'],
                        'form_data' => null,
                        'flow_data' => null,
                        'unique_file_name' => null,
                        'can_send_message' => $flowTemplate['health_status']['can_send_message'],
                        'entity_id' => $entitiesID,
                        'preview_url' => $flowTemplate['preview']['preview_url'],
                        'download_url' => $flowTemplate['assets']['data'][0]['download_url'],
                        'status' => $flowTemplate['status'],
                    ];
                    //dd($data);

                    try {
                        $flowTemplate = WhatsappFlowsModel::upsert($data, 'unique_flow_id', ['whatsapp_flow_category', 'status']);
                    } catch (\Exception $e) {
                        //   dd($e);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                    //  dd($th);
                }
            }

            // Check if we have more templates
            if (isset($responseData['paging']) && isset($responseData['paging']['next']) && isset($responseData['paging']['cursors']['after'])) {
                return $this->loadFlowsTemplatesFromWhatsApp($responseData['paging']['cursors']['after']);
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function fetchIdFromJson($jsonFileURL)
    {
        try {
            $response = Http::get($jsonFileURL);
            if ($response->successful()) {
                $data = $response->json();
                $id = $data['screens'][0]['id'] ?? null;
                if ($id) {
                    return ['status' => 200, 'id' => $id];
                } else {
                    return ['status' => 404];
                }
            } else {
                return response()->json(['error' => 'Failed to fetch the JSON data.'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('whatsappflows::create', [
            'setup' => [
                'inrow' => true,
                'title' => __('crud.new_item', ['item' => __('WhatsApp Flows')]),
                'action_link' => route($this->webroute_path . 'index'),
                'action_name' => __('crud.back'),
                'action_icon' => '',
                'iscontent' => true,
                'action' => route($this->webroute_path . 'store'),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $company = auth()->user()->resolveCurrentCompany();
        $whatsapp_business_account_id = $company->getConfig('whatsapp_business_account_id', '');
        // dd($request->all());
        // dd($whatsapp_business_account_id);
        $flow_name = $request->flow_name;
        $whatsapp_flow_category = $request->whatsapp_flow_category;
        $form_title = $request->form_title;
        $screen_id = $request->screen_id; //strtolower(preg_replace('/[^a-zA-Z]/', '', $form_title));
        $unique_flow_id = null;
        $form_data = $request->form_data;

        if ($form_data && $flow_name && $whatsapp_flow_category && $screen_id && $form_title) {
            $form_data_array = json_decode($form_data, true);

            $flow_form_builder = [
                'version' => '7.2',
                'screens' => [
                    [
                        'id' => $screen_id,
                        'title' => $form_title,
                        'terminal' => true,
                        'success' => true,
                        'layout' => [
                            'type' => 'SingleColumnLayout',
                            'children' => [
                                [
                                    'type' => 'Form',
                                    'name' => 'user_data',
                                    'children' => [],
                                ],
                            ],
                        ],
                    ],
                ],
            ];

            foreach ($form_data_array as $i => $field) {
                $field_data = [];

                // Safe defaults
                $field_label = $field['label'] ?? "Field {$i}";
                $field_name = $field['name'] ?? "field_{$i}";
                $field_req = $field['required'] ?? false;

                // Default input type = text
                $input_type = 'text';

                // First check subtype
                if (!empty($field['subtype'])) {
                    switch ($field['subtype']) {
                        case 'email':
                            $input_type = 'email';
                            break;
                        case 'tel':
                            $input_type = 'phone';
                            break;
                        case 'date':
                            $input_type = 'date';
                            break;
                    }
                } else {
                    // If no subtype, fall back to type
                    switch ($field['type']) {
                        case 'email':
                            $input_type = 'email';
                            break;
                        case 'tel':
                            $input_type = 'phone';
                            break;
                        case 'date':
                            $input_type = 'date';
                            break;
                        default:
                            $input_type = 'text';
                            break;
                    }
                }

                switch ($field['type']) {
                    case 'header':
                        $field_data = [
                            'type' => 'TextSubheading',
                            'text' => $field_label,
                        ];
                        break;

                    case 'text':
                    case 'email':
                    case 'tel':
                        $field_data = [
                            'type' => 'TextInput',
                            'input-type' => $input_type,
                            'required' => $field_req,
                            'label' => $field_label,
                            'name' => $field_name,
                        ];
                        break;

                    case 'textarea':
                        $field_data = [
                            'type' => 'TextArea',
                            'required' => $field_req,
                            'label' => $field_label,
                            'name' => $field_name,
                        ];
                        break;

                    case 'checkbox-group':
                        $checkbox_options = [];
                        foreach ($field['values'] ?? [] as $option) {
                            $checkbox_options[] = [
                                'id' => $option['value'] ?? '',
                                'title' => $option['label'] ?? '',
                            ];
                        }
                        $field_data = [
                            'type' => 'CheckboxGroup',
                            'label' => $field_label,
                            'required' => $field_req,
                            'name' => $field_name,
                            'data-source' => $checkbox_options,
                        ];
                        break;

                    case 'radio-group':
                        $radio_options = [];
                        foreach ($field['values'] ?? [] as $option) {
                            $radio_options[] = [
                                'id' => $option['value'] ?? '',
                                'title' => $option['label'] ?? '',
                            ];
                        }
                        $field_data = [
                            'type' => 'RadioButtonsGroup',
                            'label' => $field_label,
                            'required' => $field_req,
                            'name' => $field_name,
                            'data-source' => $radio_options,
                        ];
                        break;

                    case 'select':
                        $select_options = [];
                        foreach ($field['values'] ?? [] as $option) {
                            $select_options[] = [
                                'id' => $option['value'] ?? '',
                                'title' => $option['label'] ?? '',
                            ];
                        }
                        $field_data = [
                            'type' => 'Dropdown',
                            'label' => $field_label,
                            'required' => $field_req,
                            'name' => $field_name,
                            'data-source' => $select_options,
                        ];
                        break;

                    case 'date':
                        $field_data = [
                            'type' => 'DatePicker',
                            'required' => $field_req,
                            'label' => $field_label,
                            'name' => $field_name,
                        ];
                        break;
                }

                if (!empty($field_data)) {
                    $flow_form_builder['screens'][0]['layout']['children'][0]['children'][] = $field_data;
                }
            }

            $flow_form_builder['screens'][0]['layout']['children'][0]['children'][] = [
                'type' => 'Footer',
                'label' => 'Submit Button',
                'on-click-action' => [
                    'name' => 'complete',
                    'payload' => array_reduce(
                        $form_data_array,
                        function ($carry, $field) {
                            // Skip adding the button to the payload
                            if (isset($field['name']) && $field['type'] !== 'button') {
                                $carry[$field['name']] = '${form.' . $field['name'] . '}';
                            }
                            return $carry;
                        },
                        [],
                    ),
                ],
            ];

            $flow_form_builder['screens'][0]['layout']['children'][0]['children'] = array_filter($flow_form_builder['screens'][0]['layout']['children'][0]['children']);
            $flow_form_builder['screens'][0]['layout']['children'][0]['children'] = array_values($flow_form_builder['screens'][0]['layout']['children'][0]['children']);

            $flow_form_output = json_encode($flow_form_builder, JSON_PRETTY_PRINT);

            //  dd($flow_form_output);

            // $unique_file_name = $whatsapp_business_account_id . '_' . $screen_id . '_' . random_int(1000, 9999) . '.json';

            $accessToken = $company->getConfig('whatsapp_permanent_access_token', '');
            if ($whatsapp_business_account_id && $accessToken) {
                $post_url = $this->facebookAPI . $whatsapp_business_account_id . '/flows/';

                $url = 'https://graph.facebook.com/v21.0/' . $whatsapp_business_account_id . '/flows?fields=id,name,categories,preview,status,validation_errors,json_version,data_api_version,endpoint_uri,whatsapp_business_account,application,health_status,assets';

                $formData = [
                    'name' => $form_title,
                    'categories' => json_encode($whatsapp_flow_category),
                    'access_token' => $accessToken,
                ];

                $response = Http::asForm()->post($url, $formData);

                $responseID = null;
                $errorMessage = null;
                $userMessage = null;

                if ($response->getStatusCode() === 200) {
                    $data = json_decode($response->getBody(), true);
                    if (isset($data['id'])) {
                        $responseID = $data['id'];
                        //$unique_file_name = $screen_id . '_' . random_int(10000, 99999) . '.json';
                        $unique_file_name = $responseID . '.json';
                        // $directory_to_save_json = 'flows/json';
                        //  dd($directory_to_save_json);
                        Storage::disk('public_file_json_upload')->put($unique_file_name, $flow_form_output);

                        $file_path = $unique_file_name;

                        $isFileSaved = Storage::disk('public_file_json_upload')->put($file_path, $flow_form_output);
                    } else {
                        $errorMessage = "Success response, but 'id' not found.";
                    }
                } elseif ($response->getStatusCode() === 400) {
                    $error = json_decode($response->getBody(), true);
                    if (isset($error['error'])) {
                        $errorMessage = $error['error']['message'] ?? 'Unknown error';
                        $userMessage = $error['error']['error_user_msg'] ?? 'No user message provided';
                        //echo "Error: $errorMessage\nUser Message: $userMessage";
                    } else {
                        //   echo "Error response received, but details not found.";
                    }
                } else {
                    $errorMessage = 'Unexpected status code: ' . $response->getStatusCode();
                }

                $entitiesID = null;
                // Extract entities where entity_type is "FLOW"
                foreach ($data['health_status']['entities'] as $entity) {
                    if ($entity['entity_type'] === 'FLOW') {
                        $entitiesID = $entity['id'];
                    }
                }

                if ($responseID && $entitiesID) {
                    $whatsappflows = WhatsappFlowsModel::create([
                        'company_id' => $company->id,
                        'flow_name' => $flow_name,
                        'whatsapp_flow_category' => json_encode($whatsapp_flow_category),
                        'whatsapp_bot_reply' => null,
                        'screen_id' => $screen_id,
                        'form_title' => $form_title,
                        'unique_flow_id' => $responseID,
                        'form_data' => json_encode($form_data),
                        'flow_data' => json_encode($flow_form_output),
                        'unique_file_name' => $unique_file_name,
                        'can_send_message' => $data['health_status']['can_send_message'],
                        'entity_id' => $entitiesID,
                        'preview_url' => $data['preview']['preview_url'],
                        'download_url' => $data['assets']['data'][0]['download_url'],
                        'status' => 'DRAFT',
                    ]);
                    $whatsappflows->save();

                    return json_encode([
                        'error' => false,
                    ]);
                }
                return json_encode([
                    'error' => true,
                ]);
            }
        }

        // dd(json_encode($formdata_output, JSON_PRETTY_PRINT));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->provider::find($id);
        if ($item) {
            try {
                $result = $this->deleteWhatsAppFlowTemplate($item->unique_flow_id);
            } catch (\Exception $e) {
                //  dd($e);
            }
            // dd($result);
            if ($result['status'] == 200) {
                $item->delete();
                return redirect()
                    ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                    ->withStatus(__('flow_has_been_deleted', ['item' => __($this->title)]));
            } else {
                return redirect()
                    ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                    ->withStatus(__('error', ['error' => 'Error']));
            }
        } else {
            return redirect()
                ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                ->withStatus(__('error', ['error' => 'Error']));
        }
    }

    public function deprecate(Request $request, $id)
    {
        $item = $this->provider::find($id);

        if (!$item) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Flow not found.']);
            }
            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('error', ['error' => 'Flow not found.']));
        }

        try {
            $result = $this->deprecateWhatsAppFlowTemplate($item->unique_flow_id);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()]);
            }
            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('error', ['error' => 'Unexpected error']));
        }

        if ($result['status'] == 200) {
            $item->status = 'DEPRECATED';
            $item->save();

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('flow_has_been_deprecate', ['item' => __($this->title)]));
        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Deprecation failed.']);
            }

            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('error', ['error' => 'Error']));
        }
    }

    public function deprecateWhatsAppFlowTemplate($flowID)
    {
        $company = auth()->user()->resolveCurrentCompany();
        //  $whatsapp_business_account_id = $company->getConfig('whatsapp_business_account_id', '');

        $url = $this->facebookAPI . '/' . $flowID . '/deprecate';
        $accessToken = $company->getConfig('whatsapp_permanent_access_token', '');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);
            return ['status' => $statusCode, 'content' => $content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status' => 500, 'content' => $e->getMessage()];
        }
    }

    public function deleteWhatsAppFlowTemplate($flowID)
    {
        $company = auth()->user()->resolveCurrentCompany();
        $whatsapp_business_account_id = $company->getConfig('whatsapp_business_account_id', '');

        $url = $this->facebookAPI . '/' . $flowID;
        $accessToken = $company->getConfig('whatsapp_permanent_access_token', '');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->delete($url);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);
            return ['status' => $statusCode, 'content' => $content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status' => 500, 'content' => $e->getMessage()];
        }
    }

    public function publishflow($id)
    {
        $flow = $this->provider::find($id);
        if ($flow) {
            $company = auth()->user()->resolveCurrentCompany();
            $accessToken = $company->getConfig('whatsapp_permanent_access_token', '');

            $unique_file_name = $flow->unique_flow_id . '.json';
            $file_disk = Storage::disk('public_file_json_upload');
            $filePath = $file_disk->path($unique_file_name);
            $file_name = $flow->flow_name;

            if ($file_disk->exists($unique_file_name)) {
                try {
                    $result = $this->putWhatsAppFlowTemplateJSON($flow->unique_flow_id, $filePath, $unique_file_name, $file_name, $accessToken);
                } catch (\Exception $e) {
                    //  dd($e);
                }
                if ($result['status'] == 200) {
                    $newResult = $this->publishWhatsAppFlowTemplate($flow->unique_flow_id, $accessToken);
                    if ($newResult['status'] == 200) {
                        $flow->status = 'PUBLISHED';
                        $flow->save();
                        return redirect()
                            ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                            ->withStatus(__('flow_has_been_published', ['item' => __($this->title)]));
                    } else {
                        return redirect()
                            ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                            ->withStatus(__('error', ['error' => 'Error']));
                    }
                } else {
                    return redirect()
                        ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                        ->withStatus(__('error', ['error' => 'Error']));
                }
            } else {
                return redirect()
                    ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                    ->withStatus(__('error', ['error' => 'Error']));
            }
        } else {
            return redirect()
                ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                ->withStatus(__('error', ['error' => 'Error']));
        }
    }

    public function putWhatsAppFlowTemplateJSON($flowID, $filePath, $unique_file_name, $file_name, $accessToken)
    {
        // $formData = [
        //     'file' => 'https://app.dotflo.io/920533760042631.json',
        //     'access_token' => $accessToken,
        //     'name' => 'flow.json',
        //     'asset_type' => 'FLOW_JSON',
        // ];

        try {
            $url = $this->facebookAPI . $flowID . '/assets';
            $response = Http::attach('file', file_get_contents($filePath), $unique_file_name, [
                'Content-Type' => 'application/json',
            ])->post($url, [
                'access_token' => $accessToken,
                'name' => 'flow.json',
                'asset_type' => 'FLOW_JSON',
            ]);
            //dd($response);
            $statusCode = $response->status();
            $content = json_decode($response->body(), true);
            // dd($response['error']);
            return ['status' => $statusCode, 'content' => $content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status' => 500, 'content' => $e->getMessage()];
        }
    }

    public function publishWhatsAppFlowTemplate($flowID, $accessToken)
    {
        try {
            $url = $this->facebookAPI . $flowID . '/publish';
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);
            return ['status' => $statusCode, 'content' => $content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status' => 500, 'content' => $e->getMessage()];
        }
    }

    public function createDataViewLayout($id)
    {
        $flow = $this->provider::find($id);
        $is_notexist = WhatsAppFlowsViewLayout::where('flow_id', $flow->unique_flow_id)->exists();
        if ($flow && $is_notexist == false) {
            if ($flow->download_url) {
                $formJson = $flow->download_url;
                if (filter_var($formJson, FILTER_VALIDATE_URL)) {
                    try {
                        $response = Http::get($formJson);

                        if ($response->ok()) {
                            $formJson = $response->body();
                        } else {
                            return response()->json(['error' => 'Failed to fetch data from URL'], 400);
                        }
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Error fetching URL: ' . $e->getMessage()], 500);
                    }
                }

                $decodedJson = json_decode($formJson, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Invalid JSON data'], 400);
                }

                $labelsJson = [];

                foreach ($decodedJson['screens'] ?? [] as $screen) {
                    foreach ($screen['layout']['children'] ?? [] as $child) {
                        if ($child['type'] === 'Form' && isset($child['children'])) {
                            foreach ($child['children'] as $formChild) {
                                if (isset($formChild['label'], $formChild['name'])) {
                                    $labelsJson[$formChild['name']] = $formChild['label'];
                                }
                            }
                        }
                    }
                }

                $tableColumns = [];
                foreach ($labelsJson as $name => $label) {
                    $tableColumns[] = ['name' => $name, 'label' => $label];
                }

                // dd(response()->json([
                //     'labelsJson' => $labelsJson,
                //     'tableColumns' => $tableColumns
                // ]));
                $company = auth()->user()->resolveCurrentCompany();
                if (!empty($labelsJson)) {
                    WhatsAppFlowsViewLayout::create([
                        'company_id' => $company->id,
                        'flow_id' => $flow->unique_flow_id,
                        'labelsJson' => json_encode($labelsJson),
                        'tableColumns' => json_encode($tableColumns),
                        'phone_number_id' => '',
                    ]);

                    $tableColumn = WhatsAppFlowsViewLayout::where('flow_id', $flow->unique_flow_id)->orderBy('created_at', 'desc')->pluck('tableColumns')->first();
                    $form_data = WhatsAppFlowsSubmittion::where('flow_id', $flow->unique_flow_id)->orderBy('created_at', 'desc')->pluck('form_data')->toArray();

                    $form_data = array_map(fn($data) => json_decode($data, true), $form_data);
                    $tableColumn = json_decode($tableColumn, true);

                    $headers = array_column($tableColumn, 'label');
                    $keys = array_column($tableColumn, 'name');

                    $rows = [];
                    foreach ($form_data as $entry) {
                        $row = [];
                        foreach ($keys as $key) {
                            $value = $entry[$key] ?? 'N/A';

                            if (is_array($value)) {
                                $value = implode(', ', $value);
                            } elseif (is_numeric($value) && strlen($value) === 13) {
                                $value = date('Y-m-d H:i:s', $value / 1000);
                            }

                            $row[] = $value;
                        }
                        $rows[] = $row;
                    }

                    // Pass data to the view
                    return view($this->view_path . 'viewdata', [
                        'setup' => [
                            'action_link' => route($this->webroute_path . 'load'),
                            'action_name' => __('Export data'),
                            'action_icon' => '',
                            'headers' => $headers,
                            'rows' => $rows,
                            'flow_name' => $flow->flow_name,
                            'entity_id' => $flow->entity_id,
                        ],
                    ]);
                } else {
                    return redirect()
                        ->route($this->webroute_path . 'index', ['refresh' => 'yes'])
                        ->withStatus(__('error', ['error' => 'Error']));
                }
            }
        } else {
            $tableColumn = WhatsAppFlowsViewLayout::where('flow_id', $flow->unique_flow_id)->orderBy('created_at', 'desc')->pluck('tableColumns')->first();
            $form_data = WhatsAppFlowsSubmittion::where('flow_id', $flow->unique_flow_id)->orderBy('created_at', 'desc')->pluck('form_data')->toArray();

            $form_data = array_map(fn($data) => json_decode($data, true), $form_data);
            $tableColumn = json_decode($tableColumn, true);

            $headers = array_column($tableColumn, 'label');
            $keys = array_column($tableColumn, 'name');

            $rows = [];
            foreach ($form_data as $entry) {
                $row = [];
                foreach ($keys as $key) {
                    $value = $entry[$key] ?? 'N/A';

                    if (is_array($value)) {
                        $value = implode(', ', $value);
                    } elseif (is_numeric($value) && strlen($value) === 13) {
                        $value = date('Y-m-d H:i:s', $value / 1000);
                    }

                    $row[] = $value;
                }
                $rows[] = $row;
            }

            // Pass data to the view
            return view($this->view_path . 'viewdata', [
                'setup' => [
                    'headers' => $headers,
                    'rows' => $rows,
                    'flow_name' => $flow->flow_name,
                    'entity_id' => $flow->entity_id,
                ],
            ]);
        }
    }

    public function allSubmissions(Request $request)
    {
        $company = auth()->user()->resolveCurrentCompany();
        $query = WhatsAppFlowsSubmittion::with(['flow.viewLayout'])->orderBy('created_at', 'desc');

        $search = $request->input('q');

        if ($search) {
            $query
                ->whereHas('flow', function ($q) use ($search) {
                    $q->where('flow_name', 'like', '%' . $search . '%');
                })
                ->orWhere(function ($q) use ($search) {
                    $q->where('form_data', 'like', '%' . $search . '%');
                });
        }

        $submissions = $query->paginate(10);

        $rows = [];

        foreach ($submissions as $submission) {
            $formData = json_decode($submission->form_data, true) ?? [];

            $labelMap = [];
            if (!empty($submission->flow->viewLayout?->labelsJson)) {
                $labelMap = json_decode($submission->flow->viewLayout->labelsJson, true);
            }

            $formattedData = [];
            foreach ($formData as $key => $value) {
                if ($key !== 'flow_token' && !str_starts_with($key, 'flow_token')) {
                    $label = $labelMap[$key] ?? $key;
                    $formattedData[$label] = $value;
                }
            }

            $rows[] = [
                'flow_name' => $submission->flow->flow_name ?? 'N/A',
                'form_data' => $formattedData,
                'created_at' => $submission->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return view($this->view_path . 'allsubmissions', [
            'setup' => [
                'rows' => new \Illuminate\Pagination\LengthAwarePaginator($rows, $submissions->total(), $submissions->perPage(), $submissions->currentPage(), ['path' => request()->url(), 'query' => request()->query()]),
            ],
        ]);
    }

    public function exportSubmissions(Request $request)
    {
        $query = WhatsAppFlowsSubmittion::with(['flow.viewLayout'])->orderBy('created_at', 'desc');

        $search = $request->input('q');

        if ($search) {
            $query
                ->whereHas('flow', function ($q) use ($search) {
                    $q->where('flow_name', 'like', '%' . $search . '%');
                })
                ->orWhere(function ($q) use ($search) {
                    $q->where('form_data', 'like', '%' . $search . '%');
                });
        }

        $submissions = $query->get();

        $rows = [];

        foreach ($submissions as $submission) {
            $formData = json_decode($submission->form_data, true) ?? [];

            $labelMap = [];
            if (!empty($submission->flow->viewLayout?->labelsJson)) {
                $labelMap = json_decode($submission->flow->viewLayout->labelsJson, true);
            }

            $formattedData = [];
            foreach ($formData as $key => $value) {
                if ($key !== 'flow_token' && !str_starts_with($key, 'flow_token')) {
                    $label = $labelMap[$key] ?? $key;
                    $formattedData[$label] = $value;
                }
            }

            $rows[] = array_merge(
                [
                    'Flow Name' => $submission->flow->flow_name ?? 'N/A',
                    'Submitted At' => $submission->created_at->format('Y-m-d H:i:s'),
                ],
                $formattedData,
            );
        }

        return Excel::download(new FromCollectionExport(new Collection($rows)), 'whatsapp_submissions.xlsx');
    }
}
