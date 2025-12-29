<?php

namespace Modules\Agents\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

class Main extends Controller
{
    private const WEBROUTE_PATH = 'agent.';
    private const VIEW_PATH = 'agents::';
    private const PARAMETER_NAME = 'agent';
    private const TITLE = 'agent';
    private const TITLE_PLURAL = 'agents';

    private User $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
        $this->middleware(function ($request, $next) {
            $this->authorizeOwner();
            return $next($request);
        })->except(['stopImpersonate']);
    }

    /**
     * Authorization checker for owner role
     */
    private function authorizeOwner(): void
    {
        if (!auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Get form fields configuration
     */
    private function getFields(bool $includePassword = true): array
    {
        $fields = [
            [
                'class' => 'col-md-4',
                'ftype' => 'input',
                'name' => 'Name',
                'id' => 'name',
                'placeholder' => 'First and Last name',
                'required' => true
            ],
            [
                'class' => 'col-md-4',
                'ftype' => 'input',
                'name' => 'Email',
                'id' => 'email',
                'placeholder' => 'Enter email',
                'required' => true,
                'type' => 'email'
            ],
        ];

        if ($includePassword) {
            $fields[] = [
                'class' => 'col-md-4',
                'ftype' => 'input',
                'type' => 'password',
                'name' => 'Password',
                'id' => 'password',
                'placeholder' => 'Enter password',
                'required' => true
            ];
        }

        return $fields;
    }

    /**
     * Validate agent creation request
     */
    private function validateAgentRequest(Request $request, ?int $agentId = null): array
    {
        $rules = [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'mobile' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'password' => 'required|min:6|confirmed', // Default rule for creation
        ];

        if ($agentId) {
            // For updates, ignore current agent's email and make password optional
            $rules['email'] .= ',' . $agentId;
            $rules['password'] = 'nullable|min:6|confirmed'; // Password optional for updates
        }

        return $request->validate($rules, [
            'name.required' => __('The agent name is required.'),
            'name.min' => __('The agent name must be at least 2 characters.'),
            'email.required' => __('The email address is required.'),
            'email.email' => __('Please enter a valid email address.'),
            'email.unique' => __('This email address is already registered.'),
            'password.required' => __('The password is required.'),
            'password.min' => __('The password must be at least 6 characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'mobile.regex' => __('Please enter a valid mobile number.'),
        ]);
    }

    /**
     * Check if WhatsApp setup is completed
     */
    private function isWhatsAppSetupCompleted()
    {
        return $this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') === 'yes'
            && $this->getCompany()->getConfig('whatsapp_settings_done', 'no') === 'yes';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->isWhatsAppSetupCompleted()) {
            return redirect(route('whatsapp.setup'));
        }

        $setup = [
            'title' => __('crud.item_managment', ['item' => __(self::TITLE_PLURAL)]),
            'action_link' => route(self::WEBROUTE_PATH . 'create'),
            'action_name' => __('crud.add_new_item', ['item' => __(self::TITLE)]),
            'action_icon' => '',
            'items' => $this->getCompany()->staff()->paginate(config('settings.paginate', 15)),
            'item_names' => self::TITLE_PLURAL,
            'webroute_path' => self::WEBROUTE_PATH,
            'fields' => $this->getFields(false),
            'parameter_name' => self::PARAMETER_NAME,
        ];

        return view(self::VIEW_PATH . 'index', compact('setup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorizeOwner();

        $recentAgents = $this->userModel::where('company_id', $this->getCompany()->id)
            ->where('id', '!=', auth()->id()) // Exclude current user
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('agents::create', [
            'setup' => [
                'title' => __('crud.new_item', ['item' => __(self::TITLE)]),
                'action_link' => route(self::WEBROUTE_PATH . 'index'),
                'action_name' => __('crud.back'),
                'action_icon' => '',
                'webroute_path' => self::WEBROUTE_PATH,
            ],
            'recentAgents' => $recentAgents,
            'title' => 'New Agent'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $validatedData = $this->validateAgentRequest($request);

    //     if ($this->userModel->where('email', $validatedData['email'])->exists()) {
    //         return redirect()
    //             ->route(self::WEBROUTE_PATH . 'index')
    //             ->withErrors(['email' => 'This email address is already registered. Please use a different email address.']);
    //     }

    //     $agent = $this->userModel->create([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'password' => Hash::make($validatedData['password']),
    //         'phone'=> $validatedData['phone'],
    //         'is_otp_verified' => 1,
    //         'api_token' => Str::random(80),
    //         'company_id' => $this->getCompany()->id,
    //     ]);

    //     $agent->assignRole('staff');

    //     return redirect()
    //         ->route(self::WEBROUTE_PATH . 'index')
    //         ->withStatus(__('crud.item_has_been_added', ['item' => __(self::TITLE)]));
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeOwner();

        try {
            // Validate the request data
            $validatedData = $this->validateAgentRequest($request);
            // Check if email already exists
            $existingUser = $this->userModel->where('email', $validatedData['email'])->first();
            if ($existingUser) {
                return redirect()
                    ->route(self::WEBROUTE_PATH . 'create')
                    ->withInput()
                    ->withErrors([
                        'email' => __('This email address is already registered. Please use a different email address.')
                    ]);
            }

            // Create the agent
            $agentData = [
                'name' => strip_tags($validatedData['name']), // Sanitize name
                'email' => strtolower(trim($validatedData['email'])), // Normalize email
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['mobile'], // Using 'phone' field for mobile
                'is_otp_verified' => 1,
                'api_token' => Str::random(80),
                'company_id' => $this->getCompany()->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ];

            $agent = $this->userModel->create($agentData);

            // Assign staff role
            $agent->assignRole('staff');

            // Optional: Send welcome email to agent
            $this->sendWelcomeEmail($agent, $validatedData['password']);

            // Log the creation activity
            // activity()
            //     ->causedBy(auth()->user())
            //     ->performedOn($agent)
            //     ->withProperties([
            //         'email' => $agent->email,
            //         'name' => $agent->name
            //     ])
            //     ->log('created agent');

            return redirect()
                ->route(self::WEBROUTE_PATH . 'index')
                ->with([
                    'status' => __('Agent :name has been successfully created.', ['name' => $agent->name]),
                    'alert-type' => 'success',
                    'created_agent_id' => $agent->id
                ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // Let Laravel handle validation exceptions
        } catch (\Exception $e) {
            \Log::error('Agent creation failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'email' => $request->email,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route(self::WEBROUTE_PATH . 'create')
                ->withInput()
                ->withErrors([
                    'general' => __('An error occurred while creating the agent. Please try again.')
                ]);
        }
    }

    /**
     * Send welcome email to new agent
     */
    /**
     * Send welcome email to new agent
     */
    private function sendWelcomeEmail(User $agent, string $plainPassword): void
    {
        try {
            // Check if email configuration is set up
            if (empty(config('mail.default'))) {
                \Log::warning('Email configuration not set up. Welcome email not sent to: ' . $agent->email);
                return;
            }

            // Send welcome email
            Mail::to($agent->email)
                ->send(new AgentWelcomeMail($agent, $plainPassword));

            \Log::info('Welcome email sent successfully to: ' . $agent->email, [
                'agent_id' => $agent->id,
                'agent_name' => $agent->name
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome email to ' . $agent->email . ': ' . $e->getMessage(), [
                'agent_id' => $agent->id,
                'exception' => $e
            ]);

            // You might want to notify admin about email failure
            // $this->notifyAdminAboutEmailFailure($agent, $e->getMessage());
        }
    }

    /**
     * Notify admin about email delivery failure
     */
    private function notifyAdminAboutEmailFailure(User $agent, string $errorMessage): void
    {
        try {
            // Get admin users or the company owner
            $adminUsers = User::whereHas('roles', function ($query) {
                $query->where('name', 'owner');
            })->where('company_id', $agent->company_id)->get();

            foreach ($adminUsers as $admin) {
                // Send notification to admin about the email failure
                \Log::warning('Failed to send welcome email to agent. Admin notified: ' . $admin->email, [
                    'agent_id' => $agent->id,
                    'admin_id' => $admin->id,
                    'error' => $errorMessage
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to notify admin about email failure: ' . $e->getMessage());
        }
    }

    /**
     * Login as agent (impersonate)
     */
    public function loginas(int $id): RedirectResponse
    {
        if (config('settings.is_demo', false)) {
            return redirect()->back()->withStatus('Not allowed in demo');
        }

        try {
            $agent = $this->userModel->findOrFail($id);

            if ($agent->company->user->id !== auth()->user()->id) {
                abort(403, 'Unauthorized action.');
            }

            $this->startImpersonation($agent);

            return redirect(route('home'));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Agent not found.');
        }
    }

    /**
     * Start impersonation session
     */
    private function startImpersonation(User $agent): void
    {
        Session::put('owner_id', auth()->user()->id);
        Session::put('company_id', $agent->company->id);
        Session::put('impersonate', $agent->id);

        Auth::login($agent, true);
    }

    /**
     * Stop impersonation
     */
    public function stopImpersonate(): RedirectResponse
    {
        $ownerId = Session::get('owner_id');

        if ($ownerId) {
            $owner = $this->userModel->find($ownerId);
            if ($owner) {
                Auth::login($owner, true);
            }
        }

        $this->clearImpersonationSession();

        return redirect(route('home'));
    }

    /**
     * Clear impersonation session data
     */
    private function clearImpersonationSession(): void
    {
        Session::forget(['impersonate', 'company_id', 'owner_id']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorizeOwner();

        try {
            $agent = $this->userModel->findOrFail($id);

            // Verify agent belongs to current company
            if ($this->getCompany()->id !== $agent->company_id) {
                abort(403, 'Unauthorized action.');
            }

            // Get recent agents for sidebar
            $recentAgents = $this->userModel::where('company_id', $this->getCompany()->id)
                ->where('id', '!=', $id) // Exclude current agent
                ->where('id', '!=', auth()->id()) // Exclude current user
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('agents::edit', [
                'agent' => $agent,
                'recentAgents' => $recentAgents,
                'setup' => [
                    'title' => __('Edit Agent'),
                    'action_link' => route(self::WEBROUTE_PATH . 'index'),
                    'action_name' => __('Back to Agents'),
                    'webroute_path' => self::WEBROUTE_PATH,
                    'parameter_name' => self::PARAMETER_NAME,
                ],
                'title' => __('Edit Agent') . ' - ' . $agent->name
            ]);
        } catch (ModelNotFoundException $e) {
            abort(404, 'Agent not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->authorizeOwner();

        try {
            $agent = $this->userModel->findOrFail($id);

            // Verify agent belongs to current company
            if ($this->getCompany()->id !== $agent->company_id) {
                abort(403, 'Unauthorized action.');
            }

            // Validate the request data
            $validatedData = $this->validateAgentRequest($request, $id);

            // Prepare update data
            $updateData = [
                'name' => strip_tags($validatedData['name']),
                'email' => strtolower(trim($validatedData['email'])),
                'phone' => isset($validatedData['mobile']) && !empty(trim($validatedData['mobile']))
                    ? $this->formatMobileNumber($validatedData['mobile'])
                    : null,
            ];

            // Handle is_active status
            if ($request->has('is_active')) {
                $updateData['is_active'] = $request->boolean('is_active');
                $updateData['deactivated_at'] = $request->boolean('is_active') ? null : now();
            }

            // Only update password if provided
            if (!empty($validatedData['password'])) {
                $updateData['password'] = Hash::make($validatedData['password']);

                // Log password change for security
                // /Log::info('Agent password updated', [
                //     'agent_id' => $agent->id,
                //     'updated_by' => auth()->id(),
                //     'updated_at' => now()
                // ]);
            }

            // Update the agent
            $agent->update($updateData);

            // Log the update activity
            // activity()
            //     ->causedBy(auth()->user())
            //     ->performedOn($agent)
            //     ->withProperties([
            //         'changes' => $updateData,
            //         'old_email' => $agent->getOriginal('email'),
            //         'old_status' => $agent->getOriginal('is_active')
            //     ])
            //     ->log('updated agent');

            return redirect()
                ->route(self::WEBROUTE_PATH . 'index')
                ->with([
                    'status' => __('Agent :name has been successfully updated.', ['name' => $agent->name]),
                    'alert-type' => 'success',
                    'updated_agent_id' => $agent->id
                ]);
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route(self::WEBROUTE_PATH . 'index')
                ->withErrors(['error' => __('Agent not found.')]);
        } catch (\Exception $e) {
            \Log::error('Agent update failed: ' . $e->getMessage(), [
                'agent_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => __('An error occurred while updating the agent. Please try again.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $agent = $this->userModel->findOrFail($id);
            $agent->delete();

            return redirect()
                ->route(self::WEBROUTE_PATH . 'index')
                ->withStatus(__('crud.item_has_been_removed', ['item' => __(self::TITLE)]));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Agent not found.');
        }
    }

    /**
     * Update agent status (active/inactive)
     */
    public function updateStatus(Request $request, $agentId)
    {
        $this->authorizeOwner();

        try {
            \Log::debug('Update status request received', [
                'agent_id' => $agentId,
                'is_active' => $request->is_active,
                'all_data' => $request->all()
            ]);

            $agent = $this->userModel->findOrFail($agentId);

            // Verify agent belongs to current company
            if ($agent->company_id !== $this->getCompany()->id) {
                return response()->json([
                    'success' => false,
                    'message' => __('Unauthorized action.')
                ], 403);
            }

            $request->validate([
                'is_active' => 'required|boolean'
            ]);

            // Update agent status
            $agent->update([
                'is_active' => $request->is_active,
                'deactivated_at' => $request->is_active ? null : now()
            ]);

            // Log the status change

            return response()->json([
                'success' => true,
                'message' => __('Agent status updated successfully.'),
                'is_active' => $agent->is_active
            ]);
        } catch (ModelNotFoundException $e) {
            \Log::error('Agent not found', ['agent_id' => $agentId]);

            return response()->json([
                'success' => false,
                'message' => __('Agent not found.')
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Agent status update failed: ' . $e->getMessage(), [
                'agent_id' => $agentId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to update agent status. Please try again.')
            ], 500);
        }
    }

    /**
     * Get agent statistics for dashboard
     */
    public function getAgentStats(): array
    {
        $companyId = $this->getCompany()->id;

        return [
            'total_agents' => User::where('company_id', $companyId)->count(),
            'active_agents' => User::where('company_id', $companyId)->active()->count(),
            'inactive_agents' => User::where('company_id', $companyId)->inactive()->count(),
            'recently_active' => User::where('company_id', $companyId)->recentlyActive(7)->count(),
            'new_this_month' => User::where('company_id', $companyId)
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
        ];
    }
    /**
     * Format mobile number before saving
     */
    private function formatMobileNumber(?string $mobile): ?string
    {
        if (empty($mobile)) {
            return null;
        }

        // Remove all non-digit characters except plus sign
        $formatted = preg_replace('/[^\d+]/', '', $mobile);

        // If it starts with 00, replace with +
        if (str_starts_with($formatted, '00')) {
            $formatted = '+' . substr($formatted, 2);
        }

        // Ensure it starts with + if it's an international number
        if (!empty($formatted) && !str_starts_with($formatted, '+') && strlen($formatted) > 10) {
            $formatted = '+' . $formatted;
        }

        return $formatted ?: null;
    }
}
