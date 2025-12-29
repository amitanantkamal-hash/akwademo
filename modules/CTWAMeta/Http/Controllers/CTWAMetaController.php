<?php

namespace Modules\CTWAMeta\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CTWAMeta\Models\FacebookAppConnection;
use Modules\CTWAMeta\Models\MetaAccount;
use Modules\CTWAMeta\Services\MetaApiService;
use Modules\CTWAMeta\Models\MetaBusinessAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\CTWAMeta\Models\CTWAAnalytics;
use Modules\CTWAMeta\Models\FacebookForm;
use Modules\CTWAMeta\Models\MetaLeads;
use Modules\CTWAMeta\Models\MetaPage;

class CTWAMetaController extends Controller
{
    protected $metaService;

    public function __construct(MetaApiService $metaService)
    {
        $this->metaService = $metaService;
    }

    /**
     * Display the main dashboard with connected accounts
     */
    public function index()
    {
        $user = auth()->user();
        $buisnessId = null;
        if (!$user) {
            return redirect()->route('login')->withErrors('Please log in first.');
        }
        // Get the connection with its relationships
        $company = $user->getCurrentCompany();

        $connection = FacebookAppConnection::with([
            'metaBusinessAccounts',
            'metaAccounts',
            'company',   // only if this is a relationship
        ])
            ->where('company_id', $company->id)
            ->first();


        // Initialize variables
        $businessAccounts = [];
        $allAccounts = collect();
        $pages = collect(); // Initialize pages as an empty collection

        if ($connection) {
            // Get business accounts - first try from relationship, then from JSON data
            $businessAccounts = $connection->metaBusinessAccounts->toArray();

            if (empty($businessAccounts)) {
                $businessAccounts = json_decode($connection->business_data, true) ?? [];
            }

            // Get all accounts with their business relationship
            $allAccounts = MetaAccount::with('metaBusinessAccount')
                ->where('company_id', $company->id)
                ->get();

            $pages = MetaPage::with('businessAccount')
                ->where('company_id', $company->id)
                ->get();

            
            $businesses = json_decode($connection['ad_accounts']);
            foreach ($businesses as $buisness) {
                if (isset($buisness->business->id)) {
                    $buisnessId = $buisness->business->id;
                }
            }
        }
        

        return view('c-t-w-a-meta::accounts', [
            'connection' => $connection,
            'metaAccounts' => $allAccounts,
            'pages' => $pages,
            'businessAccounts' => $businessAccounts,
            'buisnessId' => $buisnessId,
        ]);
    }

