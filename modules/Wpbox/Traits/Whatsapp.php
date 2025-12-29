<?php

namespace Modules\Wpbox\Traits;

use App\Models\Company;
use App\Models\Config;
use Modules\CTWA\Models\CTWAReferral;
use Modules\Wpbox\Models\Message;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use Modules\Wpbox\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\Paymenttemplate;
use App\Models\User;
use Modules\Wpbox\Jobs\ReceiveUpdate;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\Template;
use Modules\Catalogs\Models\ProductCategory;
use Illuminate\Support\Facades\Log;
use Modules\CTWAMeta\Models\CTWAAdsClickLead;
use Modules\CTWAMeta\Models\FacebookAppConnection;

trait Whatsapp
{
    public static $facebookAPI = 'https://graph.facebook.com/v21.0/';

    private function getToken(Company $company = null)
    {
        if ($company == null) {
            $company = $this->getCompany();
        }
        return $company->getConfig('whatsapp_permanent_access_token', '');
    }

    private function getPhoneID(Company $company = null)
    {
        if ($company == null) {
            $company = $this->getCompany();
        }
        return $company->getConfig('whatsapp_phone_number_id', '');
    }

    private function getAccountID(Company $company = null)
    {
        if ($company == null) {
            $company = $this->getCompany();
        }
        return $company->getConfig('whatsapp_business_account_id', '');
    }

    private function sendCampaignMessageToWhatsApp(Message $message)
    {
        //We need data per company
        $company = null;
        try {
            $company = $message->campaign->company;
            $message->contact->phone;
        } catch (\Throwable $th) {
            $message->error = 'The company or contact is not found';
            $message->status = 1;
            $message->update();
        }

        if ($company) {
            $url = self::$facebookAPI . $this->getPhoneID($company) . '/messages';
            $accessToken = $this->getToken($company);

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'messaging_product' => 'whatsapp',
                    'to' => $message->contact->phone, // Add recipient information
                    'type' => 'template',
                    'template' => [
                        'name' => $message->campaign->template->name,
                        'language' => [
                            'code' => $message->campaign->template->language,
                        ],
                        'components' => json_decode($message->components),
                    ],
                ]);

                $postdata = [
                    'messaging_product' => 'whatsapp',
                    'to' => $message->contact->phone, // Add recipient information
                    'type' => 'template',
                    'template' => [
                        'name' => $message->campaign->template->name,
                        'language' => [
                            'code' => $message->campaign->template->language,
                        ],
                        'components' => json_decode($message->components),
                    ],
                ];

