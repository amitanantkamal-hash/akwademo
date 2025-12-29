<?php

namespace Modules\Wpbox\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Wpbox\Models\Contact;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;
use Modules\Wpbox\Traits\Contacts;
use Carbon\Carbon;
use Closure;
use Modules\Contacts\Models\Group;
use Modules\Wpbox\Models\Message;
use Modules\Wpbox\Models\Reply;
use Illuminate\Support\Facades\Storage;
use Modules\Contacts\Models\Field;

class APIController extends Controller
{
    use Contacts;
    use Whatsapp;
    //Send message to phone number
    public function sendMessageToPhoneNumber(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                //Company
                $company = $this->getCompany();
                
                //Make or get the contact
                $contact = $this->getOrMakeContact($request->phone, $company, $request->phone);
                
                //If request has buttons
                if ($request->has('buttons') || $request->has('header') || $request->has('footer')) {
                    
                    $header_text = '';
                    if ($request->has('header')) {
                        $header_text = $request->header;
                    }
                    $footer_text = '';
                    if ($request->has('footer')) {
                        $footer_text = $request->footer;
                    }
                    // Make Replay object
                    $replay = new Reply([
                        'trigger' => 'none',
                        'header_type' => 1,
                        'text' => $request->message,
                        'company_id' => $company->id,
                        'header' => $header_text,
                        'footer' => $footer_text,
                    ]);
                    
                    //In the $reply we have button1, button1_id. Assign them from $buttons
                    if ($request->has('buttons')) {
                        
                        foreach ($request->buttons as $key => $button) {
                            if ($key < 3) {
                                $replay['button' . ($key + 1)] = $button['title'];
                                $replay['button' . ($key + 1) . '_id'] = $button['id'];
                            }
                        }
                        
                    }
                    $message = $contact->sendReply($replay);
                    
                } elseif ($request->has('image')) {
                    
                    $caption = $request->caption ?? '';
                    //Image message
                    $imageUrl = '';
                    if (config('settings.use_s3_as_storage', false)) {
                        //S3 - store per company
                        $path = $request->image->storePublicly('uploads/media/send/' . $contact->company_id, 's3');
                        $imageUrl = Storage::disk('s3')->url($path);
                    } else {
                        //Regular
                        $path = $request->image->store(null, 'public_media_upload');
                        $imageUrl = Storage::disk('public_media_upload')->url($path);
                    }
                    $fileType = $request->file('image')->getMimeType();
                    if (str_contains($fileType, 'image')) {
                        // It's an image
                        $messageType = 'IMAGE';
                    } elseif (str_contains($fileType, 'video')) {
                        // It's a video
                        $messageType = 'VIDEO';
                    } elseif (str_contains($fileType, 'audio')) {
                        // It's audio
                        $messageType = 'VIDEO';
                    } else {
                        // Handle other types or show an error message
                        $messageType = 'IMAGE';
                    }
                    
                    $message = $contact->sendMessage($caption, $imageUrl, false, false, $messageType);
                } else {
                    
                    //Just message
                    $message = $contact->sendMessage($request->message, '', false);
                }
                return response()->json(['status' => 'success', 'message_id' => $message->id, 'message_wamid' => $message->fb_message_id]);
            },
            [ 
                'token' => 'required',
                'phone' => 'required',
                //'message' => 'required',
            ],
        );
    }

    public function sendTemplateMessageToPhoneNumber(Request $request)
    {

        return $this->authenticate(
            $request,
            function ($request) {

                $company = $this->getCompany();


                $contact = $this->getOrMakeContact($request->phone, $company, $request->phone);

                $template = Template::where('company_id', $company->id)->where('name', $request->template_name)->where('language', $request->template_language)->firstOrFail();

                $campaign = Campaign::create([
                    'name' => 'api_message_' . now(),
                    'timestamp_for_delivery' => null,
                    'variables' => '',
                    'variables_match' => '',
                    'template_id' => $template->id,
                    'group_id' => null,
                    'contact_id' => $contact->id,
                    'total_contacts' => Contact::count(),
                ]);

                $processedData = $this->processTemplateComponents($template, $request);
                $messageData = $this->prepareMessageData($contact, $campaign, $processedData);

                $message = Message::create($messageData);
                $this->sendCampaignMessageToWhatsApp($message);

                return response()->json([
                    'status' => 'success',
                    'message_id' => $message->id,
                    'message_wamid' => $message->fb_message_id,
                ]);
            },
            [
                'token' => 'required',
                'phone' => 'required',
                'template_name' => 'required',
                'template_language' => 'required',
                'components' => 'array',
            ],
        );
    }

    private function processTemplateComponents($template, $request)
    {
        $result = [
            'bodyText' => '',
            'footer' => '',
            'header_text' => '',
            'headerIMG' => '',
            'headerVideo' => '',
            'headerPDF' => '',
            'headerFileName' => '',
            'components' => [],
            'otpCode' => null,
            'flowType' => false,
        ];

        $templateComponents = json_decode($template->components, true) ?: [];
        foreach ($templateComponents as $component) {
            switch ($component['type']) {
                case 'BODY':
                    $result['bodyText'] = $component['text'] ?? '';
                    break;
                case 'FOOTER':
                    $result['footer'] = $component['text'] ?? '';
                    break;
                case 'HEADER':
                    if ($component['format'] == 'TEXT') {
                        $result['header_text'] = $component['text'] ?? '';
                    }
                    break;
            }
        }

        $this->processRequestComponents($request, $result, $templateComponents);

        return $result;
    }

    private function processRequestComponents($request, &$result, $templateComponents)
    {
        foreach ($request->components as $component) {
            if ($component['type'] === 'otp' && isset($component['otp']['code'])) {
                $result['otpCode'] = $component['otp']['code'];
            }
            if ($component['type'] === 'flow') {
                $result['flowType'] = true;
            }
        }

        if ($result['otpCode']) {
            $this->processOtpMessage($request, $result, $templateComponents);
        } elseif ($result['flowType']) {
            $this->processFlowMessage($request, $result, $templateComponents);
        } else {
            $this->processRegularMessage($request, $result);
        }
    }

    private function processRegularMessage($request, &$result)
    {
        $components = [];

        foreach ($request->components as $component) {
            $type = strtoupper($component['type']);
            $params = $component['parameters'] ?? [];

            switch ($type) {
                case 'HEADER':
                    $media = $this->extractHeaderMedia($params);

                    if ($media) {
                        $components[] = $media['component'];

                        switch ($media['type']) {
                            case 'image':
                                $result['headerIMG'] = $media['link'];
                                break;
                            case 'video':
                                $result['headerVideo'] = $media['link'];
                                break;
                            case 'document':
                                $result['headerPDF'] = $media['link'];
                                $result['headerFileName'] = $media['filename'];
                                break;
                        }
                    }
                    break;

                case 'BODY':
                    $bodyParams = $this->processBodyParameters($params);
                    if ($bodyParams) {
                        $components[] = [
                            'type' => 'BODY',
                            'parameters' => $bodyParams,
                        ];
                    }
                    break;

                case 'BUTTON':
                    $buttonParams = $this->processButtonParameters($params);
                    if ($buttonParams) {
                        $components[] = [
                            'type' => 'button',
                            'sub_type' => $component['sub_type'] ?? 'url',
                            'index' => $component['index'] ?? '0',
                            'parameters' => $buttonParams,
                        ];
                    }
                    break;
            }
        }

        $result['components'] = $components;
    }

    private function processFlowMessage($request, &$result, $templateComponents)
    {
        foreach ($request->components as $component) {
            if ($component['type'] === 'header' && isset($component['parameters'])) {
                foreach ($component['parameters'] as $param) {
                    if ($param['type'] === 'image' && isset($param['image']['link'])) {
                        $result['headerIMG'] = $param['image']['link'];
                    }
                }
            }
        }

        $bodyText = $result['bodyText'];
        foreach ($request->components as $component) {
            if ($component['type'] === 'body' && isset($component['parameters'])) {
                foreach ($component['parameters'] as $index => $param) {
                    $placeholder = '{{ ' . ($index + 1) . ' }}';
                    $bodyText = str_replace($placeholder, $param['text'], $bodyText);
                }
            }
        }
        $result['bodyText'] = $bodyText;

        $result['components'] = [
            [
                'type' => 'HEADER',
                'parameters' => [
                    [
                        'type' => 'image',
                        'image' => ['link' => $result['headerIMG']],
                    ],
                ],
            ],
            [
                'type' => 'button',
                'sub_type' => 'flow',
                'index' => '0',
                'parameters' => [],
            ],
        ];
    }

    private function processOtpMessage($request, &$result, $templateComponents)
    {
        // Get OTP code (from request body or from $result['otpCode'])
        $otpCode = null;

        foreach ($request->components as $component) {
            if (strtoupper($component['type']) === 'BODY' && isset($component['parameters'][0]['text'])) {
                $otpCode = $component['parameters'][0]['text'];
                break;
            }
        }

        if (!$otpCode && isset($result['otpCode'])) {
            $otpCode = $result['otpCode'];
        }

        $result['components'] = [
            [
                'type' => 'BODY',
                'parameters' => [
                    ['type' => 'text', 'text' => $otpCode]
                ],
            ],
            [
                'type' => 'button',
                'sub_type' => 'url',
                'index' => '0',
                'parameters' => [
                    ['type' => 'text', 'text' => $otpCode]
                ],
            ],
        ];
    }


    private function extractHeaderMedia($parameters)
    {
        if (empty($parameters)) {
            return null;
        }

        $firstParam = $parameters[0];
        $mediaType = null;
        $mediaLink = null;
        $filename = null;

        if (isset($firstParam['image']['link'])) {
            $mediaType = 'image';
            $mediaLink = $firstParam['image']['link'];
        } elseif (isset($firstParam['video']['link'])) {
            $mediaType = 'video';
            $mediaLink = $firstParam['video']['link'];
        } elseif (isset($firstParam['document']['link'])) {
            $mediaType = 'document';
            $mediaLink = $firstParam['document']['link'];
            $filename = $firstParam['document']['filename'] ?? '';
        }

        if (!$mediaType) {
            return null;
        }

        if ($mediaType == 'document') {
            return [
                'type' => $mediaType,
                'component' => [
                    'type' => 'HEADER',
                    'parameters' => [
                        [
                            'type' => $mediaType,
                            $mediaType => [
                                'link' => $mediaLink,
                                'filename' => $filename,
                            ],
                        ],
                    ],
                ],
                'link' => $mediaLink,
                'filename' => $filename,
            ];
        } else {
            return [
                'type' => $mediaType,
                'component' => [
                    'type' => 'HEADER',
                    'parameters' => [
                        [
                            'type' => $mediaType,
                            $mediaType => [
                                'link' => $mediaLink,
                            ],
                        ],
                    ],
                ],
                'link' => $mediaLink,
                'filename' => $filename,
            ];
        }
    }

    private function processBodyParameters($parameters)
    {
        $bodyParams = [];
        foreach ($parameters as $param) {
            if ($param['type'] === 'text' && isset($param['text'])) {
                $bodyParams[] = ['type' => 'text', 'text' => $param['text']];
            }
        }
        return $bodyParams;
    }

    private function processButtonParameters($parameters)
    {
        $buttonParams = [];
        foreach ($parameters as $param) {
            if ($param['type'] === 'text' && isset($param['text'])) {
                $buttonParams[] = [
                    'type' => 'text',
                    'text' => $param['text']
                ];
            } elseif ($param['type'] === 'coupon_code' && isset($param['coupon_code'])) {
                $buttonParams[] = [
                    'type' => 'coupon_code',
                    'coupon_code' => $param['coupon_code']
                ];
            }
        }
        return $buttonParams;
    }


    private function prepareMessageData($contact, $campaign, $processedData)
    {
        return [
            'contact_id' => $contact->id,
            'company_id' => $contact->company_id,
            'value' => $processedData['bodyText'],
            'header_image' => $processedData['headerIMG'],
            'header_video' => $processedData['headerVideo'],
            'header_audio' => '',
            'header_document' => $processedData['headerPDF'],
            'file_name' => $processedData['headerFileName'],
            'footer_text' => $processedData['footer'],
            'buttons' => '',
            'header_text' => $processedData['header_text'],
            'is_message_by_contact' => false,
            'is_campign_messages' => true,
            'status' => 0,
            'created_at' => now(),
            'scchuduled_at' => now(),
            'components' => json_encode($processedData['components']),
            'campaign_id' => $campaign->id,
        ];
    }

    //Get ot make contact  //Last Update by Brij 24Jun
    public function makeContact($name, $phone, $company)
    {
        $contact = Contact::where('company_id', $company->id)->where('phone', $phone)->first();
        if (!$contact) {
            $contact = Contact::create([
                'name' => $name ?? $phone,
                'phone' => $phone,
                'company_id' => $company->id,
            ]);
        }
        return $contact;
    }

    //Get templates
    public function getTemplates(Request $request)
    {
        return $this->authenticate($request, function ($request) {
            //Company
            $company = $this->getCompany();
            //Find the template based on the provided id
            $templates = Template::where('company_id', $company->id)->get();

            return response()->json(['status' => 'success', 'templates' => $templates]);
        });
    }

    //Send Campaign via API
    public function sendCampaignMessageToPhoneNumber(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                //Make or get the contact
                $contact = $this->getOrMakeContact($request->phone, $this->getCompany(), $request->phone);

                //All the passed data in request data, merge with the contact
                $contact['extra_value'] = $request->data;

                //Get the campaign
                $message = Campaign::findOrFail($request->campaing_id)->makeMessages(null, $contact);

                $this->sendCampaignMessageToWhatsApp($message);

                //Api responses
                return response()->json(['status' => 'success', 'message_id' => $message->id, 'message_wamid' => $message->fb_message_id]);
            },
            [
                'token' => 'required',
                'phone' => 'required',
                'campaing_id' => 'required',
            ],
        );
    }

    //Get groups
    public function getGroups(Request $request)
    {
        return $this->authenticate($request, function ($request) {
            //Company
            $company = $this->getCompany();
            if ($request->has('showContacts') && $request->showContacts == 'yes') {
                $groups = Group::where('company_id', $company->id)->with('contacts')->get();
            } else {
                $groups = Group::where('company_id', $company->id)->get();
            }

            return response()->json(['status' => 'success', 'groups' => $groups]);
        });
    }

    public function getCampaigns(Request $request)
    {
        return $this->authenticate($request, function ($request) {
            //Company
            $company = $this->getCompany();

            if ($request->has('type')) {
                if ($request->type == 'bot') {
                    $items = Campaign::where('company_id', $company->id)->where('is_bot', true)->get();
                } elseif ($request->type == 'api') {
                    $items = Campaign::where('company_id', $company->id)->where('is_api', true)->get();
                } elseif ($request->type == 'regular') {
                    $items = Campaign::where('company_id', $company->id)->where('is_api', false)->where('is_bot', false)->get();
                }
            } else {
                $items = Campaign::where('company_id', $company->id)->get();
            }

            return response()->json(['status' => 'success', 'items' => $items]);
        });
    }

    public function getContacts(Request $request)
    {
        return $this->authenticate($request, function ($request) {
            //Company
            $company = $this->getCompany();
            return response()->json(['status' => 'success', 'contacts' => Contact::where('company_id', $company->id)->get()]);
        });
    }

    public function getConversations(Request $request)
    {
        return $this->authenticate($request, function ($request) {
            //Company
            $company = $this->getCompany();
            $chatList = Contact::where('has_chat', 1)->where('company_id', $company->id)->orderBy('last_reply_at', 'DESC')->limit(150)->get();
            return response()->json([
                'data' => $chatList,
                'status' => true,
                'errMsg' => '',
            ]);
        });
    }

    public function getMessages(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                //Company
                $messages = Message::where('contact_id', $request->contact_id)->where('status', '>', 0)->orderBy('id', 'desc')->limit(100)->get();
                return response()->json([
                    'data' => $messages,
                    'status' => true,
                    'errMsg' => '',
                ]);
            },
            [
                'token' => 'required',
                'contact_id' => 'required',
            ],
        );
    }

    public function updateContact(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                //Company
                $company = $this->getCompany();
                $contact = Contact::findOrFail($request->id);
                $contact->update($request->all());
                return response()->json(['status' => 'success', 'contact' => $contact]);
            },
            [
                'id' => 'required',
            ],
        );
    }

    //Send Template     message to phone number
    public function contactApiMake(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                //Company
                $company = $this->getCompany();

                $contact = $this->makeContact($request->name, $request->phone, $company);

                //Update the contact
                $contact->update(['name' => $request->name]);

                //If there is a email
                if ($request->has('email')) {
                    $contact->update(['email' => $request->email]);
                }

                //If request has groups
                if ($request->has('groups')) {
                    // Attaching groups to the contact
                    $contact->groups()->sync([]);
                    // Groups are passed as string with comma
                    $groups = explode(',', $request->groups);

                    // Remove empty values from the array
                    $groups = array_filter($groups);

                    //Convert each group name into a group id
                    $groupIds = [];
                    foreach ($groups as $groupName) {
                        $groupId = Group::where('name', $groupName)->where('company_id', $company->id)->first();
                        if ($groupId) {
                            $groupIds[] = $groupId->id;
                        } else {
                            //Create a new group
                            $groupId = Group::create([
                                'name' => $groupName,
                                'company_id' => $company->id,
                            ]);
                            $groupIds[] = $groupId->id;
                        }
                    }

                    $contact->groups()->attach($groupIds);
                }

                //If request has custom fields
                if ($request->has('custom')) {
                    $contact->fields()->sync([]);
                    foreach ($request->custom as $key => $value) {
                        if ($value) {
                            //Find the custom field id
                            $fieldId = Field::where('name', $key)->where('company_id', $company->id)->first();
                            if ($fieldId) {
                                $contact->fields()->attach($fieldId->id, ['value' => $value]);
                            } else {
                                //Create a new custom field
                                $field = Field::create([
                                    'name' => $key,
                                    'company_id' => $company->id,
                                ]);
                                $contact->fields()->attach($field->id, ['value' => $value]);
                            }
                        }
                    }
                }
                $contact->update();
                $contact->load('groups', 'fields');
                return response()->json([
                    'status' => 'success',
                    'contact' => $contact,
                ]);
            },
            [
                'token' => 'required',
                'phone' => 'required',
            ],
        );
    }

    public function getCustomFields(Request $request) {}

    public function getSingleContact(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                //Company
                $company = $this->getCompany();

                if ($request->has('contact_id')) {
                    $contact = Contact::where('id', $request->contact_id)->where('company_id', $company->id)->firstOrFail();
                } elseif ($request->has('phone')) {
                    $contact = Contact::where('phone', $request->phone)->where('company_id', $company->id)->firstOrFail();
                }

                return response()->json(['status' => 'success', 'contact' => $contact]);
            },
            [
                'token' => 'required',
                'contact_id' => 'required_without:phone',
                'phone' => 'required_without:contact_id',
            ],
        );
    }

    private function authenticate(Request $request, Closure $next, $rules = ['token' => 'required'])
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                400,
            );
        }

        /*if (config('settings.is_demo')) {
            return response()->json([
                'status' => 'error',
                'errors' => "API is disabled in demo"
            ], 400);
        }*/

        //Authenticate the user, if there is no autnenticatedd user already
        if (!Auth::check()) {
            $token = PersonalAccessToken::findToken($request->token);
            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'Invalid token']);
            } else {
                $user = User::findOrFail($token->tokenable_id);
                Auth::login($user);
                return $next($request);
            }
        } else {
            //User is already authenticated, so just return the next
            return $next($request);
        }
    }

    public function info()
    {
        $token = PersonalAccessToken::where('tokenable_id', auth()->user()->id)
            ->where('tokenable_type', 'App\Models\User')
            ->first();
        $company = $this->getCompany();

        if (!$token || $company->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $company->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }
        //Get old config
        $planText = $company->getConfig('plain_token', '');
        return view('wpbox::api.info', ['token' => $planText, 'company' => $company]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }

        $items = Campaign::orderBy('id', 'desc')->whereNull('contact_id')->where('is_api', true);
        //Regular, bot ant template based bot

        $items = $items->paginate(10);
        
        $setup = [
            'usefilter' => null,
            'title' => __('API Campaigns'),
            'action_link' => route('campaigns.create', ['type' => 'api']),
            'action_name' => __('New API Campaign'),
            'action_icon' => '',
            'action_link2' => route('api.info'),
            'action_name2' => __('API Info'),
            'items' => $items,
            'item_names' => __('API Campaigns'),
            'webroute_path' => 'campaigns.',
            'fields' => [],
            'filterFields' => [],
            'custom_table' => true,
            'parameter_name' => 'campaigns',
            'parameters' => count($_GET) != 0,
            'hidePaging' => true,
        ];
        return view('wpbox::api.index', ['setup' => $setup]);
    }

    public function updateAIBot(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                // Company
                $company = $this->getCompany();

                // Validate request
                $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'enabled_ai_bot' => 'required|in:0,1',
                ]);

                if ($validator->fails()) {
                    return response()->json(
                        [
                            'status' => 'error',
                            'errors' => $validator->errors(),
                        ],
                        400,
                    );
                }

                // Find the contact
                $contact = Contact::where('id', $request->id)->where('company_id', $company->id)->first();

                if (!$contact) {
                    return response()->json(
                        [
                            'status' => 'error',
                            'message' => 'Contact not found',
                        ],
                        404,
                    );
                }

                // Update the AI bot status
                $contact->update([
                    'enabled_ai_bot' => $request->enabled_ai_bot,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'AI Bot status updated successfully',
                ]);
            },
            [
                'token' => 'required',
            ],
        );
    }

    public function getContactGroupsAndCustomFields(Contact $contact)
    {
        // Get the contact's groups with their details
        $groups = $contact->groups()->get();
        $customFields = $contact->fields->toArray();
        foreach ($customFields as $key => $fieldWithPivot) {
            $customFields[$key]['value'] = $fieldWithPivot['pivot']['value'];
        }
        return response()->json([
            'groups' => $groups,
            'customFields' => $customFields,
        ]);
    }

    public function getNotes(Contact $contact)
    {
        // Get all notes for the contact
        $notes = $contact->notes()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $notes,
        ]);
    }

    public function me(Request $request)
    {
        //return response()->json(['status'=>'success']);
        return $this->authenticate($request, function ($request) {
            return response()->json(['status' => 'success', 'user' => auth()->user()->id]);
        });
    }

    // Add these methods to your APIController
    // Add these to your APIController
    // In your APIController
    public function addTagToContact(Request $request)
    {
        // Get authenticated user
        $user = auth()->user();
        if (!$user) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Unauthenticated',
                ],
                401,
            );
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:contacts,id',
            'tag' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                400,
            );
        }

        try {
            // Find contact belonging to user's company
            $contact = Contact::where('id', $request->id)->where('company_id', $user->company_id)->first();

            if (!$contact) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Contact not found or not accessible',
                    ],
                    404,
                );
            }

            // Parse existing tags
            $currentTags = [];
            if ($contact->tags) {
                try {
                    // Try to parse as JSON array
                    $decoded = json_decode($contact->tags, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $currentTags = $decoded;
                    } else {
                        // Fallback to string processing
                        $cleaned = trim($contact->tags, '[]"');
                        $currentTags = array_filter(array_map('trim', explode(',', $cleaned)), function ($tag) {
                            return !empty($tag);
                        });
                    }
                } catch (\Exception $e) {
                    // Handle any parsing errors
                    $currentTags = [];
                }
            }

            // Add new tag if not exists
            $newTag = trim($request->tag);
            if (!in_array($newTag, $currentTags)) {
                $currentTags[] = $newTag;
                $contact->tags = json_encode($currentTags);
                $contact->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Tag added successfully',
                'contact' => $contact,
                'tags' => $currentTags,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Server error: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function removeTagFromContact(Request $request)
    {
        // Get authenticated user
        $user = auth()->user();
        if (!$user) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Unauthenticated',
                ],
                401,
            );
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:contacts,id',
            'tag' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                400,
            );
        }

        try {
            // Find contact belonging to user's company
            $contact = Contact::where('id', $request->id)->where('company_id', $user->company_id)->first();

            if (!$contact) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Contact not found or not accessible',
                    ],
                    404,
                );
            }

            // Parse existing tags
            $currentTags = [];
            if ($contact->tags) {
                try {
                    // Try to parse as JSON array
                    $decoded = json_decode($contact->tags, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $currentTags = $decoded;
                    } else {
                        // Fallback to string processing
                        $cleaned = trim($contact->tags, '[]"');
                        $currentTags = array_filter(array_map('trim', explode(',', $cleaned)), function ($tag) {
                            return !empty($tag);
                        });
                    }
                } catch (\Exception $e) {
                    // Handle any parsing errors
                    $currentTags = [];
                }
            }

            // Remove tag if exists
            $tagToRemove = trim($request->tag);
            $updatedTags = array_filter($currentTags, function ($t) use ($tagToRemove) {
                return $t !== $tagToRemove;
            });

            // Only update if tags changed
            if (count($currentTags) !== count($updatedTags)) {
                $contact->tags = json_encode(array_values($updatedTags));
                $contact->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Tag removed successfully',
                'contact' => $contact,
                'tags' => $updatedTags,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Server error: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function addGroupToContact(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                $contact = Contact::findOrFail($request->contact_id);
                $contact->groups()->attach($request->group_id);

                return response()->json(['status' => 'success']);
            },
            [
                'token' => 'required',
                'contact_id' => 'required',
                'group_id' => 'required',
            ],
        );
    }

    public function removeGroupFromContact(Request $request)
    {
        return $this->authenticate(
            $request,
            function ($request) {
                $contact = Contact::findOrFail($request->contact_id);
                $contact->groups()->detach($request->group_id);

                return response()->json(['status' => 'success']);
            },
            [
                'token' => 'required',
                'contact_id' => 'required',
                'group_id' => 'required',
            ],
        );
    }
    
    public function contactApiUpdate(Request $request)
{
    return $this->authenticate(
        $request,
        function ($request) {
            //Company
            $company = $this->getCompany();
            
            // Find contact - ensure it belongs to the company
            $contact = Contact::where('id', $request->id)
                ->where('company_id', $company->id)
                ->firstOrFail();
            
            // Validate only name and email fields
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|nullable|email|max:255',
            ]);
            
            // Update only if there are validated fields
            if (!empty($validatedData)) {
                $contact->update($validatedData);
            }
            
            return response()->json([
                'status' => 'success', 
                'message' => 'Contact updated successfully',
                'contact' => $contact
            ]);
        },
        [
            'token' => 'required',
            'id' => 'required|integer|exists:contacts,id',
        ]
    );
}
}
