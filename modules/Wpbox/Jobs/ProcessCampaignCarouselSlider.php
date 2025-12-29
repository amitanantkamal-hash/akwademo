<?php

namespace Modules\Wpbox\Jobs;

use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\Contact;
use Modules\Wpbox\Models\Message;
use Modules\Wpbox\Models\Template;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCampaignCarouselSlider implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;
    protected $contactIds;
    protected $requestData;

    public function __construct(Campaign $campaign, array $contactIds, array $requestData = [])
    {
        $this->campaign = $campaign;
        $this->contactIds = $contactIds;
        $this->requestData = $requestData;
    }

    public function handle()
    {
        try {
            $template = Template::where('id', $this->campaign->template_id)->first();
            if (!$template) {
                Log::error('Template not found for campaign: ' . $this->campaign->id);
                return;
            }

            $variablesValues = json_decode($this->campaign->variables, true) ?? [];
            $variables_match = json_decode($this->campaign->variables_match, true) ?? [];
            
            $messages = [];
            $chunkSize = 500;

            // Process contacts in chunks to avoid memory issues
            $contactChunks = array_chunk($this->contactIds, 100);
            
            foreach ($contactChunks as $contactChunk) {
                $contacts = Contact::with('country')->whereIn('id', $contactChunk)->get();
                
                foreach ($contacts as $contact) {
                    $messageData = $this->prepareMessageData($contact, $template, $variablesValues, $variables_match);
                    if ($messageData) {
                        $messages[] = $messageData;
                    }

                    // Insert in chunks
                    if (count($messages) >= $chunkSize) {
                        Message::insert($messages);
                        $messages = [];
                    }
                }
            }

            // Insert any remaining messages
            if (!empty($messages)) {
                Message::insert($messages);
            }
        } catch (\Exception $e) {
            Log::error('Error processing campaign carousel slider messages: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function prepareMessageData($contact, $template, $variablesValues, $variables_match)
    {
        try {
            if ($this->requestData && is_array($this->requestData)) {
                $contact->is_replied = false;
                $contact->replied_at = null;
                $contact->template_sent_at = now();
                $contact->last_campaign_id = $this->campaign->id;
                $contact->save();
            } else {
                // Handle Request object input
                if ($request != null){
                    $contact->is_replied = false;
                    $contact->replied_at = null;
                    $contact->template_sent_at = now();
                    $contact->last_campaign_id = $this->campaign->id;
                    $contact->save();
                }
            }

            // Timezone handling
            $sendTime = Carbon::now();
            if (isset($this->requestData['send_time']) && $this->requestData['send_time'] && !isset($this->requestData['send_now'])) {
                try {
                    $company = $this->campaign->company;
                    config(['app.timezone' => $company->getConfig('time_zone', config('app.timezone'))]);
                    
                    $companyRelatedDateTimeOfSend = Carbon::parse($this->requestData['send_time']);
                    $systemRelatedDateTimeOfSend = $companyRelatedDateTimeOfSend->copy()->tz(config('app.timezone'));
                    
                    if ($contact->country && $contact->country->timezone) {
                        $sendTime = Carbon::parse($systemRelatedDateTimeOfSend->format('Y-m-d H:i:s'), $contact->country->timezone)
                            ->copy()->tz(config('app.timezone'));
                    } else {
                        $sendTime = $systemRelatedDateTimeOfSend;
                    }
                } catch (\Throwable $th) {
                    Log::warning('Timezone conversion error: ' . $th->getMessage());
                }
            }

            $content = "";
            $APIComponents = [];
            $components = json_decode($template->components, true);

            if (is_array($components)) {
                foreach ($components as $component) {
                    $lowKey = strtolower($component['type'] ?? '');
                    
                    if (($component['type'] ?? '') == "HEADER" && ($component['format'] ?? '') == "TEXT") {
                        $content = $component['text'] ?? '';
                        $component['parameters'] = [];

                        if (isset($variables_match[$lowKey])) {
                            $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey] ?? '', $component, $content, $contact);
                            unset($component['text'], $component['format'], $component['example']);
                            $APIComponents[] = $component;
                        }
                    } elseif (($component['type'] ?? '') == "BODY") {
                        $content = $component['text'] ?? '';
                        $component['parameters'] = [];

                        if (isset($variables_match[$lowKey])) {
                            $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey] ?? '', $component, $content, $contact);
                            unset($component['text'], $component['format'], $component['example']);
                            $APIComponents[] = $component;
                        }
                    } elseif (($component['type'] ?? '') === 'CAROUSEL') {
                        $carouselCards = [];

                        foreach ($component['cards'] as $index => $card) {
                            $cardComponents = [];

                            foreach ($card['components'] as $comp) {
                                $link = $this->requestData['images'][$index] ?? '';
                                if ($comp['type'] === 'HEADER' && $comp['format'] === 'IMAGE') {
                                    $cardComponents[] = [
                                        "type" => "header",
                                        "parameters" => [
                                            [
                                                "type" => "image",
                                                "image" => [
                                                    "link" => $link
                                                ]
                                            ]
                                        ]
                                    ];
                                } elseif ($comp['type'] === 'BODY') {
                                    $cardComponents[] = [
                                        "type" => "body",
                                        "parameters" => [
                                            [
                                                "type" => "text",
                                                "text" => $comp['text'] ?? ''
                                            ]
                                        ]
                                    ];
                                } elseif ($comp['type'] === 'BUTTONS') {
                                    foreach ($comp['buttons'] as $btnIndex => $button) {
                                        if ($button['type'] === 'QUICK_REPLY') {
                                            $cardComponents[] = [
                                                "type" => "button",
                                                "sub_type" => "quick_reply",
                                                "index" => $btnIndex,
                                                "parameters" => [
                                                    [
                                                        "type" => "payload",
                                                        "payload" => $button['text'] ?? ''
                                                    ]
                                                ]
                                            ];
                                        } elseif ($button['type'] === 'URL') {
                                            $cardComponents[] = [
                                                "type" => "button",
                                                "sub_type" => "url",
                                                "index" => $btnIndex,
                                                "parameters" => [
                                                    [
                                                        "type" => "text",
                                                        "text" => $button['url'] ?? ''
                                                    ]
                                                ]
                                            ];
                                        }
                                    }
                                }
                            }

                            $carouselCards[] = [
                                "card_index" => $index,
                                "components" => $cardComponents
                            ];
                        }

                        $APIComponents[] = [
                            "type" => "carousel",
                            "cards" => $carouselCards
                        ];
                    }
                }
            }

            // Demo mode check
            $value = $content;
            if (config('settings.is_demo', false)) {
                $value = "[THIS IS DEMO] " . $value;
            }

            return [
                "contact_id" => $contact->id,
                "company_id" => $contact->company_id,
                "value" => $value,
                "header_image" => null,
                "header_video" => null,
                "header_audio" => null,
                "header_document" => null,
                "footer_text" => null,
                "buttons" => json_encode([]),
                "header_text" => null,
                "is_message_by_contact" => false,
                "is_campign_messages" => true,
                "status" => 0,
                "created_at" => now(),
                "scchuduled_at" => $sendTime,
                "components" => json_encode($APIComponents),
                "campaign_id" => $this->campaign->id,
            ];
        } catch (\Exception $e) {
            Log::error('Error preparing carousel slider message for contact ' . $contact->id . ': ' . $e->getMessage());
            return null;
        }
    }

    protected function setParameter($match, $values, &$component, &$text, $contact, $paramType = "text")
    {
        // Copy the setParameter implementation from your Campaign model
        foreach ($match as $keyVM => $vm) { 
            $data = ["type" => $paramType];
            if ($vm == "-2") {
                // Use static value
                $data[$paramType] = $values[$keyVM] ?? '';
                array_push($component['parameters'], $data);
                $text = str_replace("{{" . $keyVM . "}}", $values[$keyVM] ?? '', $text);
            } else if ($vm == "-3") {
                // Contact extra value in runtime
                try {
                    $extraValueNeeded = $values[$keyVM] ?? ''; // ex "order.id"
                    $extraValues = $contact->extra_value; // ex ["order"=>["id"=>1,"status"=>"pending"]]
                    $valueNeeded = null;

                    if (isset($extraValues)) {
                        $keys = explode('.', $extraValueNeeded);
                        $valueNeeded = $extraValues;

                        foreach ($keys as $key) {
                            if (isset($valueNeeded[$key])) {
                                $valueNeeded = $valueNeeded[$key];
                            } else {
                                $valueNeeded = $values[$keyVM] ?? '';
                                break;
                            }
                        }
                    }

                    $data[$paramType] = $valueNeeded;
                    array_push($component['parameters'], $data);
                    $text = str_replace("{{" . $keyVM . "}}", $valueNeeded, $text);
                } catch (\Throwable $th) {
                    // Use static value
                    $data[$paramType] = $values[$keyVM] ?? '';
                    array_push($component['parameters'], $data);
                    $text = str_replace("{{" . $keyVM . "}}", ($values[$keyVM] ?? '') . "---", $text);
                }
            } else if ($vm == "-1") {
                // Contact name
                $data[$paramType] = $contact->name;
                array_push($component['parameters'], $data);
                $text = str_replace("{{" . $keyVM . "}}", $contact->name, $text);
            } else if ($vm == "0") {
                // Contact phone
                $data[$paramType] = $contact->phone;
                array_push($component['parameters'], $data);
                $text = str_replace("{{" . $keyVM . "}}", $contact->phone, $text);
            } else {
                // Use defined contact field
                if ($contact->fields->where('id', $vm)->first()) {
                    $val = $contact->fields->where('id', $vm)->first()->pivot->value;
                    $data[$paramType] = $val;
                    array_push($component['parameters'], $data);
                    $text = str_replace("{{" . $keyVM . "}}", $val, $text);
                } else {
                    $data[$paramType] = "";
                    array_push($component['parameters'], $data);
                    $text = str_replace("{{" . $keyVM . "}}", "", $text);
                }
            }
        }
    }
}