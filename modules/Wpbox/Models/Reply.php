<?php

namespace Modules\Wpbox\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class Reply extends Model
{

    protected $table = 'replies';
    public $guarded = [];

    public function shouldWeUseIt($receivedMessage, Contact $contact)
    {
        $receivedMessage = " " . strtolower($receivedMessage);
        $shouldWeUseIt = false;

        //Check if this tipe is a welcome bot, and if this is contact first message
        if ($this->type == 4 && $contact->messages->count() == 1) {
            $shouldWeUseIt = true;
        } else {
            //Check based on the trigger
            // Store the value of $this->trigger in a new variable
            $triggerValues = $this->trigger;

            // Convert $triggerValues into an array if it contains commas
            if (strpos($triggerValues, ',') !== false) {
                $triggerValues = explode(',', $triggerValues);
            }

            //Check if we can use this reply
            if (is_array($triggerValues)) {
                foreach ($triggerValues as $trigger) {
                    if ($this->type == 2) {

                        $trigger = " " . strtolower($trigger);
                        // Exact match
                        if ($receivedMessage == $trigger) {
                            $shouldWeUseIt = true;
                            break; // exit the loop once a match is found
                        }
                    } else if ($this->type == 3) {
                        // Contains
                        if (stripos($receivedMessage, $trigger) !== false) {
                            $shouldWeUseIt = true;
                            break; // exit the loop once a match is found
                        }
                    }
                }
            } else {
                //Doesn't contain commas
                $triggerValues = " " . strtolower($triggerValues);
                if ($this->type == 2) {
                    // Exact match
                    if ($receivedMessage == $triggerValues) {
                        $shouldWeUseIt = true;
                    }
                } else if ($this->type == 3) {
                    // Contains
                    if (stripos($receivedMessage, $triggerValues) !== false) {
                        $shouldWeUseIt = true;
                    }
                }
            }
        }

        //Change message
        if ($shouldWeUseIt == true) {
            $this->increment('used', 1);
            $this->update();

            //Change the values in the  $this->text
            $pattern = '/{{\s*([^}]+)\s*}}/';
            preg_match_all($pattern, $this->text, $matches);
            $variables = $matches[1];
            foreach ($variables as $key => $variable) {
                if ($variable == "name") {
                    $this->text = str_replace("{{" . $variable . "}}", $contact->name, $this->text);
                } else if ($variable == "phone") {
                    $this->text = str_replace("{{" . $variable . "}}", $contact->phone, $this->text);
                } else {
                    //Field
                    $val = $contact->fields->where('name', $variable)->first()->pivot->value;
                    $this->text = str_replace("{{" . $variable . "}}", $val, $this->text);
                }
            }

            //Change the values in the  $this->header
            $pattern = '/{{\s*([^}]+)\s*}}/';
            preg_match_all($pattern, $this->header, $matches);
            $variables = $matches[1];
            foreach ($variables as $key => $variable) {
                if ($variable == "name") {
                    $this->header = str_replace("{{" . $variable . "}}", $contact->name, $this->header);
                } else if ($variable == "phone") {
                    $this->header = str_replace("{{" . $variable . "}}", $contact->phone, $this->header);
                } else {
                    //Field
                    $val = $contact->fields->where('name', $variable)->first()->pivot->value;
                    $this->header = str_replace("{{" . $variable . "}}", $val, $this->header);
                }
            }

            if ($this->isAPI == 1) {
                $this->checkAPIRequest($this, $receivedMessage, $contact);

                /*	if($this->api_always_next_id){
					
					try {
						$nextReply = Reply::find($this->api_always_next_id);
						if ($nextReply) {
							if ($nextReply->isAPI == 1) {
								$nextReply->checkAPIRequest($nextReply, $receivedMessage, $contact);
							} else {
								$contact->sendReply($nextReply);
							}
						}
					} catch (\Throwable $th) {
						//throw $th;
					}
					
				}*/
            } else {

                $contact->sendReply($this);
                
                //if current sendReply is a inputMessage then don't call the next_reply_id first it will take input then call the nextInputID
                if($this->isNextInput != 1){

                    try {
                        if($this->next_reply_id){
                            $nextReply = Reply::find($this->next_reply_id);
                            if ($nextReply) {
                                if ($nextReply->isAPI == 1) {
                                    $this->checkAPIRequest($nextReply, $receivedMessage, $contact);
                                } else {
                                    $contact->sendReply($nextReply);
                                    //$nextReply->sendTheReply($receivedMessage,$contact);
                                }
                            }
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
            
            return true;
        } else {
            return false;
        }
    }

    public function sendTheReply($reply, $receivedMessage, Contact $contact, $apiResponse = null, $isAPI = null, $api_response_type,$save_type)
    {
        $reply->increment('used', 1);
        $reply->update();
        $reply->api_response_type = $api_response_type;
        $reply->list_data = $apiResponse;
        $reply->save_type = $save_type;

        //	$this->list_array_id_key = $list_ref_id;
        //$this->list_array_value_key = $list_ref_value;

        if (isset($apiResponse) && $isAPI == 1) {
            //sample data $getdata = "##apidata.customer##";
            // Match the pattern to extract the key after "apidata."
            // preg_match("/##apidata\.(.*?)##/", $this->text, $matches);
            //$inputField = $matches[1] ?? null;

            // The message template with placeholders
            /*   $messageTemplate = "Hey ##apidata.customer##, How are you?

Your Flat details:
Application ID: ##apidata.applicationId##
Property Code: ##apidata.code##";

*/

            // Replace placeholders in the message
            // $this->text = $this->replacePlaceholders($this->text, $apiResponse);
            $reply->text = $this->replacePlaceholders($reply->text, $apiResponse);
        }
        //Change the values in the  $this->text
        $pattern = '/{{\s*([^}]+)\s*}}/';
        preg_match_all($pattern, $reply->text, $matches);
        $variables = $matches[1];
        foreach ($variables as $key => $variable) {
            if ($variable == "name") {
                $reply->text = str_replace("{{" . $variable . "}}", $contact->name, $reply->text);
            } else if ($variable == "phone") {
                $reply->text = str_replace("{{" . $variable . "}}", $contact->phone, $reply->text);
            } else {
                //Field
                $val = $contact->fields->where('name', $variable)->first()->pivot->value;
                $reply->text = str_replace("{{" . $variable . "}}", $val, $reply->text);
            }
        }
        $contact->sendReply($reply);

        try {
            if ($reply->next_reply_id) {
                $nextReply = Reply::find($reply->next_reply_id);
                $nextReply->sendTheReply($reply, $receivedMessage, $contact);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return true;
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model) {
            $company_id = session('company_id', null);
            if ($company_id) {
                $model->company_id = $company_id;
            }
        });
    }

    public function checkAPIRequest($reply, $receivedMessage, $contact)
    {
        
        if (!empty($reply->api_url)) {
            $apiURL = $reply->api_url;
            
            if ($this->hasInputdataPlaceholder($apiURL)) {
                if ($contact->inputDataKeep) {
                    $contactInteractive_data = json_decode($contact->inputDataKeep, true);
                    if ($contactInteractive_data) {
                        $apiURL = $this->replaceInputDataPlaceholders($apiURL, $contactInteractive_data);
                    }
                }
            }
            
            $postData = $reply->post_data; // Decode JSON to associative array
            $pattern = '/{{\s*([^}]+)\s*}}/';
            preg_match_all($pattern, $postData, $matches);
            $variables = $matches[1];
            foreach ($variables as $key => $variable) {
                if ($variable == "phone") {
                    $postData = str_replace("{{" . $variable . "}}", $contact->phone, $postData);
                }
                /*else if ($variable == "fetchid") {
                    $postData = str_replace("{{" . $variable . "}}", $contact->keep_interactive_id, $postData);
                }*/
            }

            if ($this->hasValidataPlaceholder($postData)) {
                if ($contact->api_validate_response) {
                    $contactInteractive_data = json_decode($contact->api_validate_response, true);
                    if ($contactInteractive_data) {
                        $postData = $this->replaceValiDataPlaceholders($postData, $contactInteractive_data);
                    }
                }
            }
            
            if ($this->hasInputdataPlaceholder($postData)) {
                if ($contact->inputDataKeep) {
                    $contactInteractive_data = json_decode($contact->inputDataKeep, true);
                    if ($contactInteractive_data) {
                        $postData = $this->replaceInputDataPlaceholders($postData, $contactInteractive_data);
                    }
                }
            }

            if ($this->hasSessionApidataPlaceholder($postData)) {
                if ($contact->keep_interactive_data) {
                    $contactInteractive_data = json_decode($contact->keep_interactive_data, true);
                    $listSelected_row = (int)$contact->keep_selected_listrow;

                    if ($contactInteractive_data) {
                        $postData = $this->findReplaceSessionAPIKeyData($postData, $contactInteractive_data, $listSelected_row);
                    }
                }
            }

            if ($this->hasCurrentApidataPlaceholder($postData)) {
                if ($contact->keep_current_api_data) {
                    $contactInteractive_data = json_decode($contact->keep_current_api_data, true);
                    $listSelected_row = (int)$contact->keep_current_selected_listrow;

                    if ($contactInteractive_data) {
                        $postData = $this->findReplaceCurrentAPIKeyData($postData, $contactInteractive_data, $listSelected_row);
                    }
                }
            }
            
            if ($this->hasApidataPlaceholder($postData)) {
                if ($contact->keep_api_data) {
                    $contactInteractive_data = json_decode($contact->keep_api_data, true);

                    if ($contactInteractive_data) {
                        $postData = $this->findReplaceAPIKeyData($postData, $contactInteractive_data);
                    }
                }
            }


            $postData = json_decode($postData, true);
            
            Log::info('Post Data:', ['response' => $postData]); // Use ->json() to log as array if response is JSON

            $endpoint = $apiURL; //$reply->api_url;
            $requestType = $reply->request_type ?? 'POST';
            // $apiKey = $contact->getCompany()->getConfig('third_party_api_token_flowbot', "");
            $apiKey = $reply->api_auth_token ?? '';
            $api_always_call = $reply->api_always_next_id;
            $api_response_type = 2;
            $re_api_call = 2;
            $save_type = $reply->api_res_save_type;
            
            
            if ($reply->api_response_type == "LIST") {
                $api_response_type = $reply->api_response_type == 'LIST' ? 1 : 2;
            }

            if ($reply->api_res_save_type == "API") {
                $re_api_call = 1;
            }
           
            $nextReplyType = 1;
            $apiResponse = [];

            //    if ($re_api_call == 1) {
            /*       $nextReply = Reply::find($reply->next_reply_id);
                $postData = json_decode($nextReply->post_data, true); // Decode JSON to associative array
                $endpoint = $nextReply->api_url;
                $api_always_call = $nextReply->api_always_next_id;
                $requestType = $nextReply->request_type ?? 'POST';
                $apiKey = $nextReply->api_auth_token ?? '';

                if ($nextReply->api_response_type == "LIST") {
                    $api_response_type = $nextReply->api_response_type == 'LIST' ? 1 : 2;
                }

                $apiResponse = $this->sendApiRequestNow($endpoint, $requestType, $postData, $apiKey);
                if ($apiResponse['success']) {
                    $nextReplyType = 1;
                } else {
                    $nextReplyType = 2;
                }

                if ($nextReplyType == 1) {
                    if ($nextReply->api_response_type  == "VALIDATE") {
                        $contact->api_validate_response = json_encode($apiResponse["data"]);
                        $contact->save();
                    }
                    //api response is list then save data 
                    if ($nextReply->api_response_type != "API") {
                        $contact->keep_interactive_data = json_encode($apiResponse["data"]);
                        $contact->save();
                    }

                    //next reply after api success call	
                    $api_nextReply = Reply::find($nextReply->next_reply_id);
                    $this->sendTheReply($api_nextReply, $receivedMessage, $contact, $apiResponse["data"], 1, $api_response_type);
                } else {
                    //next reply after api failure call	
                    $api_nextReply = Reply::find($nextReply->api_failure);
                    $this->sendTheReply($api_nextReply, $receivedMessage, $contact, $apiResponse, 1, $api_response_type);
                }  */
            //      } //end of re_api_call
            //      else {


            $apiResponse = [];
            if ($endpoint) {
                $apiResponse  = $this->sendApiRequestNow($endpoint, $requestType, $postData, $apiKey);
                if ($apiResponse['success']) {
                    $nextReplyType = 1;
                } else {
                    $nextReplyType = 2;
                }
            }
            

            if ($nextReplyType == 1) {
                if ($reply->api_res_save_type  == "VALI") {
                    $contact->api_validate_response = json_encode($apiResponse["data"]);
                    $contact->save();
                }
                //api response is list then save data 
                if ($reply->api_res_save_type != "API") {
                    
                    if ($reply->api_res_save_type == "CURR") {

                        $contact->keep_current_api_data = json_encode($apiResponse["data"]);
                        $contact->save();
                    } else {
                        $contact->keep_interactive_data = json_encode($apiResponse["data"]);
                        $contact->save();
                    }
                }else{
                    $contact->keep_api_data = json_encode($apiResponse["data"]);
                    $contact->save();
                }
                //next reply after api success call	
                $nextReply = Reply::find($reply->next_reply_id);
                $nextReply->sendTheReply($nextReply, $receivedMessage, $contact, $apiResponse["data"], 1, $api_response_type,$save_type);
            } else {
                
                //next reply after api failure call	
                $nextReply = Reply::find($reply->api_failure);
                $isfailISAPI = $nextReply->isAPI;

                if ($isfailISAPI == 1) {

                    $postData = json_decode($nextReply->post_data, true); // Decode JSON to associative array
                    $endpoint = $nextReply->api_url;
                    $api_always_call = $nextReply->api_always_next_id;
                    $requestType = $nextReply->request_type ?? 'POST';
                    $apiKey = $nextReply->api_auth_token ?? '';
                    $api_response_type = 2;
                    $save_type = $nextReply->api_res_save_type;
                    
                    if ($nextReply->api_response_type == "LIST") {
                        $api_response_type = $nextReply->api_response_type == 'LIST' ? 1 : 2;
                    }

                    $apiResponse = $this->sendApiRequestNow($endpoint, $requestType, $postData, $apiKey);
                    if ($apiResponse['success']) {
                        $nextReplyType = 1;
                    } else {
                        $nextReplyType = 2;
                    }

                    if ($nextReplyType == 1) {
                        if ($nextReply->api_res_save_type  == "VALI") {
                            $contact->api_validate_response = json_encode($apiResponse["data"]);
                            $contact->save();
                        }
                        //api response is list then save data 
                        if ($nextReply->api_res_save_type != "API") {

                            if ($nextReply->api_res_save_type == "CURR") {

                                $contact->keep_current_api_data = json_encode($apiResponse["data"]);
                                $contact->save();
                            } else {
                                $contact->keep_interactive_data = json_encode($apiResponse["data"]);
                                $contact->save();
                            }
                        }else{
                            $contact->keep_api_data = json_encode($apiResponse["data"]);
                            $contact->save();
                        }

                        //next reply after api success call	
                        $api_nextReply = Reply::find($nextReply->next_reply_id);
            
                        $this->sendTheReply($api_nextReply, $receivedMessage, $contact, $apiResponse["data"], 1, $api_response_type,$save_type);
                    } else {
                        //next reply after api failure call	
                        $api_nextReply = Reply::find($nextReply->api_failure);
                        $this->sendTheReply($api_nextReply, $receivedMessage, $contact, $apiResponse, 1, $api_response_type,$save_type);
                    }
                } //end if re api call
                else {
                    $this->sendTheReply($nextReply, $receivedMessage, $contact, $apiResponse, 1, $api_response_type,$save_type);
                }
            }
            //     } //end of normal call

            if ($api_always_call) {

                $nextReply_1 = Reply::find($api_always_call);
                $postData_1 = json_decode($nextReply_1->post_data, true); // Decode JSON to associative array
                $endpoint_1 = $nextReply_1->api_url;
                $requestType_1 = $nextReply_1->request_type ?? 'POST';
                $apiKey_1 = $nextReply_1->api_auth_token ?? '';

                $this->sendApiRequestNow($endpoint_1, $requestType_1, $postData_1, $apiKey_1);
            }

        }
    }

    public function checkReAPIRequest() {}

    // Function to replace placeholders with dynamic data
    public function replacePlaceholders($template, $data)
    {
        return preg_replace_callback('/##apidata\.(.*?)##/', function ($matches) use ($data) {
            // Assuming you are replacing with the first element of the array
            $key = $matches[1]; // Extract the key after "apidata."
            return $data[0][$key] ?? 'N/A'; // Access the first element of the $data array
        }, $template);
    }

    public function sendApiRequestNow($url,  $requestType,  $postData = null,  $apiKey = "")
    {

        $headers = [
            'Content-Type' => 'application/json',
        ];
        
        if (!empty($apiKey)) {
            // Split the API key into header name and value
            $parts = explode(':', $apiKey, 2); // Split into max 2 parts
            if (count($parts) === 2) {
                $headerKey = trim($parts[0]);
                $headerValue = trim($parts[1]);
                $headers[$headerKey] = $headerValue;
            }
        }
        
        $client = new Client([
            'headers' => $headers,
        ]);

        $promise = null;
        try {
            if (strtoupper($requestType) === "POST") {
                // Explicitly use json_encode for the body
                $promise = $client->postAsync($url, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => $apiKey ? $apiKey : '',
                    ],
                    'body' => json_encode($postData),
                ]);
            } elseif (strtoupper($requestType) === "GET") {
                $promise = $client->getAsync($url, ['query' => $postData]);
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid request type',
                ];
            }

            // Wait for the response to complete, or handle the promise as it resolves
            $response = $promise->wait();

            //	Log::info('Response Data:', ['response' => $response]); // Use ->json() to log as array if response is JSON

            // Check if the response is successful (status 200)
            if ($response->getStatusCode() === 200) {

                $data = json_decode($response->getBody()->getContents(), true);

                if (empty($data)) {
                    return [
                        'success' => false,
                        'message' => 'No data found',
                    ];
                }
                return [
                    'success' => true,
                    'data' => $data,
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

    }

    // Function to replace placeholders with dynamic data
    public function replaceListPlaceholders($template, $data)
    {
        return preg_replace_callback('/##sessdata\.(.*?)##/', function ($matches) use ($data) {
            $key = $matches[1]; // Extract the key after "apidata."
            return $data[$key] ?? 'N/A'; // Access the contact data array
        }, $template);
    }

    // Function to replace placeholders with dynamic data
    public function replaceValiDataPlaceholders($template, $data)
    {
        return preg_replace_callback('/##validata\.(.*?)##/', function ($matches) use ($data) {
            // Assuming you are replacing with the first element of the array
            $key = $matches[1]; // Extract the key after "apidata."
            return $data[0][$key] ?? 'N/A'; // Access the first element of the $data array
        }, $template);
    }
    
    public function replaceInputDataPlaceholders($template, $data)
    {
        return preg_replace_callback(
            '/##inputdata\.(.*?)##/',
            function ($matches) use ($data) {
                $key = $matches[1];
                return $data[$key] ?? 'N/A'; // Direct access to the decoded JSON object
            },
            $template
        );
    }
    
       // Function to replace placeholders with dynamic data
    public function findReplaceAPIKeyData($template, $data)
    {
        return preg_replace_callback('/##apidata\.(.*?)##/', function ($matches) use ($data) {
            // Assuming you are replacing with the first element of the array
            $key = $matches[1]; // Extract the key after "apidata."
            return $data[0][$key] ?? 'N/A'; // Access the first element of the $data array
        }, $template);
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
        $pieces = explode(".", $replacedStr);
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

    public function hasValidataPlaceholder($template)
    {
        return strpos($template, '##validata.') !== false;
    }
    
    public function hasInputdataPlaceholder($template)
    {
        return strpos($template, '##inputdata.') !== false;
    }
    
    public function hasCurrentApidataPlaceholder($template)
    {
        return strpos($template, '##currdata.') !== false;
    }
    public function hasApidataPlaceholder($template)
    {
        return strpos($template, '##apidata.') !== false;
    }
}