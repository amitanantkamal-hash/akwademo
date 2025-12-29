<?php

namespace Modules\Wpbox\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Wpbox\Models\SocialMediaToken;

class MetaController extends Controller {
    public $url;
    public $metaCredentials = [
        'messenger' => [
            'appID' => '',
            'appSecret' => '',
        ],
        'instagram' => [
            'appID' => '',
            'appSecret' => '',
        ]
    ];
    public $currentPage = '';

    public function __construct() {
        $this->url = env('META_MESSAGES_URL');
        $this->metaCredentials['messenger']['appID'] = env('FACEBOOK_MESSAGES_APP_ID');
        $this->metaCredentials['messenger']['appSecret'] = env('FACEBOOK_MESSAGES_APP_SECRET');
        $this->metaCredentials['instagram']['appID'] = env('INSTAGRAM_MESSAGES_APP_ID');
        $this->metaCredentials['instagram']['appSecret'] = env('INSTAGRAM_MESSAGES_APP_SECRET');
    }

    public function setup($socialMedia) {
        $alias = $socialMedia;
        if ($socialMedia == 'facebook') {
            $alias = 'messenger';
        }
        //if user is admin
        if (auth()->user()->hasRole('admin')) {
            return $this->setupEmbedded();
        }
        $company = $this->getCompany();
        //In case, we are in company 1, and we are in demo mode, don't allow this
        if (config('settings.is_demo', false)) {
            return redirect(route('campaigns.index'))->withStatus(__('This view is not allowed for the Demo company. Please create your account, so you can see the WhatsApp Cloud Setup view.'));
        }
        $setupDone = (Company::find($company->id))
            ->socialMediaTokens()
            ->where('social_media_name', $alias)
            ->first();
        return view(
            'wpbox::meta.index',
            [
                'setupDone' => json_encode($setupDone !== null),
                'company' => $company,
                'socialMedia' => $socialMedia,
                'alias' => $alias,
                'pageName' => ($setupDone !== null) ? $setupDone->name : ''
            ]
        );
    }

