<?php

namespace App\Http\Controllers;

use Akaunting\Module\Facade as Module;
use App\Events\WebNotification;
use App\Exports\VendorsExport;
use App\Models\Company;
use App\Models\Partner;
use App\Models\Plans;
use App\Models\User;
use App\Traits\Fields;
use App\Traits\Modules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Models\Config;
use Illuminate\Support\Facades\DB;

class CompaniesController extends Controller
{
    use Fields;
    use Modules;

    private $imagePath = '';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $companies = Company::with('user')->whereHas('user');
            $plans = Plans::pluck('name','id')->toArray();
            $partners = Partner::with('user')->pluck('business_name', 'user_id');

            if (isset($_GET['name']) && strlen($_GET['name']) > 1) {
                $companies = $companies->where('name', 'like', '%' . $_GET['name'] . '%');
            }
            if (isset($_GET['phone']) && strlen($_GET['phone']) > 1) {
                $companies = $companies->where('phone', 'like', '%' . $_GET['phone'] . '%');
            }
            if (isset($_GET['partner_id']) && is_numeric($_GET['partner_id'])) {
                $companies = $companies->whereHas('user', function ($query) {
                    $query->where('created_by', $_GET['partner_id']);
                });
            }
            
            try{
                //Filter by plan, plan is on the user table user.plan_id
                if (isset($_GET['plan']) && $_GET['plan'] != -1) {
                $companies->whereHas('user', function ($query) {
                    $query->where('plan_id', $_GET['plan']);
                });
                }else if(isset($_GET['plan']) && $_GET['plan'] == -1){
                    $companies->whereHas('user', function ($query) {
                        $query->whereNull('plan_id');
                    });
                }
            }catch(\Exception $e){
                //Do nothing
            }

