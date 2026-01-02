<?php

namespace Modules\Wpbox\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Modules\Contacts\Models\Group;
use App\Models\Paymenttemplate;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;

class Campaign extends Model
{
    use Whatsapp;
    
    protected $table = 'wa_campaings';
    public $guarded = [];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    protected static function booted(){
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model){
           $company_id=session('company_id',null);
            if($company_id){
                $model->company_id=$company_id;
            }
        });
    }

   public function shouldWeUseIt($receivedMessage, Contact $contact)
    {
        $receivedMessage = " " . strtolower($receivedMessage);
        $message = "";
        $sendThisCampaign = false;

        // Store the value of $this->trigger in a new variable
        $triggerValues = $this->trigger;
	   
        // Convert $triggerValues into an array if it contains commas
        if (strpos($triggerValues, ',') !== false) {
            $triggerValues = explode(',', $triggerValues);
        }
	   

        if (is_array($triggerValues)) {
            foreach ($triggerValues as $trigger) {
                if ($this->bot_type == 2) {
                    // Exact match
					$trigger = " " . strtolower($trigger);
                    if ($receivedMessage == $trigger) {
                        $sendThisCampaign = true;
                        break; // exit the loop once a match is found
                    }
                } else if ($this->bot_type == 3) {
                    // Contains
                    if (stripos($receivedMessage, $trigger) !== false) {
                        $sendThisCampaign = true;
                        break; // exit the loop once a match is found
                    }
                }
            }
        } else {
            //Doesn't contain commas
            if ($this->bot_type == 2) {
                // Exact match
				
				$triggerValues = " " . strtolower($triggerValues);
                if ($receivedMessage == $triggerValues) {
                    $sendThisCampaign = true;
                }
            } else if ($this->bot_type == 3) {
                // Contains
                if (stripos($receivedMessage, $triggerValues) !== false) {
                    $sendThisCampaign = true;
                }
            }
        }



        //Change message
        if ($sendThisCampaign) {
            $this->increment('used', 1);
            $this->update();

            //catalog
            $template = Template::where('id',$this->template_id)->first();

            if($template->type == '1'){
                $message=$this->makeMessagesCatalog(null,$contact);
            }
            else{
                $message=$this->makeMessages(null,$contact);
            }

            // $message = $this->makeMessages(null, $contact);
            $contact->sendMessage($contact->getCompany()->getConfig('delay_response', __('Give me a moment, I will have the answer shortly')), false);
            $this->sendCampaignMessageToWhatsApp($message);

            return true;
        } else {
            return false;
        }
    }


    // public function makeMessages($request,Contact $contact=null){
    //     //For each contact, send the message

    //     //1. Find all the contact that this message should be send to
    //     if($this->group_id==null&&$this->contact_id==null&&$contact==null){
    //         //All contacts
    //         $contacts = Contact::where('subscribed', 1)->get();
    //     }else if($this->group_id!=null){
    //         //Specific group
    //         $contacts = Group::findOrFail($this->group_id)
    //             ->contacts()
    //             ->where('subscribed', 1)
    //             ->get();
    //     }else if($this->contact_id!=null){
    //         //Specific contact
    //         $contacts=Contact::where('id',$this->contact_id)->get();
    //     }else{
    //         //No contacts, meaning that contact is passed in run time
    //         $contacts=collect([$contact]);
    //     }
       
    //     //Prepare what we need
    //     $template=Template::withoutGlobalScope(\App\Scopes\CompanyScope::class)->where('id',$this->template_id)->first();
    //     $variablesValues=json_decode($this->variables,true);
    //     $variables_match=json_decode($this->variables_match,true);
    //     $messages=[];

    //     $this->send_to=$contacts->count();
    //     $this->update();
       

    //     //For each contact prepare the message

    //     // Parse the date string into a Carbon instance
    //     $tzBasedDelivery=false;
    //     $companyRelatedDateTimeOfSend=null;
    //     if($request!=null&&!$request->has('send_now')&&$request->has('send_time')&&$request->send_time!=null){
    //        $company=$this->company;

    //        //Set config based on com
    //        config(['app.timezone' => $company->getConfig('time_zone',config('app.timezone'))]);


    //         $companyRelatedDateTimeOfSend = Carbon::parse($request->send_time); //This will be set time in company time
    //         //Convert to system time
    //         $systemRelatedDateTimeOfSend = $companyRelatedDateTimeOfSend->copy()->tz(config('app.timezone'));//System time, can be the same
    //         $tzBasedDelivery=true;
    //     }
        
    //     foreach ($contacts as $key => $contact) {

    //         $content="";
    //         $header_text="";
    //         $header_image="";
    //         $header_document="";
    //         $header_video="";
    //         $header_audio="";
    //         $footer="";
    //         $buttons=[];
            
    //         $sendTime=Carbon::now();//Send now
    //         if($tzBasedDelivery){
    //                 try {
    //                     //Calculate time based on the client time zone
    //                     $sendTime=Carbon::parse($systemRelatedDateTimeOfSend->format('Y-m-d H:i:s'),$contact->country->timezone)->copy()->tz(config('app.timezone'))->format('Y-m-d H:i:s');
    //                 } catch (\Throwable $th) {
                       
    //                 }
    //         }

    //         //Make the components
    //         $components=json_decode($template->components,true); 
    //         $APIComponents=[];
    //         foreach ($components as $keyComponent => $component) {
    //             $lowKey=strtolower($component['type']);

    //             if($component['type']=="HEADER"&&$component['format']=="TEXT"){
    //                 $header_text=$component['text'];
    //                 $component['parameters']=[];
                   
    //                 if(isset($variables_match[$lowKey])){
    //                     $this->setParameter($variables_match[$lowKey],$variablesValues[$lowKey],$component,$header_text,$contact);
    //                     unset($component['text']);
    //                     unset($component['format']);
    //                     unset($component['example']);
    //                     array_push($APIComponents,$component);
    //                 }
                    
    //             }else if($component['type']=="BODY"){
    //                 $content=$component['text'];
    //                 $component['parameters']=[];
    //                 if(isset($variables_match[$lowKey])){
    //                     $this->setParameter($variables_match[$lowKey],$variablesValues[$lowKey],$component,$content,$contact);
    //                     unset($component['text']);
    //                     unset($component['format']);
    //                     unset($component['example']);
    //                     array_push($APIComponents,$component);
    //                 }
                    
    //             }else if(($component['type']=="HEADER"&&$component['format']=="DOCUMENT")){
    //                 $component['parameters']=[[
    //                     "type"=> "document",
    //                     "document"=>[
    //                         'link'=>$this->media_link
    //                     ]
    //                 ]];
    //                 $header_document=$this->media_link;
    //                 unset($component['format']);
    //                 unset($component['example']);
    //                 array_push($APIComponents,$component);
    //             }else if(($component['type']=="HEADER"&&$component['format']=="IMAGE")){
    //                 $component['parameters']=[[
    //                     "type"=> "image",
    //                     "image"=>[
    //                         'link'=>$this->media_link
    //                     ]
    //                 ]];
    //                 $header_image=$this->media_link;
    //                 unset($component['format']);
    //                 unset($component['example']);
    //                 array_push($APIComponents,$component);
    //             }else if(($component['type']=="HEADER"&&$component['format']=="VIDEO")){
    //                 $component['parameters']=[[
    //                     "type"=> "video",
    //                     "video"=>[
    //                         'link'=>$this->media_link
    //                     ]
    //                 ]];
    //                 $header_video=$this->media_link;
    //                 unset($component['format']);
    //                 unset($component['example']);
    //                 array_push($APIComponents,$component);
    //             }else if(($component['type']=="HEADER"&&$component['format']=="AUDIO")){
    //                 $component['parameters']=[[
    //                     "type"=> "audio",
    //                     "audio"=>[
    //                         'link'=>$this->media_link
    //                     ]
    //                 ]];
    //                 $header_audio=$this->media_link;
    //                 unset($component['format']);
    //                 unset($component['example']);
    //                 array_push($APIComponents,$component);
    //             }else if($component['type']=="FOOTER"){
    //                 $footer=$component['text'];
    //             }else if( $component['type']=="BUTTONS"){
    //                 $keyButton=0;
    //                 foreach ($component['buttons'] as $keyButtonFromLoop => $valueButton) {
                    
    //                      if(isset($variables_match[$lowKey][$keyButton]) && (($valueButton['type']=="URL"&&stripos($valueButton['url'], "{{") !== false) || ($valueButton['type']=="COPY_CODE")) ){
    //                         $buttonName="";
    //                         $button=[
    //                             "type"=>"button",
    //                             "sub_type"=>strtolower($valueButton['type']),
    //                             "index"=>$keyButtonFromLoop."",
    //                             "parameters"=>[]
    //                         ]; 
    //                         $paramType="text";
    //                         if($valueButton['type']=="COPY_CODE"){
    //                             $paramType="coupon_code";
    //                         }
                            
                           
    //                         $this->setParameter($variables_match[$lowKey][$keyButton],$variablesValues[$lowKey][$keyButton],$button,$buttonName,$contact,$paramType);
                
                            
    //                         array_push($APIComponents,$button);
    //                         array_push($buttons,$valueButton);
    //                         $keyButton++;
    //                      }else if($valueButton['type']=="FLOW"){
    //                         $button=[
    //                             "type"=>"button",
    //                             "sub_type"=>strtolower($valueButton['type']),
    //                              "index"=>$keyButtonFromLoop."",
    //                             "parameters"=>[]
    //                         ];
    //                         $keyButton++;
    //                         array_push($APIComponents,$button);
    //                         array_push($buttons,$valueButton);
    //                      }else{
    //                         array_push($buttons,$valueButton);
    //                      }
                         
    //                 }
                    
    //             }

                
    //         }
    //         $components=$APIComponents;

    //         $dataToSend=[
    //             "contact_id"=>$contact->id,
    //             "company_id"=>$contact->company_id,
    //             "value"=>$content,
    //             "header_image"=>$header_image,
    //             "header_video"=>$header_video,
    //             "header_audio"=>$header_audio,
    //             "header_document"=>$header_document,
    //             "footer_text"=>$footer,
    //             "buttons"=>json_encode($buttons),
    //             "header_text"=>$header_text,
    //             "is_message_by_contact"=>false,
    //             "is_campign_messages"=>true,
    //             "status"=>0,
    //             "created_at"=>now(),
    //             "scchuduled_at"=>$sendTime,
    //             "components"=>json_encode($components),
    //             "campaign_id"=>$this->id,
    //         ];

    //         if(config('settings.is_demo',false)){
    //             //Demo
    //             if(count($messages)<5){
    //                 //Allow, but let it know
    //                 $dataToSend['value']="[THIS IS DEMO] ".$dataToSend['value'];
    //                 array_push($messages,$dataToSend);
    //             }
                
    //         }else{
    //             //Production
    //             array_push($messages,$dataToSend);
    //         }

            
    //     }

    //     $chunkedMessages = array_chunk($messages, 500);
    //     foreach ($chunkedMessages as $chunk) {
    //         Message::insert($chunk);
    //     }
        

    //     if($contact!=null){
    //         //This was a single message from bot
    //         //Get the last message id
    //         return Message::where('contact_id',$contact->id)->where('campaign_id',$this->id)->orderBy('id','desc')->first();
    //     }
    // }

    public function makeMessages($request,Contact $contact=null){

        $contacts = null;
        if ($request!=null && $request->has('resend') && $request->has('rtype')) {

                    $statusMapping = [
                        'SENT' => [1, 2],
                        'READ_IGNORED' => [3, 4],
                        'IGNORED' => [3],
                        'READ' => [4],
                        'FAILED' => [5]
                    ];
                    
                    $campaignResendId = $request->resend ?? null;
                    $rType = $request->rtype ?? null;
                    
                    if ($campaignResendId && $rType) {
                        if ($rType === 'all') {
                            $contactIds = Message::where('campaign_id', $campaignResendId)
                                ->pluck('contact_id')
                                ->unique();
                        } else {
                            $statuses = $statusMapping[strtoupper($rType)] ?? [];
                    
                            $contactIds = Message::where('campaign_id', $campaignResendId)
                                ->whereIn('status', $statuses)
                                ->pluck('contact_id')
                                ->unique();
                        }
                    
                        $contacts = Contact::where('subscribed', 1)->whereIn('id', $contactIds)->get();
                    }
                    
        } else if($this->group_id==null&&$this->contact_id==null&&$contact==null){
            //All contacts
            if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_assigned_contacts_only', 'false') != 'false') {
                $contacts = Contact::where('user_id', auth()->user()->id)->where('subscribed', 1)->get();
            }else{
                $contacts = Contact::where('subscribed', 1)->get();
            }
        }else if($this->group_id!=null){
            //Specific group
            $contacts = Group::findOrFail($this->group_id)
                ->contacts()
                ->where('subscribed', 1)
                ->get();
        }else if($this->contact_id!=null){
            //Specific contact
            $contacts=Contact::where('id',$this->contact_id)->get();
        }else{
            //No contacts, meaning that contact is passed in run time
            $contacts=collect([$contact]);
        }
       
        //Prepare what we need
        $template=Template::withoutGlobalScope(\App\Scopes\CompanyScope::class)->where('id',$this->template_id)->first();
        $variablesValues=json_decode($this->variables,true);
        $variables_match=json_decode($this->variables_match,true);
        $messages=[];

        $this->send_to=$contacts->count();
        $this->update();
       

        //For each contact prepare the message

        // Parse the date string into a Carbon instance
        $tzBasedDelivery=false;
        $companyRelatedDateTimeOfSend=null;
        if($request!=null&&!$request->has('send_now')&&$request->has('send_time')&&$request->send_time!=null){
           $company=$this->company;

           //Set config based on com
           config(['app.timezone' => $company->getConfig('time_zone',config('app.timezone'))]);


            $companyRelatedDateTimeOfSend = Carbon::parse($request->send_time); //This will be set time in company time
            //Convert to system time
            $systemRelatedDateTimeOfSend = $companyRelatedDateTimeOfSend->copy()->tz(config('app.timezone'));//System time, can be the same
            $tzBasedDelivery=true;
        }
        
        foreach ($contacts as $key => $contact) {

            $content="";
            $header_text="";
            $header_image="";
            $header_document="";
            $header_video="";
            $header_audio="";
            $footer="";
            $buttons=[];
            
            if ($request!=null){
                $contact->is_replied = false;
                $contact->replied_at = null;
                $contact->template_sent_at = now();
                $contact->last_campaign_id = $this->id;
                $contact->save();
            }

            $sendTime=Carbon::now();//Send now
            if($tzBasedDelivery){
                    try {
                        //Calculate time based on the client time zone
                        $sendTime=Carbon::parse($systemRelatedDateTimeOfSend->format('Y-m-d H:i:s'),$contact->country->timezone)->copy()->tz(config('app.timezone'))->format('Y-m-d H:i:s');
                    } catch (\Throwable $th) {
                       
                    }
            }

            //Make the components
            $components=json_decode($template->components,true); 
            $APIComponents=[];
            foreach ($components as $keyComponent => $component) {
                $lowKey=strtolower($component['type']);

                if($component['type']=="HEADER"&&$component['format']=="TEXT"){
                    $header_text=$component['text'];
                    $component['parameters']=[];
                   
                    if(isset($variables_match[$lowKey])){
                        $this->setParameter($variables_match[$lowKey],$variablesValues[$lowKey],$component,$header_text,$contact);
                        unset($component['text']);
                        unset($component['format']);
                        unset($component['example']);
                        array_push($APIComponents,$component);
                    }
                    
                }else if($component['type']=="BODY"){
                    $content=$component['text'];
                    $component['parameters']=[];
                    if(isset($variables_match[$lowKey])){
                        $this->setParameter($variables_match[$lowKey],$variablesValues[$lowKey],$component,$content,$contact);
                        unset($component['text']);
                        unset($component['format']);
                        unset($component['example']);
                        array_push($APIComponents,$component);
                    }
                    
                }else if(($component['type']=="HEADER"&&$component['format']=="DOCUMENT")){
                    $component['parameters']=[[
                        "type"=> "document",
                        "document"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_document=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if(($component['type']=="HEADER"&&$component['format']=="IMAGE")){
                    $component['parameters']=[[
                        "type"=> "image",
                        "image"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_image=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if(($component['type']=="HEADER"&&$component['format']=="VIDEO")){
                    $component['parameters']=[[
                        "type"=> "video",
                        "video"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_video=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if(($component['type']=="HEADER"&&$component['format']=="AUDIO")){
                    $component['parameters']=[[
                        "type"=> "audio",
                        "audio"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_audio=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if($component['type']=="FOOTER"){
                    $footer=$component['text'];
                }else if( $component['type']=="BUTTONS"){
                    $keyButton=0;
                    foreach ($component['buttons'] as $keyButtonFromLoop => $valueButton) {
                    
                         if(isset($variables_match[$lowKey][$keyButton]) && (($valueButton['type']=="URL"&&stripos($valueButton['url'], "{{") !== false) || ($valueButton['type']=="COPY_CODE")) ){
                            $buttonName="";
                            $button=[
                                "type"=>"button",
                                "sub_type"=>strtolower($valueButton['type']),
                                "index"=>$keyButtonFromLoop."",
                                "parameters"=>[]
                            ]; 
                            $paramType="text";
                            if($valueButton['type']=="COPY_CODE"){
                                $paramType="coupon_code";
                            }
                            
                           
                            $this->setParameter($variables_match[$lowKey][$keyButton],$variablesValues[$lowKey][$keyButton],$button,$buttonName,$contact,$paramType);
                
                            
                            array_push($APIComponents,$button);
                            array_push($buttons,$valueButton);
                            $keyButton++;
                         }else if($valueButton['type']=="FLOW"){
                            $button=[
                                "type"=>"button",
                                "sub_type"=>strtolower($valueButton['type']),
                                 "index"=>$keyButtonFromLoop."",
                                "parameters"=>[]
                            ];
                            $keyButton++;
                            array_push($APIComponents,$button);
                            array_push($buttons,$valueButton);
                         }else{
                            array_push($buttons,$valueButton);
                         }
                         
                    }
                    
                }

                
            }
            $components=$APIComponents;

            $dataToSend=[
                "contact_id"=>$contact->id,
                "company_id"=>$contact->company_id,
                "value"=>$content,
                "header_image"=>$header_image,
                "header_video"=>$header_video,
                "header_audio"=>$header_audio,
                "header_document"=>$header_document,
                "footer_text"=>$footer,
                "buttons"=>json_encode($buttons),
                "header_text"=>$header_text,
                "is_message_by_contact"=>false,
                "is_campign_messages"=>true,
                "status"=>0,
                "created_at"=>now(),
                "scchuduled_at"=>$sendTime,
                "components"=>json_encode($components),
                "campaign_id"=>$this->id,
            ];

            if(config('settings.is_demo',false)){
                //Demo
                if(count($messages)<5){
                    //Allow, but let it know
                    $dataToSend['value']="[THIS IS DEMO] ".$dataToSend['value'];
                    array_push($messages,$dataToSend);
                }
                
            }else{
                //Production
                array_push($messages,$dataToSend);
            }

            
        }

        $chunkedMessages = array_chunk($messages, 500);
        foreach ($chunkedMessages as $chunk) {
            Message::insert($chunk);
        }
        

        if($contact!=null){
            //This was a single message from bot
            //Get the last message id
            return Message::where('contact_id',$contact->id)->where('campaign_id',$this->id)->orderBy('id','desc')->first();
        }
    }

    public function makeMessagesContact($request,Contact $contact=null ){
        $logFile = __DIR__ . '/wa-makeMessagesContact.txt';
        //For each contact, send the message
        //1. Find all the contact that this message should be send to
        if($this->group_id==null&&$this->contact_id==null&&$contact==null){
            //All contacts
            $contacts = Contact::where('subscribed', 1)->get();
        }else if($this->group_id!=null){
            //Specific group
            $contacts = Group::findOrFail($this->group_id)
                ->contacts()
                ->where('subscribed', 1)
                ->get();
        }else if($this->contact_id!=null){
            //Specific contact
            $contacts=Contact::where('id',$this->contact_id)->get();
        }else{
            //No contacts, meaning that contact is passed in run time
            $contacts=collect([$contact]);
        }
       
        //Prepare what we need
        $template=Template::where('id',$this->template_id)->first();
        $variablesValues=json_decode($this->variables,true);
        $variables_match=json_decode($this->variables_match,true);
        $this->logData("variablesValues: " . print_r($variablesValues, true), $logFile);
        $this->logData("variables_match: " . print_r($variables_match, true), $logFile);


        $messages=[];

        $this->send_to=$contacts->count();
        $this->update();
       

        //For each contact prepare the message

        // Parse the date string into a Carbon instance
        $tzBasedDelivery=false;
        $companyRelatedDateTimeOfSend=null;
        if($request!=null&&!$request->has('send_now')&&$request->has('send_time')&&$request->send_time!=null){
           $company=$this->company;

           //Set config based on restaurant
           config(['app.timezone' => $company->getConfig('time_zone',config('app.timezone'))]);


            $companyRelatedDateTimeOfSend = Carbon::parse($request->send_time); //This will be set time in company time
            //Convert to system time
            $systemRelatedDateTimeOfSend = $companyRelatedDateTimeOfSend->copy()->tz(config('app.timezone'));//System time, can be the same
            $tzBasedDelivery=true;
        }
        
        foreach ($contacts as $key => $contact) {

            $content="";
            $header_text="";
            $header_image="";
            $header_document="";
            $header_video="";
            $header_audio="";
            $footer="";
            $buttons=[];
            
            $sendTime=Carbon::now();//Send now
            if($tzBasedDelivery){
                    try {
                        //Calculate time based on the client time zone
                        $sendTime=Carbon::parse($systemRelatedDateTimeOfSend->format('Y-m-d H:i:s'),$contact->country->timezone)->copy()->tz(config('app.timezone'))->format('Y-m-d H:i:s');
                    } catch (\Throwable $th) {
                       
                    }
            }

            //Make the components
            $components=json_decode($template->components,true); 
            $APIComponents=[];
            foreach ($components as $keyComponent => $component) {
                $lowKey=strtolower($component['type']);

                if($component['type']=="HEADER"&&$component['format']=="TEXT"){
                    $header_text=$component['text'];
                    $component['parameters']=[];
                   
                    if(isset($variables_match[$lowKey])){
                        $this->setParameter($variables_match[$lowKey],$variablesValues[$lowKey],$component,$header_text,$contact);
                        unset($component['text']);
                        unset($component['format']);
                        unset($component['example']);
                        array_push($APIComponents,$component);
                    }
                    
                }else if($component['type']=="BODY"){
                    $content=$component['text'];
                    $component['parameters']=[];
                    if(isset($variables_match[$lowKey])){
                        $this->setParameter($variables_match[$lowKey],$variablesValues[$lowKey],$component,$content,$contact);
                        unset($component['text']);
                        unset($component['format']);
                        unset($component['example']);
                        array_push($APIComponents,$component);
                    }
                    
                }else if(($component['type']=="HEADER"&&$component['format']=="DOCUMENT")){
                    $component['parameters']=[[
                        "type"=> "document",
                        "document"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_document=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if(($component['type']=="HEADER"&&$component['format']=="IMAGE")){
                    $component['parameters']=[[
                        "type"=> "image",
                        "image"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_image=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if(($component['type']=="HEADER"&&$component['format']=="VIDEO")){
                    $component['parameters']=[[
                        "type"=> "video",
                        "video"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_video=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if(($component['type']=="HEADER"&&$component['format']=="AUDIO")){
                    $component['parameters']=[[
                        "type"=> "audio",
                        "audio"=>[
                            'link'=>$this->media_link
                        ]
                    ]];
                    $header_audio=$this->media_link;
                    unset($component['format']);
                    unset($component['example']);
                    array_push($APIComponents,$component);
                }else if($component['type']=="FOOTER"){
                    $footer=$component['text'];
                }else if( $component['type']=="BUTTONS"){
                    $keyButton=0;
                    foreach ($component['buttons'] as $keyButtonFromLoop => $valueButton) {
                    
                         if(isset($variables_match[$lowKey][$keyButton]) && (($valueButton['type']=="URL"&&stripos($valueButton['url'], "{{") !== false) || ($valueButton['type']=="COPY_CODE")) ){
                            $buttonName="";
                            $button=[
                                "type"=>"button",
                                "sub_type"=>strtolower($valueButton['type']),
                                "index"=>$keyButtonFromLoop."",
                                "parameters"=>[]
                            ]; 
                            $paramType="text";
                            if($valueButton['type']=="COPY_CODE"){
                                $paramType="coupon_code";
                            }
                           
                            $this->setParameter($variables_match[$lowKey][$keyButton],$variablesValues[$lowKey][$keyButton],$button,$buttonName,$contact,$paramType);
                
                            
                            array_push($APIComponents,$button);
                            array_push($buttons,$valueButton);
                            $keyButton++;
                         }else{
                            array_push($buttons,$valueButton);
                         }
                         
                    }
                    
                }

                
            }
            $components=$APIComponents;

            $dataToSend=[
                "contact_id"=>$contact->id,
                "company_id"=>$contact->company_id,
                "value"=>$content,
                "header_image"=>$header_image,
                "header_video"=>$header_video,
                "header_audio"=>$header_audio,
                "header_document"=>$header_document,
                "footer_text"=>$footer,
                "buttons"=>json_encode($buttons),
                "header_text"=>$header_text,
                "is_message_by_contact"=>false,
                "is_campign_messages"=>true,
                "status"=>0,
                "created_at"=>now(),
                "scchuduled_at"=>$sendTime,
                "components"=>json_encode($components),
                "campaign_id"=>$this->id,
            ];

           return $dataToSend;

            
        }

        $chunkedMessages = array_chunk($messages, 500);
        foreach ($chunkedMessages as $chunk) {
            Message::insert($chunk);
        }
        

        if($contact!=null){
            //This was a single message from bot
            //Get the last message id
            return Message::where('contact_id',$contact->id)->where('campaign_id',$this->id)->orderBy('id','desc')->first();
        }
    }

    //catalog
    public function makeMessagesCatalog($request, Contact $contact = null)
    {
        
        //For each contact, send the message
        if ($this->group_id == null && $this->contact_id == null && $contact == null) {
            //All contacts
            $contacts = Contact::where('subscribed', 1)->get();
        } else if ($this->group_id != null) {
            //Specific group
            $contacts = Group::findOrFail($this->group_id)
                ->contacts()
                ->where('subscribed', 1)
                ->get();
        } else if ($this->contact_id != null) {
            //Specific contact
            $contacts = Contact::where('id', $this->contact_id)->get();
        } else {
            //No contacts, meaning that contact is passed in runtime
            $contacts = collect([$contact]);
        }

        //Prepare template and variables
        $template = Template::where('id', $this->template_id)->first();
        $Paymenttemplate = Paymenttemplate::where('company_id',$template->company_id)->first();
        $variablesValues = json_decode($this->variables, true);
        $variables_match = json_decode($this->variables_match, true);
        $messages = [];

        $this->send_to = $contacts->count();
        $this->update();

        $tzBasedDelivery = false;
        $companyRelatedDateTimeOfSend = null;

        if ($request != null && !$request->has('send_now') && $request->has('send_time') && $request->send_time != null) {
            $company = $this->company;

            config(['app.timezone' => $company->getConfig('time_zone', config('app.timezone'))]);

            $companyRelatedDateTimeOfSend = Carbon::parse($request->send_time);
            $systemRelatedDateTimeOfSend = $companyRelatedDateTimeOfSend->copy()->tz(config('app.timezone'));
            $tzBasedDelivery = true;
        }

        foreach ($contacts as $key => $contact) {
            $content = "";
            $header_text = "";
            $header_image = "";
            $header_document = "";
            $header_video = "";
            $header_audio = "";
            $footer = "";
            $buttons = [];

            if ($request!=null){
                $contact->is_replied = false;
                $contact->replied_at = null;
                $contact->template_sent_at = now();
                $contact->last_campaign_id = $this->id;
                $contact->save();
            }

            $sendTime = Carbon::now();

            if ($tzBasedDelivery) {
                try {
                    $sendTime = Carbon::parse($systemRelatedDateTimeOfSend->format('Y-m-d H:i:s'), $contact->country->timezone)->copy()->tz(config('app.timezone'))->format('Y-m-d H:i:s');
                } catch (\Throwable $th) {
                    
                }
            }

            $components = json_decode($template->components, true);
            $APIComponents = [];

            foreach ($components as $keyComponent => $component) {
                $lowKey = strtolower($component['type']);

                if ($component['type'] == "HEADER" && $component['format'] == "TEXT") {
                    $header_text = $component['text'];
                    $component['parameters'] = [];

                    if (isset($variables_match[$lowKey])) {
                        $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $header_text, $contact);
                        unset($component['text'], $component['format'], $component['example']);
                        array_push($APIComponents, $component);
                    }
                } else if ($component['type'] == "BODY") {
                    $content = $component['text'];
                    $component['parameters'] = [];

                    if (isset($variables_match[$lowKey])) {
                        $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $content, $contact);
                        unset($component['text'], $component['format'], $component['example']);
                        array_push($APIComponents, $component);
                    }
                } else if ($component['type'] == "HEADER" && $component['format'] == "DOCUMENT") {
                    $component['parameters'] = [
                        [
                            "type" => "document",
                            "document" => ['link' => $this->media_link]
                        ]
                    ];
                    unset($component['format'], $component['example']);
                    array_push($APIComponents, $component);
                } else if ($component['type'] == "HEADER" && $component['format'] == "IMAGE") {
                    $component['parameters'] = [
                        [
                            "type" => "image",
                            "image" => ['link' => $this->media_link]
                        ]
                    ];
                    unset($component['format'], $component['example']);
                    array_push($APIComponents, $component);
                } else if ($component['type'] == "HEADER" && $component['format'] == "VIDEO") {
                    $component['parameters'] = [
                        [
                            "type" => "video",
                            "video" => ['link' => $this->media_link]
                        ]
                    ];
                    unset($component['format'], $component['example']);
                    array_push($APIComponents, $component);
                } else if ($component['type'] == "HEADER" && $component['format'] == "AUDIO") {
                    $component['parameters'] = [
                        [
                            "type" => "audio",
                            "audio" => ['link' => $this->media_link]
                        ]
                    ];
                    unset($component['format'], $component['example']);
                    array_push($APIComponents, $component);
                } else if ($component['type'] == "FOOTER") {
                    $footer = $component['text'];
                } else if ($component['type'] == "BUTTONS") {
                    $keyButton = 0;

                    foreach ($component['buttons'] as $keyButtonFromLoop => $valueButton) {
                        if ($valueButton['type'] == "CATALOG") {
                            $button = [
                                "type" => "button",
                                "sub_type" => "CATALOG",
                                "index" => $keyButtonFromLoop,
                                "parameters" => [
                                    [
                                        "type" => "action",
                                        "action" => [
                                            "thumbnail_product_retailer_id" => $Paymenttemplate->product_id??0
                                        ]
                                    ]
                                ]
                            ];
                            array_push($APIComponents, $button);
                            array_push($buttons, $valueButton);
                            $keyButton++;
                        } else if (isset($variables_match[$lowKey][$keyButton]) && $valueButton['type'] == "URL") {
                            $button = [
                                "type" => "button",
                                "sub_type" => strtolower($valueButton['type']),
                                "index" => $keyButtonFromLoop . "",
                                "parameters" => []
                            ];
                            $this->setParameter($variables_match[$lowKey][$keyButton], $variablesValues[$lowKey][$keyButton], $button, "", $contact, "text");
                            array_push($APIComponents, $button);
                            array_push($buttons, $valueButton);
                            $keyButton++;
                        } else {
                            array_push($buttons, $valueButton);
                        }
                    }
                }
            }

            $components = $APIComponents;

            $dataToSend = [
                "contact_id" => $contact->id,
                "company_id" => $contact->company_id,
                "value" => $content,
                "header_image" => $header_image,
                "header_video" => $header_video,
                "header_audio" => $header_audio,
                "header_document" => $header_document,
                "footer_text" => $footer,
                "buttons" => json_encode($buttons),
                "header_text" => $header_text,
                "is_message_by_contact" => false,
                "is_campign_messages" => true,
                "status" => 0,
                "created_at" => now(),
                "scchuduled_at" => $sendTime,
                "components" => json_encode($components),
                "campaign_id" => $this->id,
            ];

            if (config('settings.is_demo', false)) {
                if (count($messages) < 5) {
                    $dataToSend['value'] = "[THIS IS DEMO] " . $dataToSend['value'];
                    array_push($messages, $dataToSend);
                }
            } else {
                array_push($messages, $dataToSend);
            }
        }

        $chunkedMessages = array_chunk($messages, 500);
        foreach ($chunkedMessages as $chunk) {
            Message::insert($chunk);
        }

        if ($contact != null) {
            return Message::where('contact_id', $contact->id)->where('campaign_id', $this->id)->orderBy('id', 'desc')->first();
        }
    }


    public function makeMessagesCarousel($request, Contact $contact = null) {
        if ($this->group_id == null && $this->contact_id == null && $contact == null) {
            // All contacts
            $contacts = Contact::where('subscribed', 1)->get();
        } else if ($this->group_id != null) {
            // Specific group
            $contacts = Group::findOrFail($this->group_id)
                ->contacts()
                ->where('subscribed', 1)
                ->get();
        } else if ($this->contact_id != null) {
            // Specific contact
            $contacts = Contact::where('id', $this->contact_id)->get();
        } else {
            // No contacts, meaning that contact is passed in runtime
            $contacts = collect([$contact]);
        }
    
        $template = Template::where('id', $this->template_id)->first();
        $variablesValues = json_decode($this->variables, true);
        $variables_match = json_decode($this->variables_match, true);
        $messages = [];
    
        $this->send_to = $contacts->count();
        $this->update();
    
        $tzBasedDelivery = false;
        $companyRelatedDateTimeOfSend = null;
    
        if ($request != null && !$request->has('send_now') && $request->has('send_time') && $request->send_time != null) {
            $company = $this->company;
            config(['app.timezone' => $company->getConfig('time_zone', config('app.timezone'))]);
            $companyRelatedDateTimeOfSend = Carbon::parse($request->send_time);
            $systemRelatedDateTimeOfSend = $companyRelatedDateTimeOfSend->copy()->tz(config('app.timezone'));
            $tzBasedDelivery = true;
        }
    
        foreach ($contacts as $key => $contact) {
            $content = "";
            $header_text = "";
            $header_image = "";
            $header_document = "";
            $header_video = "";
            $header_audio = "";
            $footer = "";
            $buttons = [];

            if ($request!=null){
                $contact->is_replied = false;
                $contact->replied_at = null;
                $contact->template_sent_at = now();
                $contact->last_campaign_id = $this->id;
                $contact->save();
            }

            $sendTime = Carbon::now();
    
            if ($tzBasedDelivery) {
                try {
                    $sendTime = Carbon::parse($systemRelatedDateTimeOfSend->format('Y-m-d H:i:s'), $contact->country->timezone)
                        ->copy()->tz(config('app.timezone'))->format('Y-m-d H:i:s');
                } catch (\Throwable $th) {
                    // Handle the exception if needed
                }
            }
    
            // Prepare body component if available
            $APIComponents = [];
            // Decode components if stored as JSON
            $components = json_decode($template->components, true);

            // Check if components is an array before iterating
            if (is_array($components)) {
                foreach ($components as $component) {
                    if ($component['type'] == 'BODY' && isset($variables_match['body'])) {
                        $content = $component['text'];
                        $APIComponents[] = [
                            "type" => "body",
                            "parameters" => [
                                [
                                    "type" => "text",
                                    "text" => $contact->name // Or any other text you need
                                ]
                            ]
                        ];
                    }
                }
            } else {
                // Handle case where components is not an array (e.g., log error, set default, etc.)
                $components = [];
            }
    
            // Prepare carousel components using product_retailer_id from the request
            $carouselComponents = [];
            $productRetailers = $request->product_retailer_id; // Ensure this is an array
            $catalog_id = $request->catalog_id; 
            foreach ($productRetailers as $index => $productRetailerId) {
                $carouselComponents[] = [
                    "card_index" => $index,
                    "components" => [
                        [
                            "type" => "header",
                            "parameters" => [
                                [
                                    "type" => "product",
                                    "product" => [
                                        "product_retailer_id" => $productRetailerId,
                                        "catalog_id" => $catalog_id
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];
            }
    
            // Combine body and carousel components into a single structure
            $components = $APIComponents; // Add the body component if present
            $components[] = [
                "type" => "carousel",
                "cards" => $carouselComponents
            ];
    
            $dataToSend = [
                "contact_id" => $contact->id,
                "company_id" => $contact->company_id,
                "value" => $content,
                "header_image" => $header_image,
                "header_video" => $header_video,
                "header_audio" => $header_audio,
                "header_document" => $header_document,
                "footer_text" => $footer,
                "buttons" => json_encode($buttons),
                "header_text" => $header_text,
                "is_message_by_contact" => false,
                "is_campign_messages" => true,
                "status" => 0,
                "created_at" => now(),
                "scchuduled_at" => $sendTime,
                "components" => json_encode($components),
                "campaign_id" => $this->id,
            ];
    
            if (config('settings.is_demo', false)) {
                if (count($messages) < 5) {
                    $dataToSend['value'] = "[THIS IS DEMO] " . $dataToSend['value'];
                    array_push($messages, $dataToSend);
                }
            } else {
                array_push($messages, $dataToSend);
            }
        }
    
        $chunkedMessages = array_chunk($messages, 500);
        foreach ($chunkedMessages as $chunk) {
            Message::insert($chunk);
        }
    
        if ($contact != null) {
            return Message::where('contact_id', $contact->id)->where('campaign_id', $this->id)->orderBy('id', 'desc')->first();
        }
    }

    public function makeMessagesCarouselSlider($request, Contact $contact = null) {
        if ($this->group_id == null && $this->contact_id == null && $contact == null) {
            $contacts = Contact::where('subscribed', 1)->get();
        } else if ($this->group_id != null) {
            $contacts = Group::findOrFail($this->group_id)->contacts()->where('subscribed', 1)->get();
        } else if ($this->contact_id != null) {
            $contacts = Contact::where('id', $this->contact_id)->get();
        } else {
            $contacts = collect([$contact]);
        }

        $template = Template::where('id', $this->template_id)->first();
        $variables_match = json_decode($this->variables_match, true);
        $variablesValues = json_decode($this->variables, true);
        $messages = [];

        $this->send_to = $contacts->count();
        $this->update();

        $tzBasedDelivery = false;
        $companyRelatedDateTimeOfSend = null;

        if ($request != null && !$request->has('send_now') && $request->has('send_time') && $request->send_time != null) {
            $company = $this->company;
            config(['app.timezone' => $company->getConfig('time_zone', config('app.timezone'))]);
            $companyRelatedDateTimeOfSend = Carbon::parse($request->send_time);
            $systemRelatedDateTimeOfSend = $companyRelatedDateTimeOfSend->copy()->tz(config('app.timezone'));
            $tzBasedDelivery = true;
        }

        foreach ($contacts as $contact) {
            $content = "";


            if ($request!=null){
                $contact->is_replied = false;
                $contact->replied_at = null;
                $contact->template_sent_at = now();
                $contact->last_campaign_id = $this->id;
                $contact->save();
            }
            $sendTime = Carbon::now();

            if ($tzBasedDelivery) {
                try {
                    $sendTime = Carbon::parse($systemRelatedDateTimeOfSend->format('Y-m-d H:i:s'), $contact->country->timezone)
                        ->copy()->tz(config('app.timezone'))->format('Y-m-d H:i:s');
                } catch (\Throwable $th) {}
            }

            $APIComponents = [];
            $components = json_decode($template->components, true);

            if (is_array($components)) {
                foreach ($components as $component) {
                     $lowKey = strtolower($component['type']);
                    if ($component['type'] == "HEADER" && $component['format'] == "TEXT") {
                        $content = $component['text'];
                        $component['parameters'] = [];

                        if (isset($variables_match[$lowKey])) {
                            $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $header_text, $contact);
                            unset($component['text'], $component['format'], $component['example']);
                            array_push($APIComponents, $component);
                        }
                        
                    }else if ($component['type'] == "BODY") {
                        $content = $component['text'];
                        $component['parameters'] = [];

                        if (isset($variables_match[$lowKey])) {
                            $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $content, $contact);
                            unset($component['text'], $component['format'], $component['example']);
                            array_push($APIComponents, $component);
                        }
                    } elseif ($component['type'] === 'CAROUSEL') {
                        $carouselCards = [];

                        foreach ($component['cards'] as $index => $card) {
                            $cardComponents = [];

                            foreach ($card['components'] as $comp) {
                                 $link = $request->images[$index];
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
                                                "text" => $comp['text']
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
                                                        "payload" => $button['text']
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
                                                        "text" => $button['url']
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

            $dataToSend = [
                "contact_id" => $contact->id,
                "company_id" => $contact->company_id,
                "value" => $content,
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
                "campaign_id" => $this->id,
            ];

            if (config('settings.is_demo', false)) {
                if (count($messages) < 5) {
                    $dataToSend['value'] = "[THIS IS DEMO] " . $dataToSend['value'];
                    $messages[] = $dataToSend;
                }
            } else {
                $messages[] = $dataToSend;
            }
        }

        $chunkedMessages = array_chunk($messages, 500);
        foreach ($chunkedMessages as $chunk) {
            Message::insert($chunk);
        }

        if ($contact != null) {
            return Message::where('contact_id', $contact->id)->where('campaign_id', $this->id)->orderBy('id', 'desc')->first();
        }
    }

    private function setParameter($variables,$values,&$component,&$content,$contact,$type="text"){
        foreach ($variables as $keyVM => $vm) { 
            $data=["type"=>$type];
            if($vm=="-2"){
                //Use static value
                $data[$type]=$values[$keyVM];
                array_push($component['parameters'],$data);
                $content=str_replace("{{".$keyVM."}}",$values[$keyVM],$content);
                
            }else if($vm=="-3"){
                //Contact extra value in runtime
                try {
                    $extraValueNeeded = $values[$keyVM]; // ex "order.id"
                    $extraValues = $contact->extra_value; //ex ["order"=>["id"=>1,"status"=>"pending"]]
                    $valueNeeded = null;

                    if (isset($extraValues)) {
                        $keys = explode('.', $extraValueNeeded);
                        $valueNeeded = $extraValues;
                        

                        foreach ($keys as $key) {
                            if (isset($valueNeeded[$key])) {
                                $valueNeeded = $valueNeeded[$key];
                            } else {
                                $valueNeeded = $values[$keyVM];
                                break;
                            }
                        }
                    }
                 

                    $data[$type] = $valueNeeded;
                    array_push($component['parameters'], $data);
                    $content = str_replace("{{" . $keyVM . "}}", $valueNeeded, $content);

                    
                } catch (\Throwable $th) {
                    //Use static value
                    $data[$type]=$values[$keyVM];
                    array_push($component['parameters'],$data);
                    $content=str_replace("{{".$keyVM."}}",$values[$keyVM]."---",$content);
                }
               
            }else if($vm=="-1"){
                //Contact name
                $data[$type]=$contact->name;
                array_push($component['parameters'],$data);
                $content=str_replace("{{".$keyVM."}}",$contact->name,$content);
            }else if($vm=="0"){
                //Contact phone
                $data[$type]=$contact->phone;
                array_push($component['parameters'],$data);
                $content=str_replace("{{".$keyVM."}}",$contact->phone,$content);
            }else{
                //Use defined contact field
                if($contact->fields->where('id',$vm)->first()){
                    $val=$contact->fields->where('id',$vm)->first()->pivot->value;
                    $data[$type]=$val;
                    array_push($component['parameters'],$data);
                    $content=str_replace("{{".$keyVM."}}",$val,$content);
                }else{
                    $data[$type]="";
                    array_push($component['parameters'],$data);
                    $content=str_replace("{{".$keyVM."}}","",$content);
                }
            }
        }
    }

    public function getContactIds($request = null, Contact $contact = null)
    {
        $contactIds = [];
        
        // Check if $request is an array or Request object
        $isResendRequest = false;
        $resendId = null;
        $rType = null;
        
        if ($request != null) {
            if (is_array($request)) {
                // Handle array input (from jobs)
                $isResendRequest = isset($request['resend']) && isset($request['rtype']);
                $resendId = $request['resend'] ?? null;
                $rType = $request['rtype'] ?? null;
            } else {
                // Handle Request object input
                $isResendRequest = $request->has('resend') && $request->has('rtype');
                $resendId = $request->resend ?? null;
                $rType = $request->rtype ?? null;
            }
        }
        
        if ($isResendRequest) {
            $statusMapping = [
                'SENT' => [1, 2],
                'READ_IGNORED' => [3, 4],
                'IGNORED' => [3],
                'READ' => [4],
                'FAILED' => [5]
            ];
            
            if ($resendId && $rType) {
                $query = Message::where('campaign_id', $resendId);
                
                if ($rType !== 'all') {
                    $statuses = $statusMapping[strtoupper($rType)] ?? [];
                    $query->whereIn('status', $statuses);
                }
                
                $contactIds = $query->pluck('contact_id')->unique()->toArray();
            }
        } else if ($this->group_id == null && $this->contact_id == null && $contact == null) {
            // All contacts - use chunking to avoid memory issues
            $query = Contact::where('subscribed', 1);
            
            if (auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_created_campaigns_only', 'false') != 'false') {
                $query->where('user_id', auth()->user()->id);
            }
            
            $contactIds = $query->pluck('id')->toArray();
        } else if ($this->group_id != null) {
            // Specific group - fix ambiguous column reference
            try {
                $contactIds = \DB::table('groups_contacts')
                    ->join('contacts', 'groups_contacts.contact_id', '=', 'contacts.id')
                    ->where('groups_contacts.group_id', $this->group_id)
                    ->where('contacts.subscribed', 1)
                    ->where('contacts.company_id', $this->company_id)
                    ->whereNull('contacts.deleted_at')
                    ->pluck('contacts.id') // Explicitly specify the table
                    ->toArray();
            } catch (\Exception $e) {
                \Log::error('Error fetching contact IDs for group: ' . $e->getMessage());
                $contactIds = [];
            }
        } else if ($this->contact_id != null) {
            // Specific contact
            $contactIds = [$this->contact_id];
        } else {
            // No contacts, meaning that contact is passed in run time
            $contactIds = [$contact->id];
        }
        
        return $contactIds;
    }
}
