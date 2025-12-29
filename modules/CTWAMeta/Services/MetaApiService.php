<?php

namespace Modules\CTWAMeta\Services;

use Illuminate\Support\Facades\Http;
use Modules\CTWAMeta\Services\LaravelPersistentDataHandler;
use JanuSoftware\Facebook\Facebook;
use JanuSoftware\Facebook\Exceptions\FacebookResponseException;
use JanuSoftware\Facebook\Exceptions\FacebookSDKException;
use Illuminate\Support\Facades\Log;

class MetaApiService
{
    protected $fb;
    protected $accessToken;

    public function __construct($accessToken = null)
    {
        $this->accessToken = $accessToken;

        // Verify config values exist
        if (!config('services.facebook.ad_client_id') || !config('services.facebook.ad_client_secret')) {
            throw new \RuntimeException('Facebook API credentials not configured');
        }

        $this->fb = new \JanuSoftware\Facebook\Facebook([
            'app_id' => config('services.facebook.ad_client_id'),
            'app_secret' => config('services.facebook.ad_client_secret'),
            'default_graph_version' => 'v18.0',
            'persistent_data_handler' => new LaravelPersistentDataHandler(),
        ]);
    }

    public function getFb()
    {
        return $this->fb;
    }

    public function getLoginUrl($redirectUrl, $state = null)
    {
        // Always use manual URL generation
        //pages_show_list
        $params = [
            'client_id' => config('services.facebook.ad_client_id'),
            'redirect_uri' => $redirectUrl,
            'state' => $state,
            'response_type' => 'code',
            'scope' => 'business_management,ads_management,pages_show_list,pages_manage_metadata,leads_retrieval,pages_manage_ads',
            'auth_type' => 'rerequest',
        ];


        // Remove empty parameters
        $params = array_filter($params);

        $loginUrl = 'https://www.facebook.com/v18.0/dialog/oauth?' . http_build_query($params);

        \Log::debug('Generated Facebook OAuth URL', [
            'url' => $loginUrl,
            'params' => $params,
        ]);

        return $loginUrl;
    }
    public function getAccessTokenFromCode($code, $redirectUri)
    {
        $helper = $this->fb->getRedirectLoginHelper();

        try {
            // Get access token object
            $accessToken = $helper->getAccessToken($redirectUri);

            if (!$accessToken) {
                throw new \Exception('Facebook returned empty access token');
            }

            // Verify we got a valid token object
            if (!method_exists($accessToken, 'getValue')) {
                throw new \RuntimeException('Invalid access token format received');
            }

            return $accessToken;
        } catch (\Exception $e) {
            \Log::error('Token exchange failed', [
                'error' => $e->getMessage(),
                'code' => $code,
            ]);
            throw new \Exception('Failed to exchange code for token: ' . $e->getMessage());
        }
    }

    public function getLongLivedToken($accessToken)
    {
        try {
            if (!$accessToken || !is_object($accessToken)) {
                throw new \InvalidArgumentException('Invalid access token provided');
            }

            $tokenString = (string) $accessToken;

            $response = $this->fb->get(
                '/oauth/access_token?' .
                    http_build_query([
                        'grant_type' => 'fb_exchange_token',
                        'client_id' => config('services.facebook.ad_client_id'), // Use config directly
                        'client_secret' => config('services.facebook.ad_client_secret'), // Use config directly
                        'fb_exchange_token' => $tokenString,
                    ]),
                $tokenString,
            );

            $data = $response->getDecodedBody();

            if (!isset($data['access_token'])) {
                throw new \RuntimeException('No access token returned in response');
            }

            return $data['access_token'];
        } catch (\Exception $e) {
            \Log::error('Long-lived token exchange failed', [
                'error' => $e->getMessage(),
                'token' => isset($tokenString) ? substr($tokenString, 0, 10) . '...' : 'none',
            ]);
            throw new \Exception('Failed to get long-lived token: ' . $e->getMessage());
        }
    }

    public function getBusinessAccounts($accessToken)
    {
        try {
            $response = $this->fb->get('/me/businesses?fields=id,name,vertical,primary_page,business_profile,link,picture.type(normal){url}', $accessToken);
            return $response->getGraphEdge()->asArray();
        } catch (\Exception $e) {
            \Log::error('Failed to get businesses: ' . $e->getMessage());
            return [];
        }
    }

    public function getAdAccounts($businessId, $accessToken)
    {
        try {
            $response = $this->fb->get("/{$businessId}/owned_ad_accounts?fields=id,name,amount_spent,account_status,balance,business_city,business,currency,owner,spend_cap,min_campaign_group_spend_cap,min_daily_budget,tax_id,status", $accessToken);
            return $response->getGraphEdge()->asArray();
        } catch (\Exception $e) {
            \Log::error("Failed to get ad accounts for business {$businessId}: " . $e->getMessage());
            return [];
        }
    }

    // public function getAdAccounts()
    // {
    //     try {
    //         $response = $this->fb->get('/me/adaccounts?fields=id,name', $this->accessToken);
    //         return $response->getGraphEdge();
    //     } catch (\Exception $e) {
    //         throw new \Exception($e->getMessage());
    //     } catch (\Exception $e) {
    //         throw new \Exception($e->getMessage());
    //     }
    // }

