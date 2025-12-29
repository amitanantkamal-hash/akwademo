<?php

namespace Modules\Wpbox\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Wpbox\Events\AgentReplies;
use Modules\Wpbox\Models\Contact;
use Modules\Wpbox\Models\Message;
use Illuminate\Support\Facades\Storage;
use Modules\Wpbox\Models\Reply;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;
use Illuminate\Support\Facades\Validator;
use Locale;
use Modules\Wpbox\Events\Chatlistchange;
use ResourceBundle;
use Akaunting\Module\Facade as Module;
use App\Models\Config;
use Illuminate\Support\Facades\Http;
use Modules\Contacts\Models\Group;

class ChatController extends Controller
{
    use Whatsapp;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }

        $templates = Template::where('status', 'APPROVED')->select('name', 'id', 'language')->get();
        $replies = Reply::where('type', 1)->where('flow_id', null)->get();
        $languages = explode(',', __('No translation') . ',' . config('wpbox.available_languages', 'English,Spanish,German,Italian,Portuguese,Dutch,French,Japanese,Chinese'));

        //Find the users of the company
        $users = $this->getCompany()->users()->pluck('name', 'id');
        $groups = Group::pluck('name', 'id');

        //Get all the modules where type is "link_fetcher"
        $fetcherModules = [];
        $sidebarModules = [];
        foreach (Module::all() as $key => $module) {
            if ($module->get('isLinkFetcher')) {
                try {
                    $fetcherModules[$module->get('alias')] = [
                        'name' => $this->getCompany()->getConfig($module->get('alias') . '_button_name', __('No name')),
                        'data' => app($module->get('namespace') . '\Main')->getData(),
                    ];
                } catch (\Exception $e) {
                    //Do nothing
                }
            }
            if ($module->get('hasSidebar')) {
                try {
                    foreach ($module->get('sidebarData') as $sidebarApp) {
                        $sidebarModules[] = [
                            'alias' => $sidebarApp['app'],
                            'name' => $sidebarApp['name'],
                            'brandColor' => $sidebarApp['brandColor'] ?? '#96588A',
                            'icon' => $sidebarApp['icon'],
                            'view' => $sidebarApp['view'],
                            'script' => $sidebarApp['script'],
                        ];
                    }
                } catch (\Exception $e) {
                    //Do nothing
                }
            }
        }

        $sidebarModules = collect($sidebarModules)
            ->filter(function ($module) {
                if ($module['alias'] === 'woolist') {
                    return !empty($this->getCompany()->getConfig('woocommerce_consumer_key')) && !empty($this->getCompany()->getConfig('woocommerce_consumer_secret'));
                }

                if ($module['alias'] === 'shopifylist') {
                    return !empty($this->getCompany()->getConfig('shopify_access_token'));
                }

                return true;
            })
            ->toArray();
            
        usort($sidebarModules, function ($a, $b) {
            if ($a['name'] === 'Contact') {
                return -1;
            }
            if ($b['name'] === 'Contact') {
                return 1;
            }
            return strcmp($a['name'], $b['name']);
        });

        // Return to view
        return view('wpbox::chat.master', [
            'company' => $this->getCompany(),
            'templates' => $templates->toArray(),
            'replies' => $replies->toArray(),
            'users' => $users->toArray(),
            'groups' => $groups->toArray(),
            'languages' => $languages,
            'fetcherModules' => $fetcherModules,
            'sidebarModules' => $sidebarModules,
        ]);
    }

    public function facebook()
    {
        $pages = $this->getCompany()->socialMediaTokens()->where('social_media_name', 'facebook')->get();
        if (!count($pages)) {
            return redirect(route('facebook.setup'));
        }

        $templates = Template::where('status', 'APPROVED')->select('name', 'id', 'language')->get();
        $replies = Reply::where('type', 1)->where('flow_id', null)->get();
        $languages = explode(',', __('No translation') . ',' . config('wpbox.available_languages', 'English,Spanish,German,Italian,Portuguese,Dutch,French,Japanese,Chinese'));

        //Find the users of the company
        $users = $this->getCompany()->users()->pluck('name', 'id');
        //Get all the modules where type is "link_fetcher"
        $fetcherModules = [];
        foreach (Module::all() as $key => $module) {
            if ($module->get('isLinkFetcher')) {
                try {
                    $fetcherModules[$module->get('alias')] = [
                        'name' => $module->get('alias'),
                        'data' => app($module->get('namespace') . '\Main')->getData(),
                    ];
                } catch (\Exception $e) {
                    //Do nothing
                    //dd($e);
                }
            }
        }

        return view('wpbox::facebook.master', [
            'company' => $this->getCompany(),
            'templates' => $templates->toArray(),
            'replies' => $replies->toArray(),
            'users' => $users->toArray(),
            'languages' => $languages,
            'fetcherModules' => $fetcherModules,
        ]);
    }

    public function instagram()
    {
        return 0;
    }

    /**
     * API
     */
    public function chatlist($lastmessagetime, $page = 1, $search_query = '')
    {
        // $shouldWeReturnChats = $lastmessagetime == 'none';

        // if (!$shouldWeReturnChats) {
        //     //Check for updated chats
        //     if (Contact::where('has_chat', 1)->orderBy('last_reply_at', 'DESC')->first()->last_reply_at . '' == $lastmessagetime) {
        //         //Front end last message, is same as backedn last message time
        //         $shouldWeReturnChats = false;
        //     } else {
        //         $shouldWeReturnChats = true;
        //     }
        // }

        // if ($shouldWeReturnChats) {
        //     //Return list of contacts that have chat actives
        //     //check if current user in agent
        //     if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_assigned_only', 'false') != 'false') {
        //         $chatList = Contact::where('has_chat', 1)
        //             ->where('user_id', auth()->user()->id)
        //             ->with(['messages', 'country'])
        //             ->orderBy('last_reply_at', 'DESC')
        //             ->limit(150)
        //             ->get();
        //     } else {
        //         $chatList = Contact::where('has_chat', 1)
        //             ->with(['messages', 'country'])
        //             ->orderBy('last_reply_at', 'DESC')
        //             ->limit(150)
        //             ->get();
        //     }

        //     return response()->json([
        //         'data' => $chatList,
        //         'status' => true,
        //         'errMsg' => '',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false,
        //         'errMsg' => 'No changes',
        //     ]);
        // }

        //Number of chats to return per page
        $pageSize = config('wpbox.chat_page_size', 6);

        /*$shouldWeReturnChats=$lastmessagetime=="none";
 
         if(!$shouldWeReturnChats){
             //Check for updated chats
             if(Contact::where('has_chat',1)->orderBy('last_reply_at','DESC')->skip(($page-1)*$pageSize)->first()->last_reply_at==$lastmessagetime){
                 //Front end last message, is same as backend last message time
                 $shouldWeReturnChats=false;
             }else{
                 $shouldWeReturnChats=true;
             }
         }*/
        $shouldWeReturnChats = true;

        if ($shouldWeReturnChats) {
            //Return list of contacts that have chat actives
            //check if current user in agent
            $numberOfPages = 1;
            if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_assigned_only', 'false') != 'false') {
                $chatList = Contact::where('has_chat', 1)
                    ->where('user_id', auth()->user()->id)
                    ->with(['messages', 'country'])
                    ->orderBy('last_reply_at', 'DESC');
            } else {
                $chatList = Contact::where('has_chat', 1)
                    ->with(['messages', 'country'])
                    ->orderBy('last_reply_at', 'DESC');
            }

            //Total number of chats
            $numberOfChats = $chatList->count();

            //Mine chats
            $myChatsCount = Contact::where('has_chat', 1)
                ->where('user_id', auth()->user()->id)
                ->count();

            //We also need to know the total number of pages, from the total number of chats
            $numberOfPages = ceil($chatList->count() / $pageSize);

            //Unread chats
            if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_assigned_only', 'false') != 'false') {
                $unreadChatsCount = Contact::where('has_chat', 1)
                    ->where('user_id', auth()->user()->id)
                    ->where('is_last_message_by_contact', 1)
                    ->count();
            } else {
                $unreadChatsCount = Contact::where('has_chat', 1)->where('is_last_message_by_contact', 1)->count();
            }

            //Query, also by last_message
            if ($search_query != '' && strlen($search_query) > 3) {
                $chatList = $chatList
                    ->where('name', 'like', '%' . $search_query . '%')
                    ->orWhere('phone', 'like', '%' . $search_query . '%')
                    ->orWhereHas('messages', function ($query) use ($search_query) {
                        $query->where('value', 'like', '%' . $search_query . '%');
                    });
            }

            //Now get the chats for the current page
            $chatList = $chatList
                ->skip(($page - 1) * $pageSize)
                ->limit($pageSize)
                ->get();

            return response()->json([
                'data' => $chatList,
                'numberOfPages' => $numberOfPages,
                'page' => $page,
                'totalChats' => $numberOfChats,
                'myChatsCount' => $myChatsCount,
                'unreadChatsCount' => $unreadChatsCount,
                'newMessagesCount' => $unreadChatsCount,
                'status' => true,
                'errMsg' => '',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errMsg' => 'No changes',
            ]);
        }
    }

    public function setLanguage(Request $request, Contact $contact)
    {
        // Validate the request...
        $validatedData = $request->validate([
            'language' => 'required|string',
        ]);

        // Assign the contact to the user
        $contact->language = $validatedData['language'];

        if (__('No translation') == $validatedData['language']) {
            $contact->language = 'none';
        }
        $contact->save();

        return response()->json([
            'status' => true,
            'message' => 'Language set successfully',
        ]);
    }

    public function assignContact(Request $request, Contact $contact)
    {
        // Validate the request...
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Assign the contact to the user
        $contact->user_id = $validatedData['user_id'];
        $contact->save();

        event(new Chatlistchange($contact->id, $contact->company_id));

        return response()->json([
            'status' => true,
            'message' => 'Contact assigned successfully',
        ]);
    }

    public function chatmessages($contact)
    {
        $messages = Message::where('contact_id', $contact)->where('status', '>', 0)->orderBy('id', 'desc')->limit(50)->get();
        $fbMessageId = Message::where('contact_id', $contact)->where('status', '>', 0)->where('is_message_by_contact', '=', '1')->orderBy('id', 'desc')->value('fb_message_id');

        if ($fbMessageId) {
            $this->updateReadResponse($fbMessageId);
        }

        return response()->json([
            'data' => $messages,
            'status' => true,
            'errMsg' => '',
        ]);
    }

    public function sendNoteToContact(Request $request, Contact $contact)
    {
        /**
         * Contact id
         * Message
         */
        $validator = Validator::make($request->all(), [
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errorsText = $validator->errors()->all();
            // Convert the array of error messages to a single string
            $errorsString = implode("\n", $errorsText);
            return response()->json([
                'status' => false,
                'errMsg' => $errorsString,
            ]);
        } else {
            // OK, we can send the note
            $note = $request->input('note');
            $contact->addNote($note);

            return response()->json([
                'status' => true,
                'message' => 'Note added successfully',
            ]);
        }
    }

    public function sendMessageToContact(Request $request, Contact $contact)
    {
        /**
         * Contact id
         * Message
         */
        $fbMessageId = Message::where('contact_id', $contact->id)->where('status', '>', 0)->where('is_message_by_contact', '=', '1')->orderBy('id', 'desc')->value('fb_message_id');

        if ($fbMessageId) {
            $this->updateReadResponse($fbMessageId);
        }

        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            $errorsText = $validator->errors()->all();
            // Convert the array of error messages to a single string
            $errorsString = implode("\n", $errorsText);
            return response()->json([
                'status' => false,
                'errMsg' => $errorsString,
            ]);
        } elseif (strip_tags($request->message) != $request->message) {
            return response()->json([
                'status' => false,
                'errMsg' => __('Only text is allowed!'),
            ]);
        } else {
            //OK, we can send the message
            $messageSend = $contact->sendMessage(strip_tags($request->message), '', false);
            return response()->json([
                'message' => $messageSend,
                'messagetime' => $messageSend->created_at->format('Y-m-d H:i:s'),
                'status' => true,
                'errMsg' => '',
            ]);
        }
    }

    public function sendImageMessageToContact(Request $request, Contact $contact)
    {
        /**
         * Contact id
         * Message
         */

        $caption = $request->caption ?? '';
        $fileUrl = $request->image;
        $ids = $request->media_id;
        $detect = strtoupper($request->media_detect);
        $messageType = null;

        if ($detect == 'IMAGE') {
            // It's an image
            $messageType = 'IMAGE';
        } elseif ($detect == 'VIDEO') {
            // It's a video
            $messageType = 'VIDEO';
        } elseif ($detect == 'AUDIO') {
            // It's audio
            $messageType = 'VIDEO';
        } elseif ($detect == 'PDF') {
            // It's audio
            $messageType = 'DOCUMENT';
        } else {
            // Handle other types or show an error message
            $messageType = 'IMAGE';
        }

        // $imageUrl = '';
        // if (config('settings.use_s3_as_storage', false)) {
        //     //S3 - store per company
        //     $path = $request->image->storePublicly('uploads/media/send/' . $contact->company_id, 's3');
        //     $imageUrl = Storage::disk('s3')->url($path);
        // } else {
        //     //Regular
        //     $path = $request->image->store(null, 'public_media_upload');
        //     $imageUrl = Storage::disk('public_media_upload')->url($path);
        // }

        // $fileType = $request->file('image')->getMimeType();
        // if (str_contains($fileType, 'image')) {
        //     // It's an image
        //     $messageType = 'IMAGE';
        // } elseif (str_contains($fileType, 'video')) {
        //     // It's a video
        //     $messageType = 'VIDEO';
        // } elseif (str_contains($fileType, 'audio')) {
        //     // It's audio
        //     $messageType = 'VIDEO';
        // } else {
        //     // Handle other types or show an error message
        //     $messageType = 'IMAGE';
        // }

        // $messageSend = $contact->sendMediaWithCaptionMessage($imageUrl, false, false, $messageType);
        // return response()->json([
        //     'message' => $messageSend,
        //     'messagetime' => $messageSend->created_at->format('Y-m-d H:i:s'),
        //     'status' => true,
        //     'errMsg' => '',
        // ]);

        if ($fileUrl && $messageType) {
            $messageSend = $contact->sendMediaWithCaptionMessage($fileUrl, $messageType, $caption);
            return response()->json([
                'message' => $messageSend,
                'messagetime' => $messageSend->created_at->format('Y-m-d H:i:s'),
                'status' => true,
                'errMsg' => '',
            ]);
        }
    }

    public function sendDocumentMessageToContact(Request $request, Contact $contact)
    {
        /**
         * Contact id
         * Message
         */
        $fileURL = '';
        if (config('settings.use_s3_as_storage', false)) {
            //S3 - store per company
            $path = $request->file->storePublicly('uploads/media/send/' . $contact->company_id, 's3');
            $fileURL = Storage::disk('s3')->url($path);
        } else {
            //Regular
            $path = $request->file->store(null, 'public_media_upload');
            $fileURL = Storage::disk('public_media_upload')->url($path);
        }

        $messageSend = $contact->sendMessage('', $fileURL, false, false, 'DOCUMENT');
        return response()->json([
            'message' => $messageSend,
            'messagetime' => $messageSend->created_at->format('Y-m-d H:i:s'),
            'status' => true,
            'errMsg' => '',
        ]);
    }

    public function sendAudio(Request $request, $contactId)
    {
        try {
            $request->validate([
                'audio' => 'required|file|mimes:webm,ogg,mp3,wav,m4a,mp4,aac,amr|max:10240', // 10MB
            ]);

            $contact = Contact::findOrFail($contactId);
            $phone = preg_replace('/\D+/', '', $contact->phone ?? '');
            if (!$phone) {
                return response()->json(['status' => false, 'errMsg' => 'Invalid phone number'], 422);
            }

            // Prepare file name
            $ext = '.' . $request->file('audio')->getClientOriginalExtension();
            $fileName = uniqid('audio_') . $ext;
            $company = auth()->user()->getCurrentCompany();

            // Save based on storage config
            if (config('settings.use_s3_as_storage', false)) {
                $filePath = 'uploads/media/received/' . $company->id . '/' . $fileName;
                Storage::disk('s3')->put($filePath, file_get_contents($request->file('audio')), 'public');
                $publicUrl = Storage::disk('s3')->url($filePath);
            } else {
                $request->file('audio')->move(public_path('uploads/media'), $fileName);
                $publicUrl = rtrim(config('app.url'), '/') . '/uploads/media/' . $fileName;
            }

            // Create a message record first with placeholder fb_message_id
            $message = Message::create([
                'contact_id' => $contactId,
                'company_id' => $company->id,
                'value' => '',
                'header_image' => '',
                'header_document' => '',
                'header_video' => '',
                'header_audio' => $publicUrl, // store audio URL
                'header_location' => '',
                'is_message_by_contact' => 0,
                'is_campign_messages' => 0,
                'message_type' => 1, // outgoing
                'status' => 0, // pending
                'buttons' => '[]',
                'components' => '',
                'response_type' => 2,
                'list_section_data' => null,
                'fb_message_id' => '', // placeholder until sent
            ]);

            // Send to WhatsApp
            $accessToken = Config::where('model_id', $company->id)->where('key', 'whatsapp_permanent_access_token')->value('value');
            $phoneNumberID = Config::where('model_id', $company->id)->where('key', 'whatsapp_phone_number_id')->value('value');

            if (!$phoneNumberID || !$accessToken) {
                return response()->json(['status' => false, 'errMsg' => 'WhatsApp API not configured'], 500);
            }

            $endpoint = "https://graph.facebook.com/v20.0/{$phoneNumberID}/messages";
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'audio',
                'audio' => [
                    'link' => $publicUrl,
                ],
            ];

            $response = Http::withToken($accessToken)->post($endpoint, $payload);

            if (!$response->successful()) {
                return response()->json(
                    [
                        'status' => false,
                        'errMsg' => 'Failed to send audio',
                        'meta' => $response->json(),
                    ],
                    500,
                );
            }

            // Get fb_message_id from response
            $fb_message_id = $response->json()['messages'][0]['id'] ?? null;

            //Update the contact last message, time etc
            // $this->last_support_reply_at = now();
            // $this->is_last_message_by_contact = false;
            $contact->last_support_reply_at = now();
            $contact->is_last_message_by_contact = false;
            $contact->save();
            event(new AgentReplies(auth()->user(), $message, $contact));

            // Update message record
            $message->update([
                'fb_message_id' => $fb_message_id ?: 'UNKNOWN',
                'status' => 1, // sent
            ]);

            return response()->json([
                'status' => true,
                'messagetime' => now(),
                'url' => $publicUrl,
                'fb_message_id' => $fb_message_id,
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => false,
                    'errMsg' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                500,
            );
        }
    }
}