                $statusCode = $response->status();
                $content = json_decode($response->body(), true);
                //dd($content);
                $message->created_at = now();
                if (isset($content['messages'])) {
                    $message->fb_message_id = $content['messages'][0]['id'];
                } else {
                    $message->error = isset($content['error']) ? $content['error']['message'] : 'Unknown error';
                    //dd($content);
                }
                $message->status = 1;
                $message->update();
                // Handle the response as needed based on $statusCode and $content
            } catch (\Exception $e) {
                //dd($e);
                // Handle the exception
            }
        }
    }

    private function access_connect($whatsapp_account_id = null, $whatsapp_access_token = null, $whatsapp_number_id = null)
    {
        $returndata[] = null;
        //check whatsapp access if registered update else save new
        if (!empty($whatsapp_account_id) || $whatsapp_access_token || $whatsapp_number_id) {
            $numberInfo = $this->getNumberInfoFromWhatsApp($whatsapp_access_token, $whatsapp_number_id);
            if ($numberInfo['status'] == 200) {
                $returndata['verified_name'] = $numberInfo['content']['verified_name'] ?? '';
                $returndata['code_verification_status'] = $numberInfo['content']['status'] ?? '';
                $returndata['display_phone_number'] = $numberInfo['content']['display_phone_number'] ?? '';
                $returndata['quality_rating'] = $numberInfo['content']['quality_score']['score'] ?? 'N/A';
                $returndata['messaging_limit_tier'] = $numberInfo['content']['messaging_limit_tier'] ?? '';
                $returndata['name_status'] = $numberInfo['content']['name_status'] ?? '';
                $returndata['last_onboarded_time'] = $numberInfo['content']['last_onboarded_time'] ?? '';
                $returndata['can_send_message'] = $numberInfo['content']['health_status']['can_send_message'] ?? '';

                $numberPofileInfo = $this->getNumberProfileInfoFromWhatsApp($whatsapp_access_token, $whatsapp_number_id);
                if ($numberPofileInfo['status'] == 200) {
                    $returndata['profile_picture_url'] = $numberPofileInfo['content']['data'][0]['profile_picture_url'] ?? '';
                }
                // $numberInfo['content']['quality_score']['score'];
                // $numberInfo['content']['health_status']['can_send_message'];
                // $numberInfo['content']['messaging_limit_tier'];
                // $numberInfo['content']['name_status'];
                // $numberInfo['content']['status'];
                // $numberInfo['content']['last_onboarded_time'];
                // $numberInfo['content']['platform_type'];
                // $numberInfo['content']['throughput']['level'];
                // $numberInfo['content']['account_mode'];
                // $numberInfo['content']['verified_name'];
                // $numberInfo['content']['display_phone_number'];
            }
        }

        return $returndata;
    }

    public function getNumberInfoFromWhatsApp($access_token, $phoneID)
    {
        $url = self::$facebookAPI . $phoneID . '?fields=account_mode,display_phone_number,health_status,id,last_onboarded_time,messaging_limit_tier,name_status,platform_type,quality_score,status,throughput,verified_name';
        $accessToken = $access_token;
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->get($url);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);

            return ['status' => $statusCode, 'content' => $content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status' => 500, 'content' => $e->getMessage(), 'url' => $url, 'Authorization' => 'Bearer ' . $accessToken];
        }
    }

    public function getNumberProfileInfoFromWhatsApp($access_token, $phoneID)
    {
        $url = self::$facebookAPI . '/' . $phoneID . '/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical';
        $accessToken = $access_token;
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->get($url);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);

            return ['status' => $statusCode, 'content' => $content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status' => 500, 'content' => $e->getMessage(), 'url' => $url, 'Authorization' => 'Bearer ' . $accessToken];
        }
    }

    public function receiveMessage(Request $request, $token)
    {
        Log::info('receiveMessage Raw Payload:', ['body' => $request->getContent()]);
        Log::info('Parsed Payload:', ['all' => $request->all()]);

        if (config('wpbox.campaign_sending_type', 'normal') == 'normal') {
            //Continue with the regular flow
        } else {
            //Check if the request is update from WhatsApp
            try {
                $value = $request->entry[0]['changes'][0]['value'] ?? [];

                // Safe read: statuses array + first status item
                $statuses = $value['statuses'][0] ?? null;

                // Detect payment safely
                $payment = $statuses['payment'] ?? null;
                if (!$payment) {
                    if (isset($value['statuses'])) {
                        // Only queue if this is truly a status update (not payment)
                        dispatch(new ReceiveUpdate($value));
                        return response()->json([
                            'send' => true,
                            'message' => 'Update received and queued'
                        ]);
                    }
                }
            } catch (\Throwable $th) {
                //Continue with the regular flow
            }
        }
        $token = PersonalAccessToken::findToken($token);

        if ($token) {
            // Token is valid
            // Proceed with the request handling

            //Find the user
            $user = User::findOrFail($token->tokenable_id);
            Auth::login($user);

            //if the user is admin
            if ($user->hasRole('admin')) {
                //Find company based on the WABAID
                $wabaid = $request->entry[0]['id'];
                $company_id = Config::where('value', $wabaid)->first()->model_id;
                if ($company_id) {
                    $company = Company::find($company_id);
                    if (!$company) {
                        return response()->json(['send' => false, 'error' => 'Company not found']);
                    } else {
                        Auth::login($company->user);
                    }
                } else {
                    return response()->json(['send' => false, 'error' => 'Company not found']);
                }
            } else {
                //Company
                $company = $this->getCompany();
            }

            //Get the message object
            try {
                $value = $request->entry[0]['changes'][0]['value'];

                if (isset($value['statuses'])) {
                    //Status change -- Message update
                    $statusItem = $value['statuses'][0] ?? null;
                    $payment = $statusItem['payment'] ?? null;

                    // ------------------------------------------------------
                    // 1. PAYMENT STATUS
                    // ------------------------------------------------------
                    if ($payment) {

                        // Update Payment Status in your DB
                        $messageFBID = $statusItem['id'];
                        $message = Message::where('fb_message_id', $messageFBID)->first();

                        if ($message) {
                            $message->payment_status = $payment['status'] ?? 'paid';
                            $message->payment_details = json_encode($payment);
                            $message->save();
                        }

                        // Send payment webhook
                        $whatsapp_data_send_to_catalog = $company->getConfig('whatsapp_data_send_to_catalog', '');
                        if (strlen($whatsapp_data_send_to_catalog) > 5) {
                            Http::post($whatsapp_data_send_to_catalog, $request->all());
                        }

                        return response()->json(['send' => true, 'message' => 'Payment processed']);
                    }



                    // ------------------------------------------------------
                    // 2. NON-PAYMENT → MESSAGE DELIVERY STATUS UPDATE
                    // ------------------------------------------------------
                    if (isset($value['statuses'])) {

                        $newStatus = $statusItem['status'];
                        $messageFBID = $statusItem['id'];
                        if ($messageFBID) {
                            $message = Message::where('fb_message_id', $messageFBID)->first();

                            if ($message) {

                                $message_previous_status = $message->status;

                                // -------------------------
                                // Update status codes
                                // -------------------------
                                if ($newStatus == 'sent' && $message->status != 3) {
                                    $message->status = 2; // sent
                                } elseif ($newStatus == 'delivered' && $message->status != 4) {
                                    $message->status = 3; // delivered
                                } elseif ($newStatus == 'read') {
                                    $message->status = 4; // read
                                } elseif ($newStatus == 'failed') {
                                    $message->status = 5; // failed
                                    $message->error = $statusItem['errors'][0]['message'] ?? null;
                                }

                                $message->save();


                                // -------------------------
                                // Update campaign stats
                                // -------------------------
                                if ($message->campaign_id != null && $message_previous_status != $message->status) {

                                    $campaign = Campaign::find($message->campaign_id);

                                    if ($campaign) {
                                        if ($newStatus == 'sent') {
                                            $campaign->increment('sended_to', 1);
                                        } elseif ($newStatus == 'delivered') {
                                            $campaign->increment('delivered_to', 1);
                                        } elseif ($newStatus == 'read') {
                                            $campaign->increment('read_by', 1);
                                        }
                                    }
                                }

                                return response()->json(['send' => true, 'message' => 'Status updated']);
                            }
                        }
                    }
                } else {
                    //Message receive
                    $phone = $value['messages'][0]['from'];

                    $type = $value['messages'][0]['type'];
                    $name = $value['contacts'][0]['profile']['name'];
                    $messageID = $value['messages'][0]['id'];
                    $this->sendWithTypingIndicator($messageID);

                    $whatsapp_data_send_webhook = $company->getConfig('whatsapp_data_send_webhook', '');
                    if (strlen($whatsapp_data_send_webhook) > 5) {
                        //Send the data to a webhook
                        Http::post($whatsapp_data_send_webhook, $request->all());
                    }

                    $whatsapp_data_send_to_catalog = $company->getConfig('whatsapp_data_send_to_catalog', '');
                    if (strlen($whatsapp_data_send_to_catalog) > 5) {
                        //Send the data to a webhook
                        Http::post($whatsapp_data_send_to_catalog, $request->all());
                    }

                    //Check if this phone is in the blacklist
                    $blacklist = $company->getConfig('black_listed_phone_numbers', '');
                    if (strlen($blacklist) > 5) {
                        $blacklist = explode(',', $blacklist);

                        if (in_array($phone, $blacklist)) {
                            return response()->json(['send' => false, 'error' => 'Blacklisted']);
                        }
                    }

                    //Find the contact
                    $contact = Contact::where('phone', $phone)
                        ->orWhere('phone', '+' . $phone)
                        ->where('company_id', $company->id)
                        ->first();

                    if (!$contact) {
                        //Create new contact
                        $contact = Contact::create([
                            'name' => $name,
                            'phone' => $phone,
                            'avatar' => '',
                            'company_id' => $company->id,
                            'has_chat' => true,
                            'enabled_ai_bot' => 1,
                            'subscribed' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'last_support_reply_at' => null,
                            'last_reply_at' => now(),
                            'last_message' => '',
                            'is_last_message_by_contact' => true,
                        ]);
                    }

                    if ($contact) {
                        $contact->is_replied = true;
                        $contact->replied_at = now();
                        $contact->save();

                        // Find the message that this is a reply to
                        // $originalMessage = Message::where('contact_id', $contact->id)
                        //     ->where('fb_message_id', $messageID) // or whatever identifies the original message
                        //     ->first();

                        // if ($originalMessage) {
                        //     // Mark the original message as replied to
                        //     $originalMessage->is_replied = true;
                        //     $originalMessage->replied_at = now();
                        //     $originalMessage->save();
                        // }
                    }

                    $referral = $value['messages'][0]['referral'] ?? null;

                    if ($referral && $phone) {
                        $sourceUrl = $referral['source_url'] ?? null;
                        $sourceId = $referral['source_id'] ?? null;
                        $sourceType = $referral['source_type'] ?? null;

                        CTWAAdsClickLead::create([
                            'company_id' => $company->id,
                            'contact_id' => $contact->id,
                            'source_url' => $sourceUrl,
                            'source_id' => $sourceId,
                            'source_type' => $sourceType,
                            'wa_id' => $phone,
                        ]);
                    }

                    // If the message is a CTWA referral
                    if (isset($value['messages'][0]['referral']) && !empty($value['messages'][0]['referral']['ad_id'])) {
                        return $this->handleCTWAReferral($value['messages'][0], $contact, $company);
                    }

                    //$this->updateReadResponse($messageID);

                    if ($type == 'image') {
                        //We need to download and store the image
                        $urlLink = $this->downloadAndStoreMedia($value['messages'][0]['image']['id'], '.jpg');
                        $caption = $value['messages'][0]['image']['caption'] ?? '';
                        $message = $contact->sendMessage($caption, $urlLink, true, false, 'IMAGE', $messageID);
                    } elseif ($type == 'audio') {
                        // We need to download and store the audio
                        $urlLink = $this->downloadAndStoreMedia($value['messages'][0]['audio']['id'], '.mp3');
                        $message = $contact->sendMessage('', $urlLink, true, false, 'AUDIO', $messageID);
                    } elseif ($type == 'video') {
                        //We need to download and store the video
                        $urlLink = $this->downloadAndStoreMedia($value['messages'][0]['video']['id'], '.mp4');
                        $caption = $value['messages'][0]['video']['caption'] ?? '';
                        $message = $contact->sendMessage($caption, $urlLink, true, false, 'VIDEO', $messageID);
                    } elseif ($type == 'document') {
                        //We need to download and store the video
                        $urlLink = $this->downloadAndStoreMedia($value['messages'][0]['document']['id'], '.pdf');
                        $caption = $value['messages'][0]['document']['caption'] ?? '';
                        $message = $contact->sendMessage($caption, $urlLink, true, false, 'DOCUMENT', $messageID);
                    } elseif ($type == 'text') {
                        $message = $value['messages'][0]['text']['body'];

                        //Store the message
                        $message = $contact->sendMessage($message, '', true, false, 'TEXT', $messageID);
                    } elseif ($type == 'button') {
                        $payload = $value['messages'][0]['button']['payload'] ?? null;

                        $messageContent = $payload;
                        //Store the message
                        $replyType = 'button_reply';
                        $message = $contact->sendMessage($messageContent, '', true, false, 'TEXT', $messageID);
                    } elseif ($type == 'interactive') {
                        if ($value['messages'][0]['interactive']['type'] == 'button_reply') {
                            $messageContent = $value['messages'][0]['interactive']['button_reply']['title'];
                            //Store the message
                            $replyType = 'button_reply';
                            $message = $contact->sendMessage($messageContent, '', true, false, 'TEXT', $messageID, $value['messages'][0]['interactive']['button_reply']['id'], $replyType);
                            try {
                                //Send the button reply ID to the bot
                                $messageButtonID = $value['messages'][0]['interactive']['button_reply']['id'];
                                $contact->botReply($messageButtonID, $message);
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                        } elseif ($value['messages'][0]['interactive']['type'] == 'list_reply') {
                            $messageContent = $value['messages'][0]['interactive']['list_reply']['title'];

                            //Store the message
                            $replyType = 'list_reply';
                            $message = $contact->sendMessage($messageContent, '', true, false, 'TEXT', $messageID, $value['messages'][0]['interactive']['list_reply']['id'], $replyType);

                            try {
                                //Send the button reply ID to the bot
                                //   $messageButtonID = $value['messages'][0]['interactive']['list_reply']['id'];
                                //  $contact->botReplyList($messageButtonID, $message);
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                        } elseif ($value['messages'][0]['interactive']['type'] == 'nfm_reply') {
                            $responseRefID = $value['messages'][0]['context']['id'] ?? null;
                            // if (isset($responseData['wa_flow_response_params']['flow_name']) && isset($responseData['wa_flow_response_params']['flow_id'])) {
                            // $messageContent = __('WhatsApp Flow submission - Flow Name: ') . $responseData['wa_flow_response_params']['flow_name'];

                            if ($responseRefID) {
                                $message = Message::where('fb_message_id', $responseRefID)->first();

                                if ($message && !empty($message->buttons)) {
                                    //  $buttons = $message->buttons;
                                    $buttons = json_decode($message->buttons, true);
                                    $flowId = null;

                                    if (is_array($buttons)) {
                                        foreach ($buttons as $button) {
                                            if (isset($button['type']) && $button['type'] === 'FLOW') {
                                                $flowId = $button['flow_id'] ?? null;
                                                break;
                                            }
                                        }
                                    }

                                    if ($flowId) {
                                        $responseJson = $value['messages'][0]['interactive']['nfm_reply']['response_json'];
                                        $responseData = json_decode($responseJson, true);
                                        $messageContent = '';

                                        $message = $contact->sendMessage($messageContent, '', true, false, 'TEXT', $messageID, $flowId, 'nfm_reply', $responseData);
                                    }
                                }
                            }
                        }
                    } elseif ($type == 'contacts' || $type == 'contact') {
                        $message = $contact->sendMessage(__('Contact message is sent. But the message format is unsupported'), true, false, 'TEXT', $messageID);
                    } elseif ($type == 'location') {
                        //return response()->json(['send' => "Location"]);
                        $message = 'https://www.google.com/maps?q=' . $value['messages'][0]['location']['latitude'] . ',' . $value['messages'][0]['location']['longitude'];
                        //Store the message
                        $message = $contact->sendMessage($message, true, false, 'LOCATION', $messageID);
                    } elseif ($type == 'button') {
                        $message = $value['messages'][0]['button']['text'];
                        //Store the message
                        $message = $contact->sendMessage($message, true, false, 'TEXT', $messageID);
                    }
                }

                return response()->json(['send' => true]);
            } catch (\Throwable $th) {
                return response()->json(['send' => false, 'error' => $th, 'data' => $request->all()]);
            }
        } else {
            return response()->json(['send' => false]);
        }
    }

    public function downloadAndStoreMedia($mediaID, $ext = '.jpg')
    {
        $url = self::$facebookAPI . $mediaID;
        $accessToken = $this->getToken();
        $company = $this->getCompany();
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->get($url);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);

            $responseImage = $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($content['url']);

            $fileContents = $responseImage->getBody()->getContents();

            // Define the local path where you want to save the downloaded file
            if (config('settings.use_s3_as_storage', false)) {
                //S3 - store per company
                $fileName = 'uploads/media/received/' . $company->id . '/' . $content['id'] . $ext;
                $path = Storage::disk('s3')->put($fileName, $fileContents, 'public');
                return Storage::disk('s3')->url($fileName);
            } else {
                //Regular
                $localPath = public_path('uploads/media/' . $content['id'] . $ext);
                file_put_contents($localPath, $fileContents);
                $url = config('app.url') . '/uploads/media/' . $content['id'] . $ext;
                return preg_replace('#(https?:\/\/[^\/]+)\/\/#', '$1/', $url);
            }
        } catch (\Exception $e) {
            dd($e);
            // Handle the exception
        }
    }

    public function verifyWebhook(Request $request, $tokenViaURL)
    {
        Log::info('verifyWebhook Raw Payload:', ['body' => $request->getContent()]);
        Log::info('Parsed Payload:', ['all' => $request->all()]);

        // Parse params from the webhook verification request
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        $token = PersonalAccessToken::findToken($token);
        if ($token) {
            // Token is valid
            // Proceed with the request handling
            // Check if a token and mode were sent
            if ($mode && $token) {
                // Check the mode and token sent are correct
                if ($mode === 'subscribe') {
                    $user = User::findOrFail($token->tokenable_id);
                    Auth::login($user);

                    try {
                        //Company
                        $company = $this->getCompany();
                        $company->setConfig('whatsapp_webhook_verified', 'yes');
                    } catch (\Throwable $th) {
                    }
                    // Respond with 200 OK and challenge token from the request
                    return response($challenge, 200);
                } else {
                    // Respond with '403 Forbidden' if verify tokens do not match
                    return response()->json([], 403);
                }
            }
        } else {
            return response()->json([], 403);
        }
    }

    /**
     * Upload a file to facebook and return the handle using the upload API
     */
    public function uploadDocumentToFacebook2($file)
    {
        //Upload a file to facebook and return the handle using the upload API
        $company = $this->getCompany();
        $facebook_app_id = $company->getConfig('facebook_app_id', '');
        $accessToken = $this->getToken();

        if (empty($facebook_app_id)) {
            if (config('services.meta_app_id') && config('services.meta_app_token')) {
                $facebook_app_id = env('META_APP_ID') ?? '';
                $accessToken = env('META_APP_TOKEN') ?? '';
            }
        }

        if (strlen($facebook_app_id) < 5) {
            throw new \Exception('Facebook App ID is not set. Please set it in the App Settings.');
        }

        $url = self::$facebookAPI . $facebook_app_id . '/media';
        $mediaURL = self::$facebookAPI . $facebook_app_id . '/uploads';

        // 'file_length' => $file->getSize(),
        //         'file_type' => $file->getMimeType(),
        //         'file_name' => $file->getClientOriginalName(),

        //Get an upload sessions id
        try {
            // First get an upload session ID
            $uploadSessionResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($mediaURL, [
                'file_length' => $file->size,
                'file_type' => $file->type,
                'file_name' => $file->name,
            ]);

            $fileURL = public_path($file->file);

            $uploadSession = json_decode($uploadSessionResponse->body(), true);

            if (!isset($uploadSession['id'])) {
                throw new \Exception('Failed to get upload session ID');
            }

            $uploadURL = self::$facebookAPI . $uploadSession['id'];

            // Now upload the actual file using the session ID
            $response = Http::withHeaders([
                'Authorization' => 'OAuth ' . $accessToken,
                'Content-Type' => 'application/json',
                'file_offset' => '0',
            ])
                ->withBody(file_get_contents($file->file), $file->type)
                ->post($uploadURL);

            $result = json_decode($response->body(), true);

            if (isset($result['h'])) {
                return $result['h']; // Return the handle
            }

            throw new \Exception('Failed to upload document');
        } catch (\Exception $e) {
            // Handle any errors

            \Log::error('Facebook document upload failed: ' . $e->getMessage());
            return null;
        }
    }

    private function uploadMediaToFacebookStep1($file, $fileSize, $mimeType)
    {
        $accessToken = getClientWhatsAppAccessToken(Auth::user()->client);

        $company = $this->getCompany();
        $facebook_app_id = $company->getConfig('facebook_app_id', '');
        $accessToken = $this->getToken();

        if (empty($facebook_app_id)) {
            if (config('services.meta_app_id') && config('services.meta_app_token')) {
                $facebook_app_id = env('META_APP_ID') ?? '';
                $accessToken = env('META_APP_TOKEN') ?? '';
            }
        }

        if (strlen($facebook_app_id) < 5) {
            throw new \Exception('Facebook App ID is not set. Please set it in the App Settings.');
        }

        /**
         * 🔹 Step 1: Normalize $file into a usable URL or path
         */
        if ($file instanceof \Illuminate\Database\Eloquent\Model) {
            // FileManager object case
            $fileUrl = $file->file ?? null;
            $fileSize = $file->size ?? $fileSize;
            $mimeType = $file->type ?? $mimeType;
        } elseif (is_string($file)) {
            $decoded = json_decode($file, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['file'])) {
                $fileUrl = $decoded['file'];
                $fileSize = $decoded['size'] ?? $fileSize;
                $mimeType = $decoded['type'] ?? $mimeType;
            } else {
                $fileUrl = $file;
            }
        } elseif (is_array($file) && isset($file['file'])) {
            $fileUrl = $file['file'];
            $fileSize = $file['size'] ?? $fileSize;
            $mimeType = $file['type'] ?? $mimeType;
        } else {
            throw new \Exception('Invalid file input given to uploadMediaToFacebookStep1: ' . print_r($file, true));
        }

        /**
         * 🔹 Step 2: Normalize MIME type
         */
        $mimeMap = [
            'pdf/pdf' => 'application/pdf',
            'jpg/jpg' => 'image/jpeg',
            'jpeg/jpeg' => 'image/jpeg',
            'png/png' => 'image/png',
        ];
        if (isset($mimeMap[strtolower($mimeType)])) {
            $mimeType = $mimeMap[strtolower($mimeType)];
        }

        /**
         * 🔹 Step 3: Fetch file contents (local or remote)
         */
        if (filter_var($fileUrl, FILTER_VALIDATE_URL)) {
            $fileContents = file_get_contents($fileUrl);
            if ($fileContents === false) {
                throw new \Exception("Failed to fetch remote file from URL: {$fileUrl}");
            }
        } elseif (file_exists($fileUrl)) {
            $fileContents = file_get_contents($fileUrl);
        } else {
            throw new \Exception("File not found: {$fileUrl}");
        }

        /**
         * 🔹 Step 4: Upload to Facebook
         */
        $apiUrl = self::$facebookAPI . "{$facebook_app_id}/uploads?file_length={$fileSize}&file_type={$mimeType}&access_token={$accessToken}";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fileContents,
            CURLOPT_HTTPHEADER => ['Content-Type: ' . $mimeType],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        // 🔹 Step 5: Parse response
        $responseArray = json_decode($response, true);
        if (isset($responseArray['id'])) {
            return $responseArray['id'];
        } else {
            throw new \Exception('Failed to upload file to Facebook: ' . $response);
        }
    }

    private function uploadMediaToFacebookStep2($fileUrl, $session_id)
    {
        $accessToken = $this->getToken();
        $apiUrl = self::$facebookAPI . "{$session_id}";

        // ✅ Detect remote URL vs local file
        if (filter_var($fileUrl, FILTER_VALIDATE_URL)) {
            // Remote file (e.g., S3 link)
            $fileContents = file_get_contents($fileUrl);
            if ($fileContents === false) {
                throw new \Exception("Failed to fetch remote file: {$fileUrl}");
            }
        } elseif (file_exists($fileUrl)) {
            // Local file on disk
            $fileContents = file_get_contents($fileUrl);
        } else {
            // Not a valid URL and not a local file
            throw new \Exception("Invalid file path or URL: {$fileUrl}");
        }

        // ✅ Upload to Facebook
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fileContents,
            CURLOPT_HTTPHEADER => ['Authorization: OAuth ' . $accessToken, 'file_offset: 0', 'Content-Type: application/octet-stream'],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $responseArray = json_decode($response, true);

        if (isset($responseArray['h'])) {
            return $responseArray['h']; // Facebook handle
        }

        throw new \Exception('Facebook upload failed: ' . $response);
    }

    private function uploadDocumentToFacebook($file)
    {
        $fileURL = public_path($file->file);
        if (config('settings.use_s3_as_storage', false)) {
            $fileURL = $file->file;
        }

        $fileSize = $file->size;
        $mimeType = $file->type;
        $session_id = $this->uploadMediaToFacebookStep1($file, $fileSize, $mimeType);
        if (empty($session_id)) {
            return null;
        }

        $media = $this->uploadMediaToFacebookStep2($fileURL, $session_id);
        if (empty($media)) {
            return null;
        }
        return $media;
    }

    public function submitWhatsAppTemplate($templateData)
    {
        $company = $this->getCompany();
        $url = self::$facebookAPI . $this->getAccountID() . '/message_templates';
        $accessToken = $this->getToken();
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, $templateData);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);
            return ['status' => $statusCode, 'content' => $content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status' => 500, 'content' => $e->getMessage()];
        }
    }

    public function updateReadResponse($message_id)
    {
        if (!empty($message_id)) {
            $url = self::$facebookAPI . $this->getPhoneID() . '/messages';
            $accessToken = $this->getToken();
            $postData = [
                'messaging_product' => 'whatsapp', // Fixed typo: "messaging" not "messaging"
                'status' => 'read',
                'message_id' => $message_id,
            ];

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])->post($url, $postData);

                $statusCode = $response->status();
                $content = json_decode($response->body(), true);
                return ['status' => $statusCode, 'content' => $content];
            } catch (\Exception $e) {
                // Handle the exception
                return ['status' => 500, 'content' => $e->getMessage()];
            }
        }
    }

    public function deleteWhatsAppTemplate($templateName)
    {
        $company = $this->getCompany();
        $url = self::$facebookAPI . $this->getAccountID() . '/message_templates?name=' . $templateName;
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Please log in first.');
        }

        $connection = FacebookAppConnection::with(['metaBusinessAccounts', 'metaAccounts'])
            ->where('company_id', $user->company->id)
            ->first();
        
        if (!$connection) {
            return redirect()->back()->withErrors('Facebook App Connection is missing.');
        }

        $token = $connection->long_lived_token;

        $accessToken = $token;
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

    public function loadTemplatesFromWhatsApp($after = '')
    {
        $url = self::$facebookAPI . $this->getAccountID() . '/message_templates';
        $queryParams = [
            'fields' => 'name,category,language,quality_score,components,status',
            'limit' => 100,
        ];
        if ($after != '') {
            $queryParams['after'] = $after;
        }
        $headers = [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ];

        $response = Http::withHeaders($headers)->get($url, $queryParams);

        // Handle the response here
        if ($response->successful()) {
            $responseData = $response->json();

            //On success - remove all previous templates, if on initial call
            if ($after == '') {
                Template::query()->each(function ($model) {
                    try {
                        $model->delete();
                    } catch (\Throwable $th) {
                    }
                });
            }

            $companyID = $this->getCompany()->id;
            // foreach ($responseData['data'] as $key => $template) {
            //     //Insert new messages
            //     try {
            //         $data = [
            //             'name' => $template['name'],
            //             'category' => $template['category'],
            //             'language' => $template['language'],
            //             'status' => $template['status'],
            //             'id' => $template['id'],
            //             'company_id' => $companyID,
            //             'components' => json_encode($template['components']),
            //             'type'=> $template['components']['type'] ? ($template['components']['type'] == 'CARASOUL' ?? 1) : ''
            //         ];
            //         $template = Template::upsert($data, 'id', ['components', 'status']);
            //     } catch (\Throwable $th) {
            //         //throw $th;
            //         //dd($th);
            //     }
            // }

            foreach ($responseData['data'] as $key => $template) {
                try {
                    // default type = 0
                    $type = 0;

                    // loop through components to check CAROUSEL
                    if (!empty($template['components'])) {
                        foreach ($template['components'] as $component) {
                            if (isset($component['type']) && $component['type'] === 'CAROUSEL') {
                                $type = 1;
                                break;
                            }
                        }
                    }

                    $data = [
                        'name' => $template['name'],
                        'category' => $template['category'],
                        'language' => $template['language'],
                        'status' => $template['status'],
                        'id' => $template['id'],
                        'company_id' => $companyID,
                        'components' => json_encode($template['components']),
                        'type' => $type,
                    ];

                    Template::upsert($data, 'id', ['components', 'status', 'type']);
                } catch (\Throwable $th) {
                    // log or handle error
                    // dd($th);
                }
            }

            //Check if we have more templates
            if ($responseData['paging'] && isset($responseData['paging']['next']) && isset($responseData['paging']['cursors']['after'])) {
                return $this->loadTemplatesFromWhatsApp($responseData['paging']['cursors']['after']);
            } else {
                return true;
            }

            // Process $responseData as needed
        } else {
            // Handle error response
            return false;
        }
    }

    public function sendMessageToWhatsApp(Message $message, $contact)
    {
        $url = self::$facebookAPI . $this->getPhoneID() . '/messages';
        $accessToken = $this->getToken();

        if (strlen($accessToken) > 5) {
            try {
                $dataToSend = [
                    'messaging_product' => 'whatsapp',
                    'to' => $contact->phone,
                ];

                // if buttons exist → Interactive
                if (strlen($message->buttons) > 2) {
                    $dataToSend['type'] = 'interactive';
                    $dataToSend['interactive'] = [
                        'type' => 'button', // default interactive type
                    ];

                    // Body
                    if (strlen($message->value) > 0) {
                        $dataToSend['interactive']['body'] = [
                            'text' => $message->value,
                        ];
                    }

                    // Header text/image/video/document
                    if (strlen($message->header_text) > 0) {
                        $dataToSend['interactive']['header'] = [
                            'type' => 'text',
                            'text' => $message->header_text,
                        ];
                    } elseif (strlen($message->header_image) > 0) {
                        $dataToSend['interactive']['header'] = [
                            'type' => 'image',
                            'image' => ['link' => $message->header_image],
                        ];
                    } elseif (strlen($message->header_video) > 0) {
                        $dataToSend['interactive']['header'] = [
                            'type' => 'video',
                            'video' => ['link' => $message->header_video],
                        ];
                    } elseif (strlen($message->header_document) > 0) {
                        $filename = $message->file_name ?: basename($message->header_document);
                        $dataToSend['interactive']['header'] = [
                            'type' => 'document',
                            'document' => [
                                'link' => $message->header_document,
                                'filename' => $filename,
                            ],
                        ];
                    }

                    // Footer
                    if (strlen($message->footer_text) > 0) {
                        $dataToSend['interactive']['footer'] = [
                            'text' => $message->footer_text,
                        ];
                    }

                    // Action buttons
                    $buttonsData = json_decode($message->buttons, true);
                    if ($message->out_message_type == 2) {
                        // Normal buttons
                        $dataToSend['interactive']['type'] = 'button';
                        $dataToSend['interactive']['action']['buttons'] = $buttonsData;
                    } elseif ($message->out_message_type == 3) {
                        // List message
                        $dataToSend['interactive']['type'] = 'list';
                        $dataToSend['interactive']['action']['button'] = $buttonsData[0]['reply']['title'] ?? 'Menu';
                        $dataToSend['interactive']['action']['sections'] = array_values(json_decode($message->list_section_data, true));
                    }
                }

                // If NO buttons → send as normal text/media
                else {
                    if (strlen($message->header_image) > 0) {
                        // Image with optional caption
                        $dataToSend['type'] = 'image';
                        $dataToSend['image'] = [
                            'link' => $message->header_image,
                        ];
                        if (strlen($message->value) > 0) {
                            $dataToSend['image']['caption'] = $message->value;
                        }
                    } elseif (strlen($message->header_video) > 0) {
                        // Video with optional caption
                        $dataToSend['type'] = 'video';
                        $dataToSend['video'] = [
                            'link' => $message->header_video,
                        ];
                        if (strlen($message->value) > 0) {
                            $dataToSend['video']['caption'] = $message->value;
                        }
                    } elseif (strlen($message->header_document) > 0) {
                        // Document with optional caption
                        $filename = $message->file_name ?: basename($message->header_document);
                        $dataToSend['type'] = 'document';
                        $dataToSend['document'] = [
                            'link' => $message->header_document,
                            'filename' => $filename,
                        ];
                        if (strlen($message->value) > 0) {
                            $dataToSend['document']['caption'] = $message->value;
                        }
                    } elseif (strlen($message->value) > 0) {
                        // Just plain text
                        $dataToSend['type'] = 'text';
                        $dataToSend['text'] = [
                            'body' => $message->value,
                            'preview_url' => true,
                        ];
                    }
                }

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])->post($url, $dataToSend);

                $statusCode = $response->status();
                $content = json_decode($response->body(), true);

                if (isset($content['error'])) {
                    $message->error = $content['error']['message'];
                    $message->update();
                } else {
                    $message->fb_message_id = $content['messages'][0]['id'];
                    $message->update();
                }
            } catch (\Exception $e) {
                if (config('app.debug', false)) {
                    dd($e);
                }
            }
        }
    }

    public function handleCTWAReferral($messageData, $contact, $company)
    {
        // Ensure referral exists
        if (!isset($messageData['referral'])) {
            return response()->json(['send' => false, 'message' => 'No referral found']);
        }

        $referral = $messageData['referral'];
        $phone = $messageData['from'];
        $messageID = $messageData['id'];

        $adId = $referral['ad_id'] ?? null;
        $sourceUrl = $referral['source_url'] ?? null;
        $headline = $referral['headline'] ?? '';
        $body = $referral['body'] ?? '';
        $mediaUrl = $referral['media_url'] ?? null;
        $messageText = $messageData['text']['body'] ?? '';

        try {
            if ($mediaUrl) {
                $caption = trim("<h4 class='text-gray-900'>$headline</h4>\n$body");
                $contact->sendMessage($caption, $mediaUrl, true, false, 'IMAGE', '');
                $contact->sendMessage($messageText, '', true, false, 'TEXT', $messageID);
            } else {
                $textMessage = "Ad ID: $adId\n\n$headline\n\n$body";
                $contact->sendMessage($textMessage, '', true, false, 'TEXT');
                $contact->sendMessage($messageText, '', true, false, 'TEXT', $messageID);
            }

            CTWAReferral::create([
                'phone' => $phone,
                'ad_id' => $adId,
                'source_url' => $sourceUrl,
                'headline' => $headline,
                'body' => $body,
                'media_url' => $mediaUrl,
                'company_id' => $company->id,
            ]);

            return response()->json(['send' => true, 'message' => 'CTWA referral processed']);
        } catch (\Exception $e) {
            // \Log::error('CTWA Referral Processing Error:', ['error' => $e->getMessage()]);
            return response()->json(['send' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Check if a URL is an image based on its extension.
     */
    private function isImage($url)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $imageExtensions);
    }

    private function sendWhatsAppMessage($phone, $message, $company)
    {
        // dd($company->getPhoneID());
        $url = self::$facebookAPI . $company->getPhoneID() . '/messages';
        $accessToken = $company->getToken();

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'text',
            'text' => ['body' => $message],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        $statusCode = $response->status();
        $content = json_decode($response->body(), true);
        //If error

        if (isset($content['error'])) {
            $message->error = $content['error']['message'];
            $message->update();
        } else {
            $message->fb_message_id = $content['messages'][0]['id'];
            $message->update();
        }

        //Log::info("WhatsApp Response: ", $response->json());
    }

    public function sendWhatsAppCatalogMessage($message, $contact)
    {
        $company = $this->getCompany();
        $Paymenttemplate = Paymenttemplate::where('company_id', $company->id)->first();
        $url = self::$facebookAPI . $this->getPhoneID() . '/messages';
        $accessToken = $this->getToken();
        $ProductCategory = ProductCategory::where('company_id', $company->id)->get();
        $rows = [];
        foreach ($ProductCategory as $category) {
            $rows[] = [
                'id' => 'category_' . $category->id,
                'title' => $category->name,
            ];
        }

        if (strlen($accessToken) > 5) {
            try {
                if (count($ProductCategory) > 1) {
                    $dataToSend = [
                        'messaging_product' => 'whatsapp',
                        'recipient_type' => 'individual',
                        'to' => $contact->phone,
                        'type' => 'interactive',
                        'interactive' => [
                            'type' => 'list',
                            'header' => [
                                'type' => 'text',
                                'text' => $message->header_text ?? 'Our Product Catalog',
                            ],
                            'body' => [
                                'text' => $message->value,
                            ],
                            'action' => [
                                'button' => 'Menu Options',
                                'sections' => [
                                    [
                                        'title' => 'Product Categories',
                                        'rows' => $rows,
                                    ],
                                ],
                            ],
                        ],
                    ];
                } else {
                    $dataToSend = [
                        'messaging_product' => 'whatsapp',
                        'to' => $contact->phone,
                        'type' => 'interactive',
                        'interactive' => [
                            'type' => 'catalog_message',
                            'body' => [
                                'text' => $message->value,
                            ],
                            'action' => [
                                'name' => 'catalog_message',
                                'parameters' => [
                                    'thumbnail_product_retailer_id' => $Paymenttemplate->product_id ?? 0,
                                ],
                            ],
                            'footer' => [
                                'text' => $message->footer_text,
                            ],
                        ],
                    ];
                }
                // Additional conditional logic for other message types
                if (isset($message->type) && $message->type === 'text') {
                    $dataToSend['type'] = 'text';
                    $dataToSend['text'] = [
                        'body' => $message->value,
                        'preview_url' => true,
                    ];
                } elseif (isset($message->type) && $message->type === 'image') {
                    $dataToSend['type'] = 'image';
                    $dataToSend['image'] = [
                        'link' => $message->header_image,
                    ];
                } elseif (isset($message->type) && $message->type === 'video') {
                    $dataToSend['type'] = 'video';
                    $dataToSend['video'] = [
                        'link' => $message->header_video,
                    ];
                } elseif (isset($message->type) && $message->type === 'document') {
                    $path = parse_url($message->header_document, PHP_URL_PATH);
                    $filename = pathinfo($path, PATHINFO_FILENAME);
                    $dataToSend['type'] = 'document';
                    $dataToSend['document'] = [
                        'link' => $message->header_document,
                        'filename' => $filename,
                    ];
                }

                // Send the HTTP POST request
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])->post($url, $dataToSend);

                $statusCode = $response->status();
                $content = json_decode($response->body(), true);

                if (isset($content['error'])) {
                    $message->error = $content['error']['message'];
                    $message->update();
                } else {
                    $message->fb_message_id = $content['messages'][0]['id'];
                    $message->update();
                }

                return $content;
            } catch (\Exception $e) {
                if (config('app.debug', false)) {
                    dd($e);
                }
            }
        }

        return null;
    }

    public function sendWithTypingIndicator($messageID)
    {
        $company = $this->getCompany();
        $accessToken = $this->getToken();
        $accountId = $this->getPhoneID($company);

        $url = self::$facebookAPI . $accountId . '/messages'; // or a custom URL if needed

        $payload = [
            'messaging_product' => 'whatsapp',
            'status' => 'read',
            'message_id' => $messageID,
            'typing_indicator' => [
                'type' => 'text',
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            return response()->json([
                'success' => $response->successful(),
                'response' => $response->json(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
