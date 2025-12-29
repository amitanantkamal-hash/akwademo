<?php

namespace App\Http\Controllers;

use App\Helpers\HubSpotHelper;
use Illuminate\Http\Request;

class HubSpotController extends Controller
{
    protected $hubSpotHelper;

    public function __construct(HubSpotHelper $hubSpotHelper)
    {
        $this->hubSpotHelper = $hubSpotHelper;
    }

    // Controller function to add a contact
    public function addContact(Request $request)
    {   
        $contactData = $request->input();
        $response = $this->hubSpotHelper->addContact($contactData);
        return response()->json($response);
    }

    // Controller function to update a contact
    public function updateContact($contactData, $contactId)
    {
        $response = $this->hubSpotHelper->updateContact($contactId, $contactData);
        return response()->json($response);
    }

    // Controller function to Get contact id by email
    public function getContactIDByEmail($email) {
        
        $response = $this->hubSpotHelper->findContactIdByEmail($email);
        return response()->json($response);
        
    }

    // Controller function to add a contact to a list
    public function addContactToList($listId, $contactId)
    {
        $response = $this->hubSpotHelper->addContactToList($listId, $contactId);
        return response()->json($response);
    }

    // Controller function to remove a contact from a list
    public function removeContactFromList($listId, $contactId)
    {
        $response = $this->hubSpotHelper->removeContactFromList($listId, $contactId);
        return response()->json($response);
    }
}
