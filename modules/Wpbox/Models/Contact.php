<?php

namespace Modules\Wpbox\Models;

use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Modules\Contacts\Models\Contact as ModelsContact;
use Modules\Contacts\Models\Group;
use Modules\Wpbox\Events\AgentReplies;
use Modules\Wpbox\Events\ContactReplies;
use Modules\Wpbox\Notifications\ContactReplies as NotificationContactReplies;
use Modules\Wpbox\Events\Chatlistchange;
use Modules\Wpbox\Traits\Whatsapp;

class Contact extends ModelsContact
{
    use Whatsapp;

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'DESC');
    }

    public function notes()
    {
        return $this->hasMany(Message::class)->where('is_note', true)->orderBy('created_at', 'DESC');
    }

    public function trimString($str, $maxLength)
    {
        if (mb_strlen($str) <= $maxLength) {
            return $str;
        } else {
            $trimmed = mb_substr($str, 0, $maxLength);
            $lastSpaceIndex = mb_strrpos($trimmed, ' ');

            if ($lastSpaceIndex !== false) {
                return mb_substr($trimmed, 0, $lastSpaceIndex) . '...';
            } else {
                return $trimmed . '...';
            }
        }
    }

    public function sendDemoMessage($content, $is_message_by_contact = true, $is_campaign_messages = false, $messageType = 'TEXT', $fb_message_id = null)
    {
        //Check that all is set ok

        //Create the messages
        $messageToBeSend = Message::create([
            'contact_id' => $this->id,
            'company_id' => $this->company_id,
            'value' => $messageType == 'TEXT' ? $content : '',
            'header_image' => $messageType == 'IMAGE' ? $content : '',
            'header_document' => $messageType == 'DOCUMENT' ? $content : '',
            'header_video' => $messageType == 'VIDEO' ? $content : '',
            'header_location' => $messageType == 'LOCATION' ? $content : '',
            'is_message_by_contact' => $is_message_by_contact,
            'is_campign_messages' => $is_campaign_messages,
            'status' => 1,
            'buttons' => '[]',
            'components' => '',
            'fb_message_id' => $fb_message_id,
        ]);
        $messageToBeSend->save();
    }

    public function addNote($content)
    {
        $messageToBeSend = Message::create([
            'contact_id' => $this->id,
            'company_id' => $this->company_id,
            'value' => $content,
            'header_text' => __('Note'),
            'header_image' => '',
            'header_document' => '',
            'header_video' => '',
            'header_location' => '',
            'is_message_by_contact' => false,
            'is_campign_messages' => false,
            'status' => 4,
            'buttons' => '[]',
            'components' => '',
            'is_note' => true,
            'fb_message_id' => null,
        ]);
        if (auth()->check()) {
            $messageToBeSend->sender_name = auth()->user()->name;
        }
        $messageToBeSend->save();

        $companyUser = Company::findOrFail($this->company_id)->user;
        event(new AgentReplies($companyUser, $messageToBeSend, $this));

        return $messageToBeSend;
    }

    public function sendButtonMessage(array $payload, $contact)
    {
        // 1⃣ Create local message record
        $message = Message::create([
            'contact_id' => $contact->id,
            'company_id' => $contact->company_id,
            'value' => $payload['message'], // body text
            'header_text' => $payload['header'] ?? '',
            'footer_text' => $payload['footer'] ?? '',
            'header_image' => '',
            'header_document' => '',
            'header_video' => '',
            'header_audio' => '',
            'header_location' => '',
            'is_message_by_contact' => 0,
            'is_campign_messages' => 0,
            'message_type' => 1, // interactive
            'out_message_type' => 2, // reply buttons (important!)
            'status' => 1,
            'buttons' => json_encode(
                array_map(function ($btn) {
                    return [
                        'type' => 'reply',
                        'reply' => [
                            'id' => $btn['id'],
                            'title' => $btn['title'],
                        ],
                    ];
                }, $payload['buttons']),
            ),
            'components' => '',
            'response_type' => 2,
            'list_section_data' => null,
            'fb_message_id' => null,
        ]);

        // 2⃣ Send via your universal WhatsApp sender
        $this->sendMessageToWhatsApp($message, $contact);

        event(new ContactReplies(auth()->user(), $message, $this));

        // 3⃣ Return for tracking
        return $message;
    }

    public function sendMediaMessage($content, $mediaURL, $mediaType, $contact)
    {
        if (config('settings.use_s3_as_storage', false)) {
            // S3 bucket URL
            $bucket = config('settings.aws_bucket');
            $region = config('settings.aws_region', 'ap-south-1');
            $mediaURL = "https://{$bucket}.s3.{$region}.amazonaws.com/" . ltrim($mediaURL, '/');
        }

        $headerImage = $headerVideo = $headerDocument = $headerAudio = '';

        switch (strtoupper($mediaType)) {
            case 'IMAGE':
                $headerImage = $mediaURL;
                break;
            case 'VIDEO':
                $headerVideo = $mediaURL;
                break;
            case 'DOCUMENT':
                $headerDocument = $mediaURL;
                break;
            case 'AUDIO':
                $headerAudio = $mediaURL;
                break;
        }

        try {
            $message = Message::create([
                'contact_id' => $contact->id,
                'company_id' => $contact->company_id,
                'value' => $content,
                'header_text' => '',
                'footer_text' => '',
                'header_image' => $headerImage,
                'header_document' => $headerDocument,
                'header_video' => $headerVideo,
                'header_audio' => $headerAudio,
                'header_location' => '',
                'is_message_by_contact' => 0,
                'is_campign_messages' => 0,
                'message_type' => 2,
                'out_message_type' => 2,
                'status' => 1,
                'buttons' => '',
                'components' => '',
                'response_type' => 2,
                'list_section_data' => null,
                'fb_message_id' => null,
            ]);
        } catch (\Exception $e) {
            // Handles other general errors
            Log::error('Unexpected error while creating message: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        $this->sendMessageToWhatsApp($message, $contact);

        event(new ContactReplies(auth()->user(), $message, $this));

        return $message;
    }

    public function sendListMessage(array $payload, $contact)
    {
        try {
            // Extract button & sections from action key
            $button = $payload['action']['button'] ?? 'Choose an option';
            $sections = isset($payload['action']['sections']) && !empty($payload['action']['sections']) ? json_encode($payload['action']['sections']) : json_encode([]);

            $message = Message::create([
                'contact_id' => $contact->id,
                'company_id' => $contact->company_id,
                'value' => $payload['message'], // body text
                'header_text' => $payload['header'] ?? '',
                'footer_text' => $payload['footer'] ?? '',
                'header_image' => '',
                'header_video' => '',
                'header_document' => '',
                'header_audio' => '',
                'header_location' => '',
                'is_message_by_contact' => false,
                'is_campign_messages' => false,
                'message_type' => 'TEXT',
                'out_message_type' => 3, // list message
                'status' => 1,
                'buttons' => $button,
                'list_section_data' => $sections,
                'fb_message_id' => null,
                'file_name' => '',
            ]);

            // Send to WhatsApp API
            $this->sendMessageToWhatsApp($message, $contact);

            event(new ContactReplies(auth()->user(), $message, $this));

            return $message;
        } catch (\Exception $e) {
            \Log::error('Failed to create/send list message: ' . $e->getMessage(), [
                'payload' => $payload,
                'contact_id' => $contact->id ?? null,
            ]);
            throw $e;
        }
    }

    /**
     * $reply - Reply - The reply to be send
     */
    public function sendReply(Reply $reply)
    {
        //Create the message
        $buttons = '';
        $contact_now = Contact::find($this->id);

        //Brij MOhan Negi Update for chatbot reply with interactive list and button with image on header
        $buttonComponent = [];
        $buttonTemplate = json_decode($reply->interactive_template_group); //Brij Mohan Negi Update
        $out_message_type = 1; //Brij Mohan Negi Update
        $list_button_text = null;
        $buttonData = '';
        $listData = '';
        $is_cta = false;
        $isList = false;

        if (!empty($buttonTemplate)) {
            $template_action_type = $buttonTemplate->action_type;
            $template_id = $buttonTemplate->id;

            if (!empty($template_id) && !empty($template_action_type)) {
                $options = [];

                //template type 1 = text only , 2 = button template, 3 = list button template
                if ($template_action_type == 2) {
                    $button_info = RepliesButton::where('id', $template_id)->first();
                    $data = json_decode($button_info->template);
                    if (!empty($data) && isset($data->templateButtons) && count($data->templateButtons) != 0) {
                        $options = $data->templateButtons;
                    }
                    if (!empty($options)) {
                        $out_message_type = 2;
                        foreach ($options as $valueButton) {
                            $is_cta = false;

                            if (isset($valueButton->quickReplyButton)) {
                                $buttonComponent[sizeof($buttonComponent)] = [
                                    'type' => 'reply',
                                    'reply' => [
                                        'id' => $valueButton->quickReplyButton->id,
                                        'title' => $valueButton->quickReplyButton->displayText,
                                    ],
                                ];
                            } elseif (isset($valueButton->urlButton)) {
                                $is_cta = true;
                                $buttonComponent[sizeof($buttonComponent)] = [
                                    'name' => 'cta_url',
                                    'parameters' => [
                                        'display_text' => $valueButton->urlButton->displayText,
                                        'url' => $valueButton->urlButton->url,
                                    ],
                                ];
                            } else {
                                //array_push($buttons,$valueButton);
                            }
                        }
                    }
                } elseif ($template_action_type == 3) {
                    $is_cta = false;
                    $list_button_info = RepliesListButton::where('id', $template_id)->first();
                    $list_button_text = $list_button_info->button_text;
                    $list_data = json_decode($list_button_info->template);
                    if (!empty($list_data) && isset($list_data->sections) && count($list_data->sections) != 0) {
                        $options = $list_data->sections;
                    }

                    if (!empty($options) && !empty($list_button_text)) {
                        $out_message_type = 3;

                        for ($i = 0; $i < count($options); $i++) {
                            $rowsComponent = [];
                            for ($j = 0; $j < count($options[$i]->rows); $j++) {
                                $rowsComponent[sizeof($rowsComponent)] = [
                                    'id' => $options[$i]->rows[$j]->rowId,
                                    'title' => $options[$i]->rows[$j]->title,
                                    'description' => $options[$i]->rows[$j]->description ?? '',
                                ];
                            }

                            $buttonComponent[sizeof($buttonComponent)] = [
                                'title' => $options[$i]->title,
                                'rows' => $rowsComponent,
                            ];
                        }
                    }
                }
            }

            //Brij Mohan Negi Update
            if ($template_action_type == 2) {
                $buttonData = json_encode($buttonComponent);
                $listData = '';
            } elseif ($template_action_type == 3) {
                $buttonData = $list_button_text;
                $listData = json_encode($buttonComponent);
                $isList = true;
            }
        }

        // $this->isInputMessage = 0;
        // $this->isInputMessageFor = null;
        // $this->inputDataTemp = null;
        // $this->update();

        //Log::info('Response Data:', ['response' => $reply]); // Use ->json() to log as array if response is JSON
        if ($isList == false) {
            if ($reply->api_response_type == 1) {
                $dynamic_keys_id = [];
                $dynamic_keys_value = [];
                $dynamic_keys_desc = [];
                $list_array_id_key = $reply->list_ref_id ?? '';
                $reply_save_type = 3;
                $reply_save_type = $reply->save_type == 'SESS' ? 1 : ($reply->save_type == 'CURR' ? 2 : 3);

                if ($reply->list_ref_id == 'rand') {
                    $genrate_rand_number = rand(100000, 999999);
                    $list_array_id_key = $genrate_rand_number;
                }
                $list_array_value_key = $reply->list_ref_value ?? '';
                $list_array_desc_key = $reply->list_ref_description ?? '';

                $list_button_text = $reply->button1;
                $options = $reply->list_data;
                $rowsComponent = [];
                $usedIds = [];
                $buttonComponent = [];

                $count_array = count($options);
                if ($reply->list_ref_id != 'rand') {
                    if ($list_array_id_key) {
                        $dynamic_keys_process_id = explode('.', $list_array_id_key);
                        if (count($dynamic_keys_process_id) >= 2) {
                            $dynamic_keys_id = $dynamic_keys_process_id;
                            $count_array = count($options[$dynamic_keys_process_id[0]]);
                        }
                    }
                }
                if ($list_array_value_key) {
                    $dynamic_keys_process_value = explode('.', $list_array_value_key);
                    if (count($dynamic_keys_process_value) >= 2) {
                        $dynamic_keys_value = $dynamic_keys_process_value;

                        $count_array = count($options[$dynamic_keys_process_value[0]]);
                    }
                }

                if ($list_array_value_key) {
                    $dynamic_keys_process_desc = explode('.', $list_array_desc_key);
                    if (count($dynamic_keys_process_desc) >= 2) {
                        $dynamic_keys_desc = $dynamic_keys_process_desc;
                    }
                }

                if ($list_array_id_key && $list_array_value_key) {
                    if (is_array($options)) {
                        for ($i = 0; $i < min($count_array, 10); $i++) {
                            if ($reply->list_ref_id != 'rand') {
                                $id = $dynamic_keys_id ? $options[$dynamic_keys_id[0]][$i][$dynamic_keys_id[1]] ?? null : $options[$i][$list_array_id_key] ?? null;
                            } else {
                                $id = $list_array_id_key + $i;
                            }

                            $title = $dynamic_keys_value ? $options[$dynamic_keys_value[0]][$i][$dynamic_keys_value[1]] ?? '' : $options[$i][$list_array_value_key] ?? '';

                            $title = substr($title, 0, 24);

                            $desc = $dynamic_keys_desc ? $options[$dynamic_keys_desc[0]][$i][$dynamic_keys_desc[1]] ?? '' : $options[$i][$list_array_desc_key] ?? '';

                            $desc = substr($desc, 0, 60);

                            if ($id === null || in_array($id, $usedIds)) {
                                continue;
                            }

                            $usedIds[] = $id;
                            $rowsComponent[] = [
                                'id' => $reply->button1_id . '_' . $id . '_' . $i . '_' . $reply_save_type,
                                'title' => $title,
                                'description' => $desc ?? '',
                            ];
                        }
                    }

                    $buttonComponent[] = [
                        'title' => $reply->list_menu_title,
                        'rows' => $rowsComponent,
                    ];
                }

                $buttonData = $list_button_text;
                $listData = json_encode($buttonComponent);
            } else {
                $reply->api_response_type = 2;
                for ($i = 1; $i < 4; $i++) {
                    if ($reply->{'button' . $i} != '') {
                        $buttonComponent[sizeof($buttonComponent)] = [
                            'type' => 'reply',
                            'reply' => [
                                'id' => $reply->{'button' . $i . '_id'},
                                'title' => $reply->{'button' . $i},
                            ],
                        ];
                    }
                }

                //If buttons is empty array
                $is_cta = false;
                if (sizeof($buttonComponent) == 0) {
                    //Check if we have set and not empty button_name and button_url
                    if ($reply->button_name && $reply->button_name != '' && $reply->button_url && $reply->button_url != '') {
                        $is_cta = true;

                        //if button_url has ##apidata.
                        if ($this->hasApidataPlaceholder($reply->button_url)) {
                            if ($contact_now->keep_api_data) {
                                try {
                                    $contactInteractive_data = json_decode($contact_now->keep_api_data, true);
                                    $reply->button_url = $this->findReplaceAPIKeyData($reply->button_url, $contactInteractive_data);
                                } catch (\Exception $e) {
                                }
                            }
                        }

                        $buttonComponent[0] = [
                            'name' => 'cta_url',
                            'parameters' => [
                                'display_text' => $reply->button_name,
                                'url' => $reply->button_url,
                            ],
                        ];
                    }
                }

                $buttonData = json_encode($buttonComponent);
                $listData = '';
            }
        }

        //make next message intreactive with list data
        if ($this->hasValidataPlaceholder($reply->text) || $this->hasValidataPlaceholder($reply->header) || $this->hasValidataPlaceholder($reply->footer)) {
            if ($contact_now->api_validate_response) {
                try {
                    $contactInteractive_data = json_decode($contact_now->api_validate_response, true);
                    if ($contactInteractive_data) {
                        $reply->text = $this->replaceValiDataPlaceholders($reply->text, $contactInteractive_data);
                        $reply->header = $this->replaceValiDataPlaceholders($reply->header, $contactInteractive_data);
                        $reply->footer = $this->replaceValiDataPlaceholders($reply->footer, $contactInteractive_data);
                    }
                } catch (\Exception $e) {
                }
            }
        }

        //	Log::info('Response:', '1'); // Use ->json() to log as array if response is JSON

        if ($this->hasSessionApidataPlaceholder($reply->text) || $this->hasSessionApidataPlaceholder($reply->header) || $this->hasSessionApidataPlaceholder($reply->footer)) {
            if ($contact_now->keep_interactive_data) {
                try {
                    $contactInteractive_data = json_decode($contact_now->keep_interactive_data, true);
                    $listSelected_row = (int) $contact_now->keep_selected_listrow;

                    $reply->text = $this->findReplaceSessionAPIKeyData($reply->text, $contactInteractive_data, $listSelected_row);
                    $reply->header = $this->findReplaceSessionAPIKeyData($reply->header, $contactInteractive_data, $listSelected_row);
                    $reply->footer = $this->findReplaceSessionAPIKeyData($reply->footer, $contactInteractive_data, $listSelected_row);
                } catch (\Exception $e) {
                }
            }
        }

        if ($this->hasCurrentApidataPlaceholder($reply->text) || $this->hasCurrentApidataPlaceholder($reply->header) || $this->hasCurrentApidataPlaceholder($reply->footer)) {
            if ($contact_now->keep_current_api_data) {
                try {
                    $contactInteractive_data = json_decode($contact_now->keep_current_api_data, true);
                    $listSelected_row = (int) $contact_now->keep_current_selected_listrow;

                    $reply->text = $this->findReplaceCurrentAPIKeyData($reply->text, $contactInteractive_data, $listSelected_row);
                    $reply->header = $this->findReplaceCurrentAPIKeyData($reply->header, $contactInteractive_data, $listSelected_row);
                    $reply->footer = $this->findReplaceCurrentAPIKeyData($reply->footer, $contactInteractive_data, $listSelected_row);
                } catch (\Exception $e) {
                }
            }
        }

        if ($this->hasInputDataPlaceholder($reply->text) || $this->hasInputDataPlaceholder($reply->header) || $this->hasInputDataPlaceholder($reply->footer)) {
            if ($contact_now->inputDataKeep) {
                try {
                    $contactInteractive_data = json_decode($contact_now->inputDataKeep, true);
                    if ($contactInteractive_data) {
                        $reply->text = $this->replaceInputDataPlaceholders($reply->text, $contactInteractive_data);
                        $reply->header = $this->replaceInputDataPlaceholders($reply->header, $contactInteractive_data);
                        $reply->footer = $this->replaceInputDataPlaceholders($reply->footer, $contactInteractive_data);
                    }
                } catch (\Exception $e) {
                }
            }
        }

        /*  if ($this->hasApidataPlaceholder($reply->text)) {
            if ($contact_now->keep_api_data) {
                try {
                    $contactInteractive_data = json_decode($contact_now->keep_api_data, true);

                    $reply->text = $this->findReplaceAPIKeyData($reply->text, $contactInteractive_data);
                    $reply->header = $this->findReplaceAPIKeyData($reply->header, $contactInteractive_data);
                    $reply->footer = $this->findReplaceAPIKeyData($reply->footer, $contactInteractive_data);
                } catch (\Exception $e) {
                }
            }
        } */

        //messgae header types like image/video/file/location/contact
        $header_image = '';
        $header_video = '';
        $header_document = '';
        $header_location = '';
        $header_contact = '';
        $file_name = '';

        //out message type = 2 (button), 3 = list
        //image, video and file don't work with list message only works with button
        if ($out_message_type != 3) {
            if ($reply->header_type == 'PDF' && !empty($reply->media)) {
                $file_name = $reply->header;
                $header_document = asset($reply->media);
            }
            if ($reply->header_type == 'IMG' && !empty($reply->media)) {
                $header_image = asset($reply->media);
            }
            if ($reply->header_type == 'MP3' && !empty($reply->media)) {
                $header_video = asset($reply->media);
            }

            if ($reply->header_type == 'VIDEO' && !empty($reply->media)) {
                $header_video = asset($reply->media);
            }

            if ($reply->header_type == 'PDF' && !empty($reply->headerURL)) {
                $file_name = $reply->header;
                $header_document = $reply->headerURL;
            }
            if ($reply->header_type == 'IMG' && !empty($reply->headerURL)) {
                $header_image = $reply->headerURL;
            }
            if ($reply->header_type == 'MP3' && !empty($reply->headerURL)) {
                $header_video = $reply->headerURL;
            }

            if ($reply->header_type == 'VIDEO' && !empty($reply->headerURL)) {
                $header_video = $reply->headerURL;
            }
        }

        //for api data only
        if ($this->hasApidataPlaceholder($reply->headerURL)) {
            if ($reply->header_type == 'PDF') {
                if ($contact_now->keep_api_data) {
                    try {
                        $contactInteractive_data = json_decode($contact_now->keep_api_data, true);
                        $header_document = $this->findReplaceAPIKeyData($reply->headerURL, $contactInteractive_data);
                        $file_name = $reply->header;
                        $reply->header = '';
                    } catch (\Exception $e) {
                    }
                }
            }
        }
        //for current api data
        /*   if ($this->hasCurrentApidataPlaceholder($reply->headerURL)) {
            
            if($reply->header_type == "PDF"){
                
                   if ($contact_now->keep_current_api_data) {
                            try {
                                $contactInteractive_data = json_decode($contact_now->keep_current_api_data, true);
                                $listSelected_row = (int)$contact_now->keep_current_selected_listrow;

                                $header_document = $this->findReplaceCurrentAPIKeyData($reply->headerURL, $contactInteractive_data, $listSelected_row);
                                $reply->text =  '';
                            } catch (\Exception $e) {
                            }
                        }
            }
            
        }
        
        //for session api data
        if ($this->hasSessionApidataPlaceholder($reply->headerURL)) {
            
            if($reply->header_type == "PDF"){
                
                   if ($contact_now->keep_interactive_data) {
                            try {
                                $contactInteractive_data = json_decode($contact_now->keep_interactive_data, true);
                                $listSelected_row = (int)$contact_now->keep_selected_listrow;

                                $header_document = $this->findReplaceSessionAPIKeyData($reply->headerURL, $contactInteractive_data, $listSelected_row);
                                $reply->text =  '';
                            } catch (\Exception $e) {
                            }
                        }
            }
            
        }
         */
        
        $createData = [
            // 'contact_id' => $this->id,
            // 'company_id' => $this->company_id,
            // 'value' => $reply->text,
            // 'header_text' => $reply->header,
            // 'footer_text' => $reply->footer,
            // 'buttons' => $buttonData,
            // 'response_type' => $reply->api_response_type,
            // 'list_section_data' => $listData,
            // 'is_message_by_contact' => false,
            // 'is_campign_messages' => false,
            // 'status' => 1,
            // 'fb_message_id' => null,
            'contact_id' => $this->id,
            'company_id' => $this->company_id,
            'value' => $reply->text,
            'header_text' => $reply->header,
            'header_image' => $header_image,
            'header_video' => $header_video,
            'header_document' => $header_document,
            'header_location' => $header_location,
            'footer_text' => $reply->footer,
            'buttons' => $buttonData, //Brij Mohan Negi Update
            'message_type' => $reply->header_type, //Brij Mohan Negi Update
            'out_message_type' => $out_message_type, //Brij Mohan Negi Update
            'list_section_data' => $listData, //Brij Mohan Negi Update
            'is_message_by_contact' => false,
            'is_campign_messages' => false,
            'status' => 1,
            'fb_message_id' => null,
        ];

        // Add $header_document to $createData if it exists.
        if (isset($header_document)) {
            $createData['header_document'] = $header_document;
            $createData['file_name'] = $file_name;
        }

        if (isset($header_image)) {
            $createData['header_image'] = $header_image;
        }

        if (isset($header_video)) {
            $createData['header_video'] = $header_video;
        }

        //	Log::info('Created Data:', ['response' => $createData]); // Use ->json() to log as array if response is JSON

        $messageToBeSend = Message::create($createData);
        $messageToBeSend->save();
        if ($is_cta) {
            $messageToBeSend->is_cta = true;
        }

        ///		Log::info('$messageToBeSend Data:', ['response' => $messageToBeSend]); // Use ->json() to log as array if response is JSON
        if ($reply->isNextInput == 1) {
            $this->isInputDataReply = 1;
            $this->isInputMessageFor = $reply->next_reply_id;
            $this->inputDataTemp = $reply->input_variable;
        }

        $this->last_support_reply_at = now();
        $this->is_last_message_by_contact = false;
        //change for catalog
        if ($reply->bot_type == '1') {
            $this->sendWhatsAppCatalogMessage($messageToBeSend, $this);
        } else {
            $this->sendMessageToWhatsApp($messageToBeSend, $this);
        }

        // $this->sendMessageToWhatsApp($messageToBeSend, $this);
        //Find the user of the company
        $companyUser = Company::findOrFail($this->company_id)->user;
        event(new AgentReplies($companyUser, $messageToBeSend, $this));

        $this->last_message = $this->trimString($reply->text, 40);
        $this->update();

        return $messageToBeSend;
    }

    public function botReplyList($content, $messageToBeSend)
    {
        $replySend = false;
        $parts = null;
        if (strpos($content, '_') !== false) {
            // Split the string by underscores into an array
            $parts = explode('_', $content);
        }
        if ($parts) {
            $reply_save_type = $parts[4];

            if ($reply_save_type == 1) {
                $this->keep_interactive_id = $parts[2];
                $this->keep_selected_listrow = $parts[3];
            }
            if ($reply_save_type == 2) {
                $this->keep_current_interactive_id = $parts[2];
                $this->keep_current_selected_listrow = $parts[3];
            }
            $this->save();
            $trigger_id = $parts[0] . '_' . $parts[1];
            $textReplies = Reply::where('trigger', $trigger_id)->first();

            $replySend = $this->sendReply($textReplies);

            if ($replySend) {
                $messageToBeSend->bot_has_replied = true;
                $messageToBeSend->update();
            }
        }
    }
    public function botReply($content, $messageToBeSend)
    {
        // $contact->sendReply($reply);
        //Reply bot
        $textReplies = Reply::where('type', '!=', 1)->where('company_id', $this->company_id)->get();
        $replySend = false;
        Log::info('textReplies', [$content]);
        foreach ($textReplies as $key => $qr) {
            if (!$replySend) {
                $replySend = $qr->shouldWeUseIt($content, $this);
            }
        }

        //If no text reply found, look for campaign reply
        if (!$replySend) {
            $campaignReplies = Campaign::where('is_bot', 1)->where('is_bot_active', 1)->where('company_id', $this->company_id)->get();
            foreach ($campaignReplies as $key => $cr) {
                if (!$replySend) {
                    try {
                        $replySend = $cr->shouldWeUseIt($content, $this);
                    } catch (\Exception $e) {
                        Log::error('Error calling shouldWeUseIt:', ['exception' => $e->getMessage()]);
                    }
                }
            }
        }

        if ($replySend) {
            $messageToBeSend->bot_has_replied = true;
            $messageToBeSend->update();
        }
    }

    /**
     * $content- String - The content to be stored, text or link
     * $is_message_by_contact - Boolean - is this a message send by contact - RECEIVE
     * $is_campaign_messages - Boolean - is this a message generated from campaign
     * $messageType [TEXT | IMAGE | VIDEO | DOCUMENT ]
     * $fb_message_id String - The Facebook message ID
     */
    public function sendMessage($caption, $content, $is_message_by_contact = true, $is_campaign_messages = false, $messageType = 'TEXT', $fb_message_id = null, $extra = null, $replyType = null, $flowFormResponseData = null)
    {
        //Check that all is set ok
        //If message is from contact, and fb_message_id is set, check if the message is already in the system
        if ($is_message_by_contact && $fb_message_id) {
            $message = Message::where('fb_message_id', $fb_message_id)->first();
            if ($message) {
                return $message;
            }
        }

        if ($replyType == 'nfm_reply' && $extra && $flowFormResponseData) {
            if (isset($flowFormResponseData)) {
                $layout = WhatsAppFlowsViewLayout::where('flow_id', $extra)->first();
                $tableColumns = $layout ? json_decode($layout->tableColumns, true) : [];

                $caption = '📋 ' . __('WhatsApp Flow submission') . "\n\n";

                // Create key-to-label map FROM ALREADY DECODED ARRAY
                $labelMap = [];
                foreach ($tableColumns as $column) {
                    $labelMap[$column['name']] = $column['label'];
                }

                foreach ($flowFormResponseData as $key => $value) {
                    if ($key !== 'flow_token') {
                        $label = $labelMap[$key] ?? $key; // Fallback to original key if label missing
                        $caption .= "• {$label}: {$value}\n";
                    }
                }

                WhatsAppFlowsSubmittion::create([
                    'company_id' => $this->company_id,
                    'flow_id' => $extra,
                    'form_data' => json_encode($flowFormResponseData),
                    'phone_number_id' => '',
                ]);
            }
            
             $this->sendMessage($this->getCompany()->getConfig('whatsappflows_thankyou_message', '🙏 Thank you for submitting the form. We have received your details successfully!'),'', false, false);
        }
 
        //Create the messages
        $messageToBeSend = Message::create([
            'contact_id' => $this->id,
            'company_id' => $this->company_id,
            'value' => $caption ?? '',
            'header_image' => $messageType == 'IMAGE' ? $content : '',
            'header_document' => $messageType == 'DOCUMENT' ? $content : '',
            'header_video' => $messageType == 'VIDEO' ? $content : '',
            'header_audio' => $messageType == 'AUDIO' ? $content : '',
            'header_location' => $messageType == 'LOCATION' ? $content : '',
            'is_message_by_contact' => $is_message_by_contact,
            'is_campign_messages' => $is_campaign_messages,
            'message_type' => 1,
            'status' => 1,
            'buttons' => '[]',
            'components' => '',
            'response_type' => 2,
            'list_section_data' => null,
            'fb_message_id' => $fb_message_id,
        ]);

        //Set the original message
        if ($messageType == 'TEXT') {
            $messageToBeSend->doTranslation($is_message_by_contact);
        }

        Log::info('messageToBeSend', [$messageToBeSend]);
        //Check who send the message
        if (!$is_message_by_contact) {
            //Get current user
            if (auth()->check()) {
                $messageToBeSend->sender_name = auth()->user()->name;
            }

            //Check if the company has enough credits
            if (!$this->getCompany()->hasEnoughCreditsByAction('send_regular_message')) {
                //Set the message to be sent as error
                $messageToBeSend->status = 2;
                $messageToBeSend->error = __('No credits left');
                $messageToBeSend->save();
                return $messageToBeSend;
            }
        }

        $messageToBeSend->save();

        //Update the contact last message, time etc

        if (!$is_campaign_messages) {
            $this->has_chat = true;
            $this->last_reply_at = now();
            if ($is_message_by_contact) {
                $this->last_client_reply_at = now();
                $this->is_last_message_by_contact = true;

                //Reply bots
                if ($this->enabled_ai_bot) {
                    if (isset($replyType) && $replyType == 'list_reply') {
                        $this->botReply($extra, $messageToBeSend);
                    } else {
                        // $this->botReply($caption, $messageToBeSend);

                        if ($this->isInputDataReply == 1) {
                            $next_reply_id = $this->isInputMessageFor;
                            $key = $this->inputDataTemp;
                            $value = $caption;

                            if ($content) {
                                $value = $content;
                            }

                            // // Your input variables
                            // $key = $dataKeyToStore;    // The JSON key (e.g. 'name')
                            // $value = $caption;                 // The value to store

                            // 1. Get existing JSON data (or start fresh)
                            $currentData = json_decode($this->inputDataKeep ?? '{}', true) ?? [];

                            // 2. Update/Add the new entry
                            $currentData[$key] = $value;

                            // 3. Convert back to JSON string
                            $inputDataToKeep = json_encode($currentData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

                            // Now use it in your object
                            $this->inputDataKeep = $inputDataToKeep;

                            $this->isInputDataReply = null;
                            $this->isInputMessageFor = null;
                            $this->inputDataTemp = null;
                            $this->update();

                            $nextReply = Reply::find($next_reply_id);
                            if ($nextReply) {
                                if ($nextReply->isAPI == 1) {
                                    $nextReply->checkAPIRequest($nextReply, $caption, $this);
                                } else {
                                    $this->sendReply($nextReply);
                                    //$nextReply->sendTheReply($receivedMessage,$contact);
                                }
                            }
                        } else {
                            $this->botReply($caption, $messageToBeSend);
                        }
                    }
                }

                //Notify
                $messageToBeSend->extra = $extra;
                try {
                    event(new ContactReplies(auth()->user(), $messageToBeSend, $this));
                } catch (\Exception $ex) {
                }

                //Send the notification
                //Get the company user
                try {
                    $companyAdmin = Company::findOrFail($this->company_id)->user;
                    $companyAdmin->notify(new NotificationContactReplies($companyAdmin, $messageToBeSend, $this));
                } catch (\Exception $e) {
                }

                $messageToBeSend->extra = null;
                event(new Chatlistchange($this->id, $this->company_id));

                //Check if we need to update the contact based on the message

                //Check if it is stop promotion
                $unsubscribeTrigger = $this->getCompany()->getConfig('unsubscribe_trigger', 'Stop promotions');

                if (stripos($caption, $unsubscribeTrigger) !== false) {
                    $this->subscribed = 0;
                    $this->update();

                    //Send the message to the client that soon human will contact him
                    $this->sendMessage($this->getCompany()->getConfig('unsubscribe_trigger_message', '📩 You have successfully unsubscribed from our WhatsApp notifications. ✅ We respect your choice and will not send you further messages. 🔄 If you ever change your mind, just reply SUBSCRIBE to hear from us again.'),'', false, false);
                }

                $unsubscribeTrigger = $this->getCompany()->getConfig('subscribe_trigger', 'SUBSCRIBE');

                if (stripos($caption, $unsubscribeTrigger) !== false) {
                    $this->subscribed = 1;
                    $this->update();

                    //Send the message to the client that soon human will contact him
                    $this->sendMessage($this->getCompany()->getConfig('subscribe_trigger_message', '🎉 Welcome back, You have successfully subscribed to our WhatsApp updates. We will keep you posted with the latest news, offers, and updates.'),'', false, false);
                }

                //Check it it is agent handover
                if ($caption == $this->getCompany()->getConfig('agent_handover_trigger', 'Talk to a human')) {
                    $this->enabled_ai_bot = false;
                    $this->update();

                    //Send the message to the client that soon human will contact him
                    $this->sendMessage($this->getCompany()->getConfig('agent_handover_message', 'Soon you will be connected to a human agent. Thanks for your patience.'),'', false, false);
                }
            } else {
                $this->last_support_reply_at = now();
                $this->is_last_message_by_contact = false;
                $this->sendMessageToWhatsApp($messageToBeSend, $this);
                event(new AgentReplies(auth()->user(), $messageToBeSend, $this));

                //Use credits
                try {
                    $this->getCompany()->useCreditsByAction('send_regular_message', 1);
                } catch (\Exception $e) {
                    //Ignore
                }
            }
        }
        $this->last_message = $this->trimString($caption, 40);
        $this->update();

        return $messageToBeSend;
    }

    // Function to replace placeholders with dynamic data
    public function replacePlaceholdersInput($template, $data)
    {
        return preg_replace_callback(
            '/##apidata\.(.*?)##/',
            function ($matches) use ($data) {
                $key = $matches[1]; // Extract the key after "apidata."
                return $data[$key] ?? 'N/A'; // Access the contact data array
            },
            $template,
        );
    }

    function getNestedValue($data, $path)
    {
        $keys = explode('.', $path);
        foreach ($keys as $key) {
            // If we encounter {index}, replace it with the dynamic index (e.g., {index} -> $index)
            if (strpos($key, '{index}') !== false) {
                $key = str_replace('{index}', '', $key);
                $key = (int) $key; // Convert to integer for array access
                $data = $data[$key];
            } elseif (isset($data[$key])) {
                $data = $data[$key];
            } else {
                return null; // Return null if path does not exist
            }
        }
        return $data;
    }

    // Function to replace dynamic placeholders in the template
    public function replacePlaceholders($template, $data)
    {
        return preg_replace_callback(
            '/##apidata\.(.*?)##/',
            function ($matches) use ($data) {
                $key = $matches[1]; // Extract the key after "apidata."
                return $data[$key] ?? 'N/A'; // Access the contact data array
            },
            $template,
        );
    }
    public function replaceValiDataPlaceholders($template, $data)
    {
        return preg_replace_callback(
            '/##validata\.(.*?)##/',
            function ($matches) use ($data) {
                // Assuming you are replacing with the first element of the array
                $key = $matches[1]; // Extract the key after "apidata."
                return $data[0][$key] ?? 'N/A'; // Access the first element of the $data array
            },
            $template,
        );
    }

    public function findReplaceAPIKeyData($template, $data)
    {
        return preg_replace_callback(
            '/##apidata\.(.*?)##/',
            function ($matches) use ($data) {
                // Assuming you are replacing with the first element of the array
                $key = $matches[1]; // Extract the key after "apidata."
                return $data[0][$key] ?? 'N/A'; // Access the first element of the $data array
            },
            $template,
        );
    }

    public function replaceInputDataPlaceholders($template, $data)
    {
        return preg_replace_callback(
            '/##inputdata\.(.*?)##/',
            function ($matches) use ($data) {
                $key = $matches[1];
                return $data[$key] ?? 'N/A'; // Direct access to the decoded JSON object
            },
            $template,
        );
    }

    public function findReplaceSessionAPIKeyData($template, $contactInteractive_data, $index)
    {
        $strTxt = $template;
        preg_match_all('/##sessdata\.(.*?)##/', $strTxt, $matches, PREG_PATTERN_ORDER);
        $findKeys = $matches[1];

        $findValues = [];
        foreach ($findKeys as $k => $replacedStr) {
            $findValues[$matches[0][$k]] = $this->returnReplpacedValue($replacedStr, $contactInteractive_data, $index);
        }

        foreach ($findValues as $key => $val) {
            $strTxt = str_replace($key, $val, $strTxt);
        }

        return $strTxt;
    }

    public function findReplaceCurrentAPIKeyData($template, $contactInteractive_data, $index)
    {
        $strTxt = $template;
        preg_match_all('/##currdata\.(.*?)##/', $strTxt, $matches, PREG_PATTERN_ORDER);
        $findKeys = $matches[1];

        $findValues = [];
        foreach ($findKeys as $k => $replacedStr) {
            $findValues[$matches[0][$k]] = $this->returnReplpacedValue($replacedStr, $contactInteractive_data, $index);
        }

        foreach ($findValues as $key => $val) {
            $strTxt = str_replace($key, $val, $strTxt);
        }

        return $strTxt;
    }

    public function returnReplpacedValue($replacedStr, $contactInteractive_data, $index)
    {
        $pieces = explode('.', $replacedStr);
        $val = $contactInteractive_data;
        foreach ($pieces as $key => $value) {
            if (array_is_list($val)) {
                $val = $val[$index];
            }
            if (array_key_exists($value, $val)) {
                $val = $val[$value];
                if ($key === 0 && is_array($val)) {
                    $val = $val[$index];
                }
            } else {
                return null;
            }
        }
        return $val;
    }

    public function hasSessionApidataPlaceholder($template)
    {
        return strpos($template, '##sessdata.') !== false;
    }

    public function hasInputDataPlaceholder($template)
    {
        return strpos($template, '##inputdata.') !== false;
    }

    public function hasValidataPlaceholder($template)
    {
        return strpos($template, '##validata.') !== false;
    }

    public function hasCurrentApidataPlaceholder($template)
    {
        return strpos($template, '##currdata.') !== false;
    }
    public function hasApidataPlaceholder($template)
    {
        return strpos($template, '##apidata.') !== false;
    }
    public function sendMediaWithCaptionMessage($media_url, $messageType, $caption)
    {
        //Check that all is set ok
        $is_campaign_messages = false;
        $is_message_by_contact = false;
        $share_caption = $caption == '' ? 'MediaShare via FM' : $caption;

        //Create the messages
        $messageToBeSend = Message::create([
            'contact_id' => $this->id,
            'company_id' => $this->company_id,
            'value' => $caption,
            'header_image' => $messageType == 'IMAGE' ? $media_url : '',
            'header_document' => $messageType == 'DOCUMENT' ? $media_url : '',
            'header_video' => $messageType == 'VIDEO' ? $media_url : '',
            'header_audio' => $messageType == 'AUDIO' ? $media_url : '',
            'header_location' => $messageType == 'LOCATION' ? $media_url : '',
            'is_message_by_contact' => false,
            'is_campign_messages' => false,
            'message_type' => 2,
            'status' => 1,
            'buttons' => '[]',
            'components' => '',
            'fb_message_id' => null,
        ]);
        $messageToBeSend->save();

        //Update the contact last message, time etc
        $this->last_support_reply_at = now();
        $this->is_last_message_by_contact = false;
        $this->sendMessageToWhatsApp($messageToBeSend, $this);
        event(new AgentReplies(auth()->user(), $messageToBeSend, $this));

        // $this->last_message = $this->trimString($share_caption, 40);
        $this->last_message = substr($caption, 0, 40);
        $this->update();

        return $messageToBeSend;
    }
}