    /**
     * Initiate Facebook OAuth connection
     */
    public function connect()
    {
        try {
            $state = bin2hex(random_bytes(32));

            // Force session write immediately
            session([
                'fb_oauth_state' => $state,
                'fb_oauth_state_time' => now()->timestamp,
            ]);
            session()->save(); // Immediate save

            $loginUrl = $this->metaService->getLoginUrl(route('ctwameta.callback'), $state);

            return redirect()->away($loginUrl);
        } catch (\Exception $e) {
            // Error handling
        }
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function callback(Request $request)
    {
        // 1. Verify state parameter exists in request
        if (!$request->has('state')) {
            \Log::error('State parameter missing in callback', [
                'request_params' => $request->all(),
                'session_state' => session('fb_oauth_state'),
            ]);
            return redirect()->route('ctwameta.index')->with('error', 'Authentication failed: Missing state parameter');
        }

        // 2. Get session state safely
        $sessionState = session('fb_oauth_state', ''); // Default to empty string if null

        // 3. Verify state matches session
        if (empty($sessionState) || !hash_equals($sessionState, $request->state)) {
            \Log::error('State parameter validation failed', [
                'expected' => $sessionState,
                'received' => $request->state,
                'session_exists' => session()->has('fb_oauth_state'),
                'session_id' => session()->getId(),
            ]);
            return redirect()->route('ctwameta.index')->with('error', 'Authentication failed: Invalid state parameter');
        }

        try {
            // 4. Exchange code for access token
            // Exchange code for access token
            $accessToken = $this->metaService->getAccessTokenFromCode($request->code, route('ctwameta.callback'));

            // Get long-lived token
            $longLivedToken = $this->metaService->getLongLivedToken($accessToken);

            // 6. Get basic user info
            $fbUser = $this->metaService->getUserInfo($longLivedToken);
            $fbUserId = $fbUser['id'];

            // 7. Get business accounts
            $businessAccounts = $this->metaService->getBusinessAccounts($longLivedToken);

            if (empty($businessAccounts)) {
                throw new \Exception('No business accounts found. Please check permissions.');
            }

            $companyId = auth()->user()->getCurrentCompany()->id;
            if (!$companyId) {
                throw new \Exception('No company associated with user');
            }

            // 8. First create/update the connection to get an ID
            $connection = FacebookAppConnection::updateOrCreate(
                ['company_id' => $companyId],
                [
                    'fb_user_id' => $fbUserId,
                    'access_token' => (string) $accessToken,
                    'long_lived_token' => (string) $longLivedToken,
                    'token_expires_at' => now()->addDays(60),
                ],
            );
            // // Generate webhook details once
            $webhookSecret = bin2hex(random_bytes(12));
            $connection->update([
                'webhook_secret' => $webhookSecret,
                'webhook_url' => route('ctwameta.webhooks.lead'), // No company ID in URL
            ]);

            // 9. Save business accounts with the connection ID
            foreach ($businessAccounts as $business) {
                MetaBusinessAccount::updateOrCreate(
                    [
                        'business_id' => $business['id'],
                        'company_id' => $companyId,
                    ],
                    [
                        'fb_connection_id' => $connection->id,
                        'name' => $business['name'],
                        'vertical' => $business['vertical'],
                        'primary_page_id' => isset($business['primary_page']['id']) ? $business['primary_page']['id'] : null,
                        'business_profile' => isset($business['primary_page']['name']) ? $business['primary_page']['name'] : null,
                        'link' => $business['link'],
                        'picture_url' => $business['picture']['data']['url'] ?? null,
                    ],
                );

                // Get and save pages for this business
                $pages = $this->metaService->getPages($business['id'], $longLivedToken);
                foreach ($pages as $page) {
                    MetaPage::updateOrCreate(
                        ['page_id' => $page['id']],
                        [
                            'company_id' => $companyId,
                            'fb_connection_id' => $connection->id,
                            'business_id' => $business['id'],
                            'name' => $page['name'],
                            'category' => $page['category'] ?? null,
                            'access_token' => $page['access_token'],
                            'picture_url' => $page['picture']['data']['url'] ?? null,
                            'tasks' => isset($page['tasks']) ? json_encode($page['tasks']) : null,
                            'page_permissions' => isset($page['page_permissions']) ? json_encode($page['page_permissions']) : null,
                        ],
                    );
                }

                // 10. Get and save ad accounts for this business
                $accounts = $this->metaService->getAdAccounts($business['id'], $accessToken);
                foreach ($accounts as $account) {
                    MetaAccount::updateOrCreate(
                        ['account_id' => $account['id']],
                        [
                            'company_id' => $companyId,
                            'name' => $account['name'],
                            'type' => $this->determineAccountType($account),
                            'access_token' => (string) $longLivedToken,
                            'fb_connection_id' => $connection->id,
                            'status' => $account['account_status'],
                            'amount_spent' => $account['amount_spent'] ?? 0,
                            'business_id' => $account['owner'],
                        ],
                    );
                }
                // Update connection with all accounts data
                $connection->update([
                    'business_data' => json_encode($businessAccounts),
                    'ad_accounts' => json_encode($this->metaService->getAdAccounts($business['id'], $longLivedToken)),
                ]);
            }

            return redirect()->route('ctwameta.index')->with('success', 'Successfully connected to Meta!')->with('businessAccounts', $businessAccounts)->with('adAccounts', $adAccounts);
        } catch (\Exception $e) {
            \Log::error('Callback processing failed', [
                'error' => $e->getMessage(),
                'state' => $request->state,
                'session_state' => session('fb_oauth_state'),
                'trace' => $e->getTraceAsString(),
            ]);

            $errorMessage = 'Connection failed: ';
            if (str_contains($e->getMessage(), 'access token')) {
                $errorMessage .= 'Authentication error. Please try reconnecting.';
            } else {
                $errorMessage .= $e->getMessage();
            }

            return redirect()->route('ctwameta.index')->with('error', $errorMessage);
        } finally {
            // Always clear the state parameter
            session()->forget('fb_oauth_state');
        }
    }

    protected function determineAccountType($account)
    {
        // Check for CTWA (Click-to-WhatsApp) specific fields
        return !empty($account['is_prepay_account']) && $account['is_prepay_account'] ? 'ctwa' : 'non_ctwa';
    }

    /**
     * Refresh connected accounts
     */
    public function refreshAccounts()
    {
        try {
            $company = auth()->user()->getCurrentCompany();
            if (!$company) {
                throw new \Exception('No company associated with user');
            }

            $connection = FacebookAppConnection::where('company_id', $company->id)->firstOrFail();
            // Get fresh data using existing token
            $businessAccounts = $this->metaService->getBusinessAccounts($connection->access_token);
            $adAccounts = [];
            foreach ($businessAccounts as $business) {
                $adAccounts[$business['id']] = $this->metaService->getAdAccounts($business['id'], $connection->access_token);
            }

            // Update connection data
            $connection->update([
                // 'business_data' => json_encode($businessAccounts),
                'ad_accounts' => json_encode($adAccounts),
                'updated_at' => now(),
            ]);

            // Update individual ad accounts
            foreach ($adAccounts as $businessId => $accounts) {
                foreach ($accounts as $account) {
                    MetaAccount::updateOrCreate(
                        [
                            'account_id' => $account['id'],
                            'company_id' => $company->id,
                        ],
                        [
                            'name' => $account['name'],
                            'type' => $this->determineAccountType($account),
                            'access_token' => (string) $connection->access_token,
                            'fb_connection_id' => $connection->id,
                            'status' => $account['account_status'],
                            'amount_spent' => $account['amount_spent'] ?? 0,
                            'business_id' => $account['owner'],
                        ],
                    );
                }
            }

            MetaPage::where('company_id', $company->id)->chunk(100, function ($metaPages) use ($connection) {
                foreach ($metaPages as $metaPage) {
                    try {
                        $pageData = $this->metaService->getPageDetails($metaPage->page_id, $connection->access_token);
                        // dd($pageData['picture']['data']['url']);
                        $updates = array_filter(
                            [
                                'name' => $pageData['name'] ?? null,
                                'category' => $pageData['category'] ?? null,
                                'access_token' => $pageData['access_token'],
                                'picture_url' => $pageData['picture']['data']['url'] ?? null,
                                'tasks' => isset($pageData['tasks']) ? json_encode($pageData['tasks']) : null,
                                'page_permissions' => isset($pageData['page_permissions']) ? json_encode($pageData['page_permissions']) : null,
                            ],
                            function ($value) {
                                return $value !== null;
                            },
                        );

                        if (!empty($updates)) {
                            $metaPage->update($updates);
                        }
                    } catch (\Exception $e) {
                        \Log::warning("MetaPage update skipped for {$metaPage->page_id}: {$e->getMessage()}");
                    }
                }
            });

            return redirect()->route('ctwameta.index')->with('success', 'Accounts refreshed successfully!');
        } catch (\Exception $e) {
            Log::error('Refresh failed', [
                'error' => $e->getMessage(),
                'company_id' => Auth::user()->company->id,
            ]);

            return redirect()
                ->route('ctwameta.index')
                ->with('error', 'Failed to refresh accounts: ' . $e->getMessage());
        }
    }

    /**
     * Show analytics for a specific ad account
     */
    public function analytics($accountId)
    {
        try {
            $company = auth()->user()->getCurrentCompany();
            if (!$company) {
                throw new \Exception('No company associated with user');
            }
            $account = MetaAccount::where('company_id', $company->id)->where('account_id', $accountId)->firstOrFail();

            // Get analytics for last 30 days
            $endDate = now()->format('Y-m-d');
            $startDate = now()->subDays(30)->format('Y-m-d');

            if (!method_exists($this->metaService, 'getAccountAnalytics')) {
                throw new \Exception('Analytics functionality is not available');
            }

            $apiAnalytics = $this->metaService->getAccountAnalytics($account->account_id, $startDate, $endDate, $account->access_token);

            // Store analytics in database
            $this->storeAnalytics($account, $apiAnalytics, $company->id);

            // Get stored analytics from database
            $analytics = CTWAAnalytics::where('meta_account_id', $account->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'desc')
                ->get();

            return view('c-t-w-a-meta::analytics', [
                'account' => $account,
                'analytics' => $analytics,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        } catch (\Exception $e) {
            Log::error('Analytics failed', [
                'account_id' => $accountId,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('ctwameta.index')
                ->with('error', 'Failed to load analytics: ' . $e->getMessage());
        }
    }

    /**
     * Store analytics data in database
     */
    protected function storeAnalytics($account, $analyticsData, $companyId)
    {
        foreach ($analyticsData as $data) {
            try {
                $metrics = $this->prepareMetricsData($data);

                CTWAAnalytics::updateOrCreate(
                    [
                        'meta_account_id' => $account->id,
                        'date' => $data['date_start'],
                    ],
                    [
                        'company_id' => $companyId,
                        'metrics' => $metrics,
                    ],
                );
            } catch (\Exception $e) {
                Log::error('Failed to store analytics for date: ' . ($data['date_start'] ?? 'unknown'), [
                    'error' => $e->getMessage(),
                    'data' => $data,
                ]);
                continue;
            }
        }
    }

    protected function prepareMetricsData($data)
    {
        $metrics = [
            'basic' => [
                'impressions' => $data['impressions'] ?? 0,
                'reach' => $data['reach'] ?? 0,
                'spend' => $data['spend'] ?? 0,
                'cpm' => $data['cpm'] ?? null,
                'cpp' => $data['cpp'] ?? null,
                'ctr' => $data['ctr'] ?? null,
                'clicks' => $data['clicks'] ?? 0,
                'unique_clicks' => $data['unique_clicks'] ?? 0,
                'frequency' => $data['frequency'] ?? null,
            ],
            'actions' => [],
            'cost_per_action' => [],
            'rankings' => [
                'conversion_rate_ranking' => $data['conversion_rate_ranking'] ?? null,
                'quality_ranking' => $data['quality_ranking'] ?? null,
                'engagement_rate_ranking' => $data['engagement_rate_ranking'] ?? null,
            ],
        ];

        // Process actions
        if (!empty($data['actions'])) {
            foreach ($data['actions'] as $action) {
                if (isset($action['action_type'], $action['value'])) {
                    $metrics['actions'][$action['action_type']] = $action['value'];
                }
            }
        }

        // Process cost per action
        if (!empty($data['cost_per_action_type'])) {
            foreach ($data['cost_per_action_type'] as $action) {
                if (isset($action['action_type'], $action['value'])) {
                    $metrics['cost_per_action'][$action['action_type']] = $action['value'];
                }
            }
        }

        return $metrics;
    }

    public function toggleSubscription(Request $request)
    {
        $request->validate([
            'page_id' => 'required|string',
            'action' => 'required|in:subscribe,unsubscribe',
        ]);

        try {
            $pageId = $request->input('page_id');
            $pageInfo = MetaPage::where('page_id', $pageId)->first();
            $action = $request->input('action');
            $pageAccessToken = $pageInfo->access_token; // ... retrieve page access token ...;

            if ($action === 'subscribe') {
                $result = $this->metaService->subscribeToPage(
                    $pageId,
                    $pageAccessToken,
                    route('ctwameta.index'),
                    ['leadgen'], // Subscribe to leadgen events
                );

                if ($result['success']) {
                    // Additional step to subscribe to the page's leadgen endpoint
                    $this->metaService->createLeadgenSubscription($pageId, $pageAccessToken);

                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully subscribed to page leads',
                    ]);
                }
            } else {
                // Unsubscribe logic
                $result = $this->metaService->unsubscribeFromPage($pageId, $pageAccessToken);

                // Additional step to remove leadgen subscription
                $this->metaService->deleteLeadgenSubscription($pageId, $pageAccessToken);

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully unsubscribed from page leads',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Operation failed',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function viewLeads(Request $request, $pageId)
    {
        $query = MetaLeads::where('page_id', $pageId);

        // Filter parameters
        if ($request->filled('name')) {
            $query->where('field_data->full_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('phone')) {
            $query->where('field_data->phone_number', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('email')) {
            $query->where('field_data->email', 'like', '%' . $request->email . '%');
        }

        $leads = $query->latest()->paginate(20)->withQueryString();

        // Get page name for top-left display
        $pageName = MetaPage::where('page_id', $pageId)->value('name');

        return view('c-t-w-a-meta::facebook.leads-index', compact('leads', 'pageId', 'pageName'));
    }

    public function fetchLeads($pageId)
    {
        try {
            $page = MetaPage::where('page_id', $pageId)->firstOrFail();
            $accessToken = $page->access_token;
            $metaApi = new MetaApiService($accessToken);

            // 1 Ensure business account exists
            $businessAccount = MetaBusinessAccount::firstOrCreate(
                ['business_id' => $page->business_id],
                [
                    'company_id' => $page->company_id,
                    'fb_connection_id' => $page->fb_connection_id,
                    'name' => $page->name ?? 'Unnamed Business',
                ],
            );

            // 2 Ensure meta account exists
            $accountDetails = $metaApi->fbGetWithProof($page->business_id, "/{$page->business_id}/owned_ad_accounts", $accessToken, ['fields' => 'id,account_id,name,amount_spent']);

            $adAccount = $accountDetails['data'][0] ?? null;
            if (!$adAccount) {
                throw new \Exception("No ad account found for page {$pageId}");
            }

            $metaAccount = MetaAccount::firstOrCreate(
                ['account_id' => $adAccount['id'], 'company_id' => $page->company_id],
                [
                    'name' => $adAccount['name'] ?? 'Unnamed Account',
                    'type' => 'ctwa',
                    'status' => 1,
                    'amount_spent' => $adAccount['amount_spent'] ?? '0',
                    'business_id' => $page->business_id,
                    'access_token' => $accessToken,
                    'fb_connection_id' => $page->fb_connection_id,
                ],
            );

            // 3 Fetch forms
            $formsRes = $metaApi->fbGetWithProof($pageId, "/{$pageId}/leadgen_forms", $accessToken, ['fields' => 'id,name']);

            $allCount = 0;

            foreach ($formsRes['data'] ?? [] as $form) {
                // get already saved leads for this form
                $existingLeadIds = MetaLeads::where('form_id', $form['id'])->pluck('leadgen_id')->toArray();

                $leadsRes = $metaApi->fbGetWithProof($pageId, "/{$form['id']}/leads", $accessToken, ['fields' => 'id,created_time,field_data']);

                foreach ($leadsRes['data'] ?? [] as $lead) {
                    if (in_array($lead['id'], $existingLeadIds)) {
                        continue; // already stored, skip
                    }

                    MetaLeads::create([
                        'company_id' => $page->company_id,
                        'meta_account_id' => $metaAccount->id,
                        'business_id' => $businessAccount->id,
                        'form_id' => $form['id'],
                        'page_id' => $pageId,
                        'leadgen_id' => $lead['id'],
                        'field_data' => json_encode($lead['field_data'] ?? []),
                        'received_at' => $lead['created_time'] ?? now(),
                        'processed' => false,
                    ]);
                    $allCount++;
                }
            }

            return response()->json(['success' => true, 'message' => $allCount . ' new leads fetched.']);
        } catch (\Exception $e) {
            \Log::error('Fetch leads error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deletePage(Request $request)
    {
        try {
            $request->validate([
                'page_id' => 'required|string',
            ]);

            $companyId = auth()->user()->getCurrentCompany()->id;

            $page = MetaPage::where('page_id', $request->page_id)
                ->when($companyId, fn($q) => $q->where('company_id', $companyId))
                ->first();

            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Facebook page not found.',
                ], 404);
            }

            FacebookForm::where('meta_page_id', $page->page_id)->delete();

            $page->delete();

            return response()->json([
                'success' => true,
                'message' => 'Facebook page and its forms deleted successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting Facebook page: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the page.',
            ], 500);
        }
    }

    public function deleteBusiness(Request $request)
    {
        try {

            $companyId = auth()->user()->getCurrentCompany()->id;

            $business = MetaBusinessAccount::where('id', $request->business_id)
                ->where('company_id', $companyId)
                ->first();

            if (!$business) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business account not found.',
                ]);
            }

            $pages = MetaPage::where('business_id', $business->business_id)->get();

            foreach ($pages as $page) {
                MetaLeads::where('meta_page_id', $page->id)->delete();

                FacebookForm::where('meta_page_id', $page->page_id)->delete();

                $page->delete();
            }

            $business->delete();

            return response()->json([
                'success' => true,
                'message' => 'Business, related pages, leads, and forms deleted successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting business: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error deleting business account.',
            ]);
        }
    }
}