    public function getUserInfo($accessToken)
    {
        try {
            // Convert token to string if it's an object
            $tokenString = is_object($accessToken) ? (string) $accessToken : $accessToken;

            $response = $this->fb->get('/me?fields=id,name,picture', $tokenString);

            // Get the response body as an array
            $userData = $response->getDecodedBody();

            // Validate required fields
            if (!isset($userData['id']) || !isset($userData['name'])) {
                throw new \Exception('Invalid user data returned from Facebook');
            }

            return [
                'id' => $userData['id'],
                'name' => $userData['name'],
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to get user info', [
                'error' => $e->getMessage(),
                'token' => isset($tokenString) ? substr($tokenString, 0, 10) . '...' : 'invalid',
            ]);
            throw new \Exception('Failed to get user info: ' . $e->getMessage());
        }
    }

    public function getAccountAnalytics($accountId, $startDate, $endDate, $accessToken)
    {
        try {
            $response = $this->fb->get(
                "/{$accountId}/insights?" .
                    http_build_query([
                        'fields' => implode(',', ['impressions', 'reach', 'spend', 'cpm', 'cpp', 'ctr', 'clicks', 'unique_clicks', 'frequency', 'actions', 'action_values', 'cost_per_action_type', 'cost_per_unique_action_type', 'conversions', 'conversion_values', 'conversion_rate_ranking', 'quality_ranking', 'engagement_rate_ranking']),
                        'time_range' => json_encode([
                            'since' => $startDate,
                            'until' => $endDate,
                        ]),
                        'level' => 'account',
                        'time_increment' => 1, // Get daily breakdown
                    ]),
                $accessToken,
            );

            return $response->getDecodedBody()['data'] ?? [];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            Log::error('Facebook API Error: ' . $e->getMessage());
            throw new \Exception('Failed to fetch analytics from Facebook: ' . $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            Log::error('Facebook SDK Error: ' . $e->getMessage());
            throw new \Exception('Facebook SDK error: ' . $e->getMessage());
        }
    }

    public function getPages($businessId, $accessToken)
    {
        //picture.type(large){url}
        try {
            $fields = ['id', 'name', 'category', 'picture.type(large){url}', 'access_token', 'link', 'verification_status', 'about'];
            $tokenString = is_object($accessToken) ? (string) $accessToken : $accessToken;
            $response = $this->fb->get("/{$businessId}/owned_pages?fields=" . implode(',', $fields), $accessToken);

            return $response->getGraphEdge()->asArray();
        } catch (\Exception $e) {
            \Log::error("Error fetching pages for business {$businessId}: " . $e->getMessage());
            return [];
        }
    }

    public function getPageDetails(string $pageId, string $accessToken): array
    {
        try {
            // Define the fields we want to retrieve from the API
            $fields = ['id', 'name', 'category', 'picture.type(large){url}', 'access_token', 'link', 'verification_status', 'about', 'location', 'hours', 'impressum', 'phone', 'emails', 'website'];
            $tokenString = is_object($accessToken) ? (string) $accessToken : $accessToken;
            $response = $this->fb->get("/{$pageId}?fields=" . implode(',', $fields), $tokenString);

            $pageData = $response->getGraphNode()->asArray();

            // Format the response to match your expected structure
            return [
                'id' => $pageData['id'] ?? null,
                'name' => $pageData['name'] ?? null,
                'category' => $pageData['category'] ?? null,
                'picture' => [
                    'data' => [
                        'url' => $pageData['picture']['url'] ?? null,
                    ],
                ],
                'tasks' => $pageData['tasks'] ?? [],
                'page_permissions' => $pageData['page_permissions'] ?? [],
                'access_token' => $pageData['access_token'] ?? null,
                'link' => $pageData['link'] ?? null,
                'verification_status' => $pageData['verification_status'] ?? null,
                'about' => $pageData['about'] ?? null,
                'website' => $pageData['website'] ?? null,
                // Add other fields as needed
            ];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            Log::error('Facebook API Error fetching page details: ' . $e->getMessage(), [
                'page_id' => $pageId,
                'error_code' => $e->getCode(),
            ]);
            throw new \Exception('Facebook API Error: ' . $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            Log::error('Facebook SDK Error fetching page details: ' . $e->getMessage());
            throw new \Exception('Facebook SDK Error: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error fetching page details: ' . $e->getMessage());
            throw new \Exception('Error fetching page details: ' . $e->getMessage());
        }
    }

    public function createLeadgenSubscription($pageId, $accessToken)
    {
        $url = "https://graph.facebook.com/v19.0/{$pageId}/subscribed_apps";

        $response = Http::post($url, [
            'subscribed_fields' => 'leadgen',
            'access_token' => $accessToken,
        ]);

        return $response->json();
    }

    public function deleteLeadgenSubscription($pageId, $accessToken)
    {
        $url = "https://graph.facebook.com/v19.0/{$pageId}/subscribed_apps";

        $response = Http::delete($url, [
            'subscribed_fields' => 'leadgen',
            'access_token' => $accessToken,
        ]);

        return $response->json();
    }

    public function subscribeToPage(string $pageId, string $pageAccessToken, string $callbackUrl, array $fields = ['leadgen']): array
    {
        try {
            // First, subscribe the app to receive webhooks for the page
            $subscribeUrl = "https://graph.facebook.com/v19.0/{$pageId}/subscribed_apps";

            $response = Http::post($subscribeUrl, [
                'subscribed_fields' => $fields,
                'access_token' => $pageAccessToken,
            ]);
            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success'] === true) {
                return [
                    'success' => true,
                    'data' => $result,
                    'message' => 'Successfully subscribed app to page',
                ];
            }

            // if ($response->successful() && isset($result['success'])) {
            //     // Then subscribe to the specific webhook
            //     $webhookUrl = "https://graph.facebook.com/v19.0/{$pageId}/subscriptions";

            //     $webhookResponse = Http::post($webhookUrl, [
            //         'access_token' => $pageAccessToken,
            //         'object' => 'page',
            //         'callback_url' => $callbackUrl,
            //         'fields' => $fields,
            //         'verify_token' => config('services.facebook.verify_token'),
            //         'include_values' => true,
            //     ]);

            //     $webhookResult = $webhookResponse->json();

            //     if ($webhookResponse->successful()) {
            //         return [
            //             'success' => true,
            //             'data' => $webhookResult,
            //             'message' => 'Successfully subscribed to page webhooks',
            //         ];
            //     }

            //     return [
            //         'success' => false,
            //         'error' => $webhookResult['error'] ?? null,
            //         'message' => 'Failed to create webhook subscription',
            //     ];
            // }

            return [
                'success' => false,
                'error' => $result['error'] ?? null,
                'message' => 'Failed to subscribe app to page',
            ];
        } catch (\Exception $e) {
            Log::error('Facebook subscription error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Unsubscribe from Facebook Page webhooks
     *
     * @param string $pageId
     * @param string $pageAccessToken
     * @return array
     */
    public function unsubscribeFromPage(string $pageId, string $pageAccessToken): array
    {
        try {
            // First, delete the webhook subscription
            $webhookUrl = "https://graph.facebook.com/v19.0/{$pageId}/subscriptions";

            $webhookResponse = Http::delete($webhookUrl, [
                'access_token' => $pageAccessToken,
            ]);

            $webhookResult = $webhookResponse->json();

            // Then unsubscribe the app from the page
            $subscribeUrl = "https://graph.facebook.com/v19.0/{$pageId}/subscribed_apps";

            $response = Http::delete($subscribeUrl, [
                'access_token' => $pageAccessToken,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success'])) {
                return [
                    'success' => true,
                    'data' => $result,
                    'message' => 'Successfully unsubscribed from page',
                ];
            }

            return [
                'success' => false,
                'error' => $result['error'] ?? null,
                'message' => 'Failed to unsubscribe from page',
            ];
        } catch (\Exception $e) {
            Log::error('Facebook unsubscription error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get current subscriptions for a page
     *
     * @param string $pageId
     * @param string $pageAccessToken
     * @return array
     */
    public function getPageSubscriptions(string $pageId, string $pageAccessToken): array
    {
        try {
            $url = "https://graph.facebook.com/v19.0/{$pageId}/subscriptions?access_token={$pageAccessToken}";

            $response = Http::get($url);
            $result = $response->json();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $result['data'] ?? [],
                    'message' => 'Successfully retrieved subscriptions',
                ];
            }

            return [
                'success' => false,
                'error' => $result['error'] ?? null,
                'message' => 'Failed to get subscriptions',
            ];
        } catch (\Exception $e) {
            Log::error('Facebook get subscriptions error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Return appsecret_proof for a token (safe: cast token to string first)
     */
    public function getAppSecretProof($pageId, $accessToken)
    {
        $tokenString = is_object($accessToken) ? (string) $accessToken : (string) $accessToken;
        $tokenString = trim($tokenString);
        $appSecret = trim(config('services.facebook.app_secret'));

        $appsecret_proof = hash_hmac('sha256', $tokenString, $appSecret);

        $response = Http::get("https://graph.facebook.com/v19.0/{$pageId}/leadgen_forms", [
            'fields'         => 'id,name',
            'access_token'   => $tokenString,
            'appsecret_proof' => $appsecret_proof,
        ]);
    }


    /**
     * Helper for GET requests that automatically adds access_token + appsecret_proof
     * Returns decoded body (array)
     */
    public function fbGetWithProof($pageId, string $path, $accessToken, array $params = [])
    {
        $tokenString = is_object($accessToken) ? (string) $accessToken : $accessToken;
        $tokenString = trim($tokenString);

        // add token + proof
        $params['access_token'] = $tokenString;
        $params['appsecret_proof'] = $this->getAppSecretProof($pageId, $tokenString);

        $query = http_build_query($params);
        $endpoint = $path . (strpos($path, '?') === false ? '?' . $query : '&' . $query);

        $response = $this->fb->get($endpoint, $tokenString);
        return $response->getDecodedBody();
    }
}
