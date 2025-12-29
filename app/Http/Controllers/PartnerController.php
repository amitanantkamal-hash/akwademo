<?php

namespace App\Http\Controllers;

use Akaunting\Module\Laravel\Module;
use App\Models\Company;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\VendorsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::with('user')->get();
        return view('partners.index', compact('partners'));
    }

    public function partnerDashboard()
    {
        if (Partner::where('user_id', auth()->user()->id)->value('is_active') == 1) {
            $user_id = auth()->user()->id;
            $partnerType = auth()->user()->type;
            if ($partnerType == 3) {
                $partner = Partner::where('user_id', $user_id)->get();

                $user_id = auth()->user()->id; // Get the authenticated user's ID
                $companies = Company::with('user')->whereHas('user', function ($query) use ($user_id) {
                    $query->where('created_by', $user_id);
                });

                // Apply additional filters from $_GET if present
                if (isset($_GET['name']) && strlen($_GET['name']) > 1) {
                    $companies = $companies->where('name', 'like', '%' . $_GET['name'] . '%');
                }
                if (isset($_GET['phone']) && strlen($_GET['phone']) > 1) {
                    $companies = $companies->where('phone', 'like', '%' . $_GET['phone'] . '%');
                }

                if (isset($_GET['downlodcsv'])) {
                    $items = [];
                    $vendorsToDownload = $companies->orderBy('id', 'desc')->get();
                    $count = 0;
                    foreach ($vendorsToDownload as $key => $vendor) {
                        $count++;
                        $item = [
                            'sr.no  ' => $count,
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
                // Return to the partners dashboard view with companies data
                return view('partners.dashboard', [
                    'partner' => auth()->user(), // Pass the authenticated user as partner
                    'companies' => $companies->orderBy('id', 'desc')->paginate(10), // Pass the filtered companies
                    'parameters' => count($_GET) != 0,
                    'allRes' => $companies->orderBy('id', 'desc')->pluck('name', 'id'),
                ]);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function addCompany()
    {
        if (
            Partner::where('user_id', auth()->user()->id)
                ->where('is_active', 1)
                ->where('allowed_customer_creation', 1)
                ->exists()
        ) {
            $partnerType = auth()->user()->type;
            if ($partnerType == 3) {
                return view('partners.add-company', [
                    'title' => 'Add new company',
                ]);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('partner.dashboard');
        }
    }

    public function storeCompany(Request $request)
    {
        //Create company via partner dashboard
        $company_name = $request->name;
        $name_owner = $request->name_owner;
        $email_owner = $request->email_owner;
        $phone_owner = $request->phone;

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

            $user->save();

            $user->assignRole('owner');
            $company = $this->createCompany($user, $company_name);

            return redirect()
                ->route('partner.dashboard', $company->id)
                ->withStatus(__('The company has been successfully created. The default company password is: secret'));
        } else {
            return redirect()->route('partner.add.company')->withStatus(__('Error: This email address is already registered. Please use a different email address.'));
        }
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

    public function create()
    {
        $users = User::all();
        return view('partners.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:partners,phone',
            'email' => 'required|email|unique:partners,email',
            'business_name' => 'required|string|max:255',
            'gst_number' => 'required|string|max:15',
            'pan_number' => 'nullable|string|max:10',
            'billing_address' => 'required|string',
            'allowed_customer_creation' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/partners/'), $filename);
            $validated['logo'] = 'uploads/partners/' . $filename;
        }

       // dd($validated);

        $partner = Partner::create($validated);

        $userId = $partner->user_id;
        if ($userId) {
            $user = User::find($userId);
            $user->type = 3;
            $user->update();
        }

        return redirect()->route('partners.index')->with('success', 'Partner created successfully.');
    }

    public function fetchUserInfo($userId)
    {
        $user = User::find($userId);
        return response()->json([
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);
    }

    public function edit(Partner $partner)
    {
        $users = User::all();
        return view('partners.edit', compact('partner', 'users'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:partners,phone,' . $partner->id,
            'email' => 'required|email|unique:partners,email,' . $partner->id,
            'business_name' => 'required|string|max:255',
            'gst_number' => 'required|string|max:15',
            'pan_number' => 'nullable|string|max:10',
            'billing_address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $partner->allowed_customer_creation = $request->allowed_customer_creation;
        $partner->is_active = $request->is_active;

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($partner->logo && file_exists(public_path($partner->logo))) {
                unlink(public_path($partner->logo));
            }
    
            // Upload new logo
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/partners/'), $filename);
            $validated['logo'] = 'uploads/partners/' . $filename;

            $partner->logo = 'uploads/partners/' . $filename;
        }

        $partner->update($validated);

        // $userId = $partner->user_id;
        // if ($userId) {
        //     $user = User::find($userId);
        //     $user->type = 3;
        //     $user->update();
        // }

        return redirect()->route('partners.index')->with('success', 'Partner updated successfully.');
    }

    public function toggleStatus(Partner $partner)
    {
        $partner->is_active = !$partner->is_active;
        $partner->save();

        return redirect()->route('partners.index')->with('success', 'Partner status updated successfully.');
    }
}