    public function getAccessToken($code) {
        $client = new Client();

        $response = $client->request('GET', $this->url . 'oauth/access_token', [
            'query' => [
                'client_id' => $this->metaCredentials[$this->currentPage]['appID'],
                'client_secret' => $this->metaCredentials[$this->currentPage]['appSecret'],
                'grant_type' => 'client_credentials',
                'code' => $code
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);
            return $data->data;
        } else {
            return response()->json(['error' => 'Error getting short lived token'], 500);
        }
    }

    public function exchangeShortToken($token, $pageID) {
        $client = new Client();
        if (empty($this->metaCredentials[$this->currentPage]['appID']) || empty($this->metaCredentials[$this->currentPage]['appSecret']) || empty($token)) {
            throw new \Exception('Missing required parameters: app credentials or short-lived token');
        }

        try {
            $userAccessTokenRequest = $client->request('GET', $this->url . 'oauth/access_token', [
                'query' => [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => $this->metaCredentials[$this->currentPage]['appID'],
                    'client_secret' => $this->metaCredentials[$this->currentPage]['appSecret'],
                    'fb_exchange_token' => $token
                ]
            ]);
        } catch (GuzzleException $e) {
            return false;
        }

        if ($userAccessTokenRequest->getStatusCode() !== 200) {
            return false;
        }

        return json_decode($userAccessTokenRequest->getBody(), true);
        /* $userAccessToken = json_decode($userAccessTokenRequest->getBody(), true);
        try {
            $response = $client->request(
                'GET',
                $this->url . $pageID . '/accounts',
                ['query' => [
                    'access_token' => $userAccessToken['access_token']
                ]]
            );
            $pageAccessTokenRequest = json_decode($response->getBody(), true);
            dd($pageAccessTokenRequest);
        } catch (GuzzleException $e) {
            dd($e);
            return false;
        }

        if ($pageAccessTokenRequest->getStatusCode() !== 200) {
            return false;
        }

        return json_decode($pageAccessTokenRequest->getBody(), true); */
    }

    public function getConversations(Request $request) {
        $client = new Client();
        $socialMediaTokens = (Company::find($request->company_id))->socialMediaTokens()->get();

        if (!$socialMediaTokens->count()) {
            return response()->json(['error' => 'META not registered'], 500);
        }

        //$platforms = ['messenger', 'instagram'];
        $result = collect();
        foreach ($socialMediaTokens as $smt) {
            $query = [
                'platform' => $smt->social_media_name,
                'access_token' => $smt->access_token,
            ];
            if ($smt->social_media_name == 'instagram') {
                $query['fields'] = 'name,participants,updated_time,messages{id,from,created_time,message}';
                //$query['limit'] = 1;
            } else {
                $query['fields'] = 'name,participants,unread_count,updated_time,messages{id,from,created_time,message}';
            }
            try {
                $response = $client->request('GET', $this->url . $smt->app_id . '/conversations', [
                    'query' => $query,
                    'timeout' => 3600,
                    'connect_timeout' => 3600
                ]);
                if ($response->getStatusCode() !== 200) {
                    continue;
                }
                $data = json_decode(($response->getBody()))->data;
                $transformedData = $this->transformConversations(
                    $data,
                    $request->company_id,
                    $smt->app_id,
                    $smt->social_media_name
                );
                $result = $result->merge($transformedData);
            } catch (Exception $e) {
                continue;
            }
        }
        return $result;
    }

    public function getMessages(Request $request) {
        $client = new Client();
        $socialMediaTokens = (Company::find($request->company_id))->socialMediaTokens()->get();
        if (!$socialMediaTokens->count()) {
            return response()->json(['error' => 'META not registered'], 500);
        }

        $result = collect();
        foreach ($socialMediaTokens as $smt) {
            $response = $client->request('GET', $this->url . $request->conversation_id, [
                'query' => [
                    'fields' => 'messages{id,from,message,created_time}',
                    'access_token' => $smt->access_token,
                ]
            ]);

            // Handle response
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody())->messages->data;
                $messages = $this->transformMessages($data, $request->company_id, $smt->app_id);
                $result = $result->merge($messages);
            }
        }
    }

    public function sendMessage(Request $request) {
        $client = new Client();

        $socialMediaToken = (Company::find($request->company_id))->socialMediaTokens()->first();
        if (!$socialMediaToken) {
            return response()->json(['error' => 'META not registered'], 500);
        }
        try {
            $response = $client->post($this->url . $socialMediaToken->app_id . "/messages", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'access_token' => $socialMediaToken->access_token,
                ],
                'json' => [
                    'recipient' => [
                        'id' => $request->user_id,
                    ],
                    'messaging_type' => 'MESSAGE_TAG',
                    'tag' => 'HUMAN_AGENT',
                    'message' => [
                        'text' => $request->message,
                    ],
                ],
            ]);
            if ($response->getStatusCode() != 200) {
                return $response;
                return response()->json(['error' => 'Facebook Messenger API request failed'], 500);
            }
            return json_decode($response->getBody());
        } catch (ClientException $e) {
            return response()->json('Facebook Messenger API error: ' . $e->getResponse()->getBody(), 500);
        } catch (\Exception $e) {
            return response()->json('Unexpected error sending Facebook Messenger message: ' . $e, 500);
        }
    }

    public function receiveMessage(Request $request) {
        Log::info('Messenger Hook');
        Log::info($request->all());
        return response()->json('EVENT_RECEIVED', 200);
    }

    public function handleWebhook(Request $request) {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if (isset($mode) && isset($token)) {
            if ($mode === 'subscribe' && $token === $this->metaCredentials[$this->currentPage]['appID']) {
                Log::info('WEBHOOK_VERIFIED');
                return response($challenge, 200);
            } else {
                return response()->json('error', 401);
            }
        }
        return response()->json('error', 401);
    }

    public function connectPage(Request $request) {
        $this->currentPage = $request->socialMedia;
        $client = new Client();

        // Get long lived token
        $token = $this->exchangeShortToken($request->accessToken, $request->pageID);
        if (!$token) {
            return response()->json(['error' => 'Error exchanging token'], 500);
        }

        try {
            // Get pages
            $response = $client->request('GET', $this->url . $request->userID . '/accounts', [
                'query' => [
                    'access_token' => $token['access_token'],
                    'client_id' => $this->metaCredentials[$this->currentPage]['appID'],
                    'client_secret' => $this->metaCredentials[$this->currentPage]['appSecret'],
                ]
            ]);
        } catch (GuzzleException $e) {
            return response()->json(['error' => 'Error getting pages'], 500);
        }

        if ($response->getStatusCode() !== 200) {
            return response()->json(['error' => 'Error getting pages'], 500);
        }
        $page_id = $request->pageID;
        $data = json_decode($response->getBody(), true);
        $page = collect(array_filter($data['data'], function ($item) use ($page_id) {
            return $item['id'] == $page_id;
        }))->first();

        // Store one single page on SMT
        $smt = SocialMediaToken::updateOrCreate(
            ['company_id' => $request->companyID],
            [
                'company_id' => $request->companyID,
                'social_media_name' => $request->socialMedia,
                'name' => $page['name'],
                'app_id' => $page['id'],
                'access_token' => $page['access_token'],
            ]
        );

        return response()->json($smt->name, 200);
    }

    public function getPages(Request $request) {
        $client = new Client();
        $this->currentPage = $request->socialMedia;
        try {
            $response = $client->request('GET', $this->url . $request->userID . '/accounts', [
                'query' => [
                    'access_token' => $request->accessToken,
                    'client_id' => $this->metaCredentials[$this->currentPage]['appID'],
                    'client_secret' => $this->metaCredentials[$this->currentPage]['appSecret'],
                ]
            ]);
        } catch (GuzzleException $e) {
            return response()->json(['error' => 'Error getting pages'], 500);
        }

        if ($response->getStatusCode() !== 200) {
            return response()->json(['error' => 'Error getting pages'], 500);
        }

        $pages = json_decode($response->getBody())->data;
        return response()->json(collect($pages)->map(function ($page) {
            return [
                'id' => $page->id,
                'name' => $page->name,
            ];
        })->toArray());
    }

    public function transformConversations($conversations, $companyID, $appID, $rrss) {
        return collect($conversations)
            ->map(function ($conversation) use ($companyID, $appID, $rrss) {
                return [
                    'id' => $conversation->id,
                    'name' => $conversation->participants->data[0]->name ?? $conversation->participants->data[1]->username,
                    'lastname' => '',
                    'phone' => '',
                    'avatar' => '',
                    'country_id' => 229,
                    'company_id' => $companyID,
                    'deleted_at' => null,
                    'created_at' => '',
                    'updated_at' => $conversation->updated_time,
                    'last_reply_at' => $conversation->messages->data[0]->created_time,
                    'last_client_reply_at' => '',
                    'last_support_reply_at' => '',
                    'last_message' => Str::limit($conversation->messages->data[0]->message, 37, '...'),
                    'is_last_message_by_contact' => $conversation->messages->data[0]->from->id != strval($appID),
                    'has_chat' => 1,
                    'resolved_chat' => 0,
                    'user_id' => $conversation->participants->data[0]->id,
                    'enabled_ai_bot' => 1,
                    'subscribed' => 1,
                    'email' => $conversation->participants->data[0]->email ?? '',
                    'language' => 'English',
                    'status' => '1',
                    'messages' => $this->transformMessages($conversation->messages->data, $companyID, $appID),
                    'isActive' => 0,
                    'platform' => $rrss
                ];
            });
    }

    public function transformMessages($messages, $companyID, $appID) {
        return collect(array_reverse($messages))
            ->map(function ($message) use ($companyID, $appID) {
                return [
                    'id' => $message->id,
                    'fb_message_id' => $message->id,
                    'contact_id' => $message->from->id,
                    'company_id' => $companyID,
                    'header_text' => '',
                    'footer_text' => '',
                    'header_image' => '',
                    'header_video' => '',
                    'header_location' => '',
                    'header_document' => '',
                    'buttons' => "[]",
                    'value' => $message->message,
                    'error' => '',
                    'is_campign_messages' => 0,
                    'is_message_by_contact' => $message->from->id != strval($appID),
                    'message_type' => 1,
                    'status' => 1,
                    'created_at' => $message->created_time,
                    'updated_at' => $message->created_time,
                    'scchuduled_at' => null,
                    'components' => '',
                    'campaign_id' => null,
                    'header_audio' => '',
                    'bot_has_replied' => 0,
                    'ai_bot_has_replied' => 0,
                    'original_message' => '',
                    'sender_name' => '',
                    'extra' => '',
                    'is_note' => 0
                ];
            });
    }

    public function logout($socialMedia) {
        $company = $this->getCompany();
        return (Company::find($company->id))->socialMediaTokens()
            ->where('social_media_name', $socialMedia)
            ->delete();
    }
}