            //With downloaod
            if (isset($_GET['downlodcsv'])) {
                $items = [];
                $vendorsToDownload = $companies->orderBy('id', 'desc')->get();
                $count = 0;
                foreach ($vendorsToDownload as $key => $vendor) {
                    $count++;
                    $item = [
                        'sr.no' => $count,
                        'business_name' => $vendor->name,
                        'created' => $vendor->created_at,
                        'owner_name' => $vendor->user->name,
                        'email' => $vendor->user->email,
                        'phone_number' => $vendor->phone ?? 'N/A',
                    ];
                    array_push($items, $item);
                }

                return Excel::download(new VendorsExport($items), 'vendors_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            
            return view('companies.index', [
                'parameters' => count($_GET) != 0,
                'hasCloner' => Module::has('cloner'),
                'allRes' => $companies->orderBy('id', 'desc')->pluck('name', 'id'),
                'partners' => $partners,
                'plans' => $plans,
                'companies' => $companies->orderBy('id', 'desc')->paginate(10),
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create', [
            'title' => 'Add new company',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Create company via admin dashboard
        $company_name = $request->name;
        $name_owner = $request->name_owner;
        $email_owner = $request->email_owner;
        $phone_owner = $request->phone_owner;

        $user = User::where('email', $email_owner)->first();
        if (!$user) {
            $user = new User();
            $user->name = $name_owner;
            $user->type = 2;
            $user->name_company = $company_name;
            $user->created_by = auth()->user()->id;
            $user->email = $email_owner;
            $user->password = password_hash('secret', PASSWORD_DEFAULT);
            //if free plan setup by admin for users
            if (config('settings.free_pricing_id')) {
                $user->plan_id = config('settings.free_pricing_id');
                $user->plan_status = 'set_by_admin';
            }
            $user->phone = $phone_owner;
            $user->is_otp_verified = 1;

            $user->save();

            $user->assignRole('owner');
            $company = $this->createCompany($user, $company_name);
            
            $user->company_id = $company->id;
            $user->update();

            return redirect()
                ->route('admin.companies.edit', $company->id)
                ->withStatus(__('The company has been successfully created. The default company password is: secret'));
        } else {
            return redirect()->route('admin.companies.create')->withStatus(__('Error: This email address is already registered. Please use a different email address.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    private function createCompany(User $user, $company_name)
    {
        $company = new Company([
            'name' => $company_name ?? $user->name,
            'phone' => $user->phone,
            'is_featured' => 0,
            'subdomain' => strtolower(preg_replace('/[^A-Za-z0-9]/', '', $user->name . Str::random(10))),
            'active' => 1,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $company->save();

        return $company;
    }

    private function verifyAccess($company)
    {
        return auth()->user()->id == $company->user_id || auth()->user()->hasRole('admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($company_id)
    {
        $company = Company::findOrFail($company_id);

        //Languages
        $available_languages = [];
        $default_language = null;

        $companyConfig = Config::where('model_id', $company->id)->pluck('value', 'key');

       // $whatsappToken = $companyConfig['whatsapp_permanent_access_token'] ?? null;

        
        //currency
        if (strlen($company->currency) > 1) {
            $currency = $company->currency;
        } else {
            $currency = config('settings.cashier_currency');
        }

        //App fields
        // $appFields = $this->convertJSONToFields($this->vendorFields($company->getAllConfigs()));
        $appFields = [];

        if ($this->verifyAccess($company)) {
            return view('companies.edit', [
                'hasCloner' =>
                    Module::has('cloner') &&
                    auth()
                        ->user()
                        ->hasRole(['admin', 'manager']),
                'company' => $company,
                'plans' => Plans::get()->pluck('name', 'id'),
                'companyConfig' => $companyConfig,
                'available_languages' => $available_languages,
                'default_language' => $default_language,
                'currency' => $currency,
                'appFields' => $appFields,
            ]);
        }

        return redirect()->route('dashboard')->withStatus(__('No Access'));
    }

    public function editOrganization($company_id)
    {
        $company = Company::findOrFail($company_id);

        //Languages
        $available_languages = [];
        $default_language = null;

        //currency
        if (strlen($company->currency) > 1) {
            $currency = $company->currency;
        } else {
            $currency = config('settings.cashier_currency');
        }

        //App fields
        // $appFields = $this->convertJSONToFields($this->vendorFields($company->getAllConfigs()));
        $appFields = [];

        if ($this->verifyAccess($company)) {
            return view('companies.edit-org', [
                'hasCloner' =>
                    Module::has('cloner') &&
                    auth()
                        ->user()
                        ->hasRole(['admin', 'manager']),
                'company' => $company,
                'plans' => Plans::get()->pluck('name', 'id'),
                'available_languages' => $available_languages,
                'default_language' => $default_language,
                'currency' => $currency,
                'appFields' => $appFields,
            ]);
        }

        return redirect()->route('admin.organizations.manage')->withStatus(__('No Access'));
    }


    public function updateApps(Request $request, Company $company): RedirectResponse
    {
        //Update custom fields
        if ($request->has('custom')) {
            $company->setMultipleConfig($request->custom);
        }

        // return redirect()
        //     ->route('admin.companies.edit', $company->id)
        //     ->withStatus(__('Company successfully updated.'));
        return redirect()
            ->route('admin.companies.edit', $company->id)
            ->withStatus(__('Organization successfully updated.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Company  $company
     */
    public function update(Request $request, $companyid): RedirectResponse
    {
        $this->imagePath = config('app.images_upload_path');

        $company = Company::findOrFail($companyid);
        $company->name = strip_tags($request->name);
        $thereIsCompanyAddressChange = $company->address . '' != $request->address . '';

        $company->address = strip_tags($request->address);
        $company->phone = strip_tags($request->phone);

        // Handle WhatsApp sending speed
        if ($request->has('sending_speed')) {
            switch ($request->sending_speed) {
                case 'enterprise':
                    $company->is_enterprise = 1;
                    $company->is_premium = 0;
                    break;
                case 'premium':
                    $company->is_enterprise = 0;
                    $company->is_premium = 1;
                    break;
                default: // default speed
                    $company->is_enterprise = 0;
                    $company->is_premium = 0;
                    break;
            }
        }


        $company->description = strip_tags($request->description);

        //Update subdomain only if rest is not older than 1 day
        if (Carbon::parse($company->created_at)->diffInDays(Carbon::now()) < 2) {
            $company->subdomain = $this->makeAlias(strip_tags($request->name));
        }

        if (auth()->user()->hasRole('admin')) {
            $company->is_featured = $request->is_featured != null ? 1 : 0;
        }

        if ($request->hasFile('company_logo')) {
            $company->logo = $this->saveImageVersions($this->imagePath, $request->company_logo, [['name' => 'large', 'w' => 590, 'h' => 400], ['name' => 'medium', 'w' => 295, 'h' => 200], ['name' => 'thumbnail', 'w' => 200, 'h' => 200]]);
        }

        if ($request->hasFile('company_cover')) {
            $company->cover = $this->saveImageVersions($this->imagePath, $request->company_cover, [['name' => 'cover', 'w' => 2000, 'h' => 1000], ['name' => 'thumbnail', 'w' => 400, 'h' => 200]]);
        }

        //Change currency
        $company->currency = $request->currency;

        //Change do converstion
        $company->do_covertion = $request->do_covertion == 'true' ? 1 : 0;

        $company->update();

        //Update custom fields
        if ($request->has('custom')) {
            $company->setMultipleConfig($request->custom);
        }

        // return redirect()
        //     ->route('admin.companies.edit', $company->id)
        //     ->withStatus(__('Company successfully updated.'));

        return redirect()
            ->route('admin.companies.edit', $company->id)
            ->withStatus(__('Organization successfully updated.'));
    }

    public function updateOrganization(Request $request, $companyid): RedirectResponse
    {
        $this->imagePath = config('app.images_upload_path');

        $company = Company::findOrFail($companyid);
        $company->name = strip_tags($request->name);
        $thereIsCompanyAddressChange = $company->address . '' != $request->address . '';

        $company->address = strip_tags($request->address);
        $company->phone = strip_tags($request->phone);

        $company->description = strip_tags($request->description);

        //Update subdomain only if rest is not older than 1 day
        if (Carbon::parse($company->created_at)->diffInDays(Carbon::now()) < 2) {
            $company->subdomain = $this->makeAlias(strip_tags($request->name));
        }

        if (auth()->user()->hasRole('admin')) {
            $company->is_featured = $request->is_featured != null ? 1 : 0;
        }

        if ($request->hasFile('company_logo')) {
            $company->logo = $this->saveImageVersions($this->imagePath, $request->company_logo, [['name' => 'large', 'w' => 590, 'h' => 400], ['name' => 'medium', 'w' => 295, 'h' => 200], ['name' => 'thumbnail', 'w' => 200, 'h' => 200]]);
        }

        if ($request->hasFile('company_cover')) {
            $company->cover = $this->saveImageVersions($this->imagePath, $request->company_cover, [['name' => 'cover', 'w' => 2000, 'h' => 1000], ['name' => 'thumbnail', 'w' => 400, 'h' => 200]]);
        }

        //Change currency
        $company->currency = $request->currency;

        //Change do converstion
        $company->do_covertion = $request->do_covertion == 'true' ? 1 : 0;

        $company->update();

        //Update custom fields
        if ($request->has('custom')) {
            $company->setMultipleConfig($request->custom);
        }

        // return redirect()
        //     ->route('admin.companies.edit', $company->id)
        //     ->withStatus(__('Company successfully updated.'));

        return redirect()
            ->route('admin.organizations.edit', $company->id)
            ->withStatus(__('Organization successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($companyid): RedirectResponse
    {
        $company = Company::findOrFail($companyid);
        if (! auth()->user()->hasRole('admin') && auth()->user()->id != $company->user_id) {
            abort(403);
        }

        $company->active = 0;
        $company->save();

        // return redirect()->route('admin.companies.index')->withStatus(__('Company successfully deactivated.'));
        return redirect()->route('admin.companies.index')->withStatus(__('Organization successfully deactivated.'));
    }

    public function remove($companyid): RedirectResponse
    {
        if (config('settings.is_demo')) {
            return redirect()->route('admin.companies.index')->withStatus(__('Disabled in demo'));
        }
        $company = Company::findOrFail($companyid);
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $company->delete();

        // return redirect()->route('admin.companies.index')->withStatus(__('Company successfully deleted.'));
        return redirect()->route('admin.companies.index')->withStatus(__('Organization successfully deleted.'));
    }

    private function makeCompanyActive(Company $company)
    {
        //Activate the company
        $company->active = 1;
        $company->subdomain = $this->makeAlias($company->name);
        $company->update();
    }

    public function activateCompany($companyid): RedirectResponse
    {
        $company = Company::findOrFail($companyid);
        $this->makeCompanyActive($company);

        // return redirect()->route('admin.companies.index')->withStatus(__('Company successfully activated.'));
        return redirect()->route('admin.companies.index')->withStatus(__('Organization successfully activated.'));
    }

    public function stopImpersonate(): RedirectResponse
    {
        Auth::user()->stopImpersonating();

        Session::forget('company_id');
        Session::forget('company_currency');
        Session::forget('company_convertion');

        return redirect()->route('home');
    }

    public function loginas($companyid): RedirectResponse
    {
        $company = Company::findOrFail($companyid);
        if (config('settings.is_demo', false)) {
            return redirect()->back()->withStatus('Not allowed in demo');
        }
        if ($this->verifyAccess($company)) {
            //Login as owner
            Session::put('impersonate', $company->user->id);

            //Set the company
            session(['company_id' => $company->id]);
            session(['company_currency' => $company->currency]);
            session(['company_convertion' => $company->do_covertion]);

            return redirect()->route('home');
        } else {
            abort(403);
        }
    }


    //Switch company
    public function switch($companyid): RedirectResponse
    {
        $company = Company::findOrFail($companyid);
        if ($this->verifyAccess($company)) {
            //Set the company
            session(['company_id' => $company->id]);
            session(['company_currency' => $company->currency]);
            session(['company_convertion' => $company->do_covertion]);

            return redirect()->route('home');
        } else {
            abort(403);
        }
    }

    public function manage(): View
    {
        return view('companies.manage');
    }

    public function createOrganization(Request $request): RedirectResponse
    {
        $company = Company::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
            'subdomain' => strtolower(preg_replace('/[^A-Za-z0-9]/', '', $request->name)),
            'created_at' => now(),
            'updated_at' => now(),
            'logo'=>asset('uploads').'/default/no_image.jpg',
        ]);

        return redirect()->route('admin.organizations.manage')->withStatus(__('Organization successfully created.'));
    }

    public function notify($type, $companyid, $message): JsonResponse
    {
        $company = Company::findOrFail($companyid);
        $CAN_USE_PUSHER = strlen(config('broadcasting.connections.pusher.app_id')) > 2 && strlen(config('broadcasting.connections.pusher.key')) > 2 && strlen(config('broadcasting.connections.pusher.secret')) > 2;
        $messageSend = false;
        $responseMessage = '';
        //Check if company has this notification enabled
        if ($company->getConfig('enable_notification_' . $type, true) && $CAN_USE_PUSHER) {
            event(new WebNotification($company, $message, $type));
            $responseMessage = $message;
            $messageSend = true;
        } else {
            $responseMessage = __('Notification not enabled');
            $messageSend = false;
        }

        //Respond in json
        return response()->json([
            'message' => $responseMessage,
            'messageSend' => $messageSend,
        ]);
    }

    public function share(): View
    {
        $url = auth()->user()->company->getLinkAttribute();

        return view('companies.share', ['url' => $url, 'name' => auth()->user()->company->name]);
    }

    public function removeNoUseData($company_id)
    {
        try {
            if (!$company_id) {
                return response()->json(["message" => "Invalid company ID"], 400);
            }

            DB::beginTransaction(); 

            DB::statement("DELETE gc FROM groups_contacts gc JOIN contacts c ON c.id = gc.contact_id WHERE c.company_id = ? AND c.deleted_at IS NOT NULL", [$company_id]);

            DB::statement("DELETE m FROM messages m JOIN contacts c ON c.id = m.contact_id WHERE c.company_id = ? AND c.deleted_at IS NOT NULL", [$company_id]);

            DB::statement("DELETE wac FROM wa_campaings wac JOIN contacts c ON c.id = wac.contact_id WHERE c.company_id = ? AND c.deleted_at IS NOT NULL", [$company_id]);

            DB::statement("DELETE cfc FROM custom_contacts_fields_contacts cfc JOIN contacts c ON c.id = cfc.contact_id WHERE c.company_id = ? AND c.deleted_at IS NOT NULL", [$company_id]);

            DB::statement("DELETE FROM contacts WHERE company_id = ? AND deleted_at IS NOT NULL", [$company_id]);

            DB::commit(); 

            return response()->json(["message" => "Unused data removed successfully!"]);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(["message" => "Error: " . $e->getMessage()], 500);
        }
    }
}
