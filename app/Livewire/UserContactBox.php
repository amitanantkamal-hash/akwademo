<?php

namespace App\Livewire;

use Livewire\Component;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Group;


class UserContactBox extends Component
{
    public $groups;
    public $camposAdicionales;
    public $contacts;
    public $contactGroup;
    public $showContacts;
    public $view;
    public $fields;
    public $countries;
    public $loading = false;
    public $contact = null;
    public $contact_country;
    public $existingFieldIds;
    protected $listeners = [
        'switchView' => 'switchView',
        'checkContact' => 'checkContact',
    ];

    public function mount($groups, $camposAdicionales, $contacts, $countries, $contact)
    {
        $this->countries = $countries;
        $this->groups = $groups;
        $this->camposAdicionales = $camposAdicionales;
        $this->contacts = $contacts;
        $this->contact = $contact;
        $this->existingFieldIds = [];
        $country = '';
        foreach ($this->countries as $c) {
            if ($c->id == $contact['country_id']) {
                $country = $c->name;
                break;
            }
        }
        $this->contact_country = $country;
        if (isset($contact['fields'])) {
            $this->existingFieldIds = collect($contact['fields'])->pluck('id')->toArray();
        }
        $this->dispatch('selectContact', ['contact' => $this->contact]);
        $this->view = 'editContact';
    }

    public function checkContact($contact, $fields, $contactGroup)
    {
        $this->contact = $contact;
        $this->fields = $fields;
        $this->existingFieldIds = [];
        if (isset($contact['fields'])) {
            $this->existingFieldIds = collect($contact['fields'])->pluck('id')->toArray();
        }else{
            $this->existingFieldIds = collect($this->fields)->pluck('id')->toArray();
        }
        $country = '';
        foreach ($this->countries as $c) {
            if ($c->id == $contact['country_id']) {
                $country = $c->name;
                break;
            }
        }
        $this->contact_country = $country;
        $this->contactGroup = $contactGroup;
        $this->dispatch('selectContact', ['contact' => $contact]);
        $this->switchView('checkContact');
    }

    public function switchView($view)
    {
        $this->view = $view;
        if ($view === 'addField') {
            $this->dispatch('closeCheckContact');
        }
        if ($view === 'Contact') {
            $this->dispatch('openCheckContact');
        }
    }
    public function toggleSubscription($contact)
    {
        $this->contact['subscribed'] = $this->contact['subscribed'] == 0 ? 1 : 0;
        $contactModel = Contact::with('fields', 'groups')->find($contact['id']);
        if ($contactModel) {
            $contactModel->subscribed = $contactModel->subscribed ? 0 : 1;
            $contactModel->save();
        }
    }
    public function render()
    {
        if (!empty($this->contact->Groups) ) {
            $fields_groups = ['fullcol' => true, 'values'=>$this->contact->Groups->pluck('name', 'id'),'multiple' => true, 'classselect' => "", 'ftype' => 'select', 'name' => 'Groups', 'id' => 'groups[]', 'placeholder' => 'Select group', 'data' => Group::get()->pluck('name', 'id'), 'required' => true];
        
        }    
        else
            $fields_groups = ['fullcol' => true,'multiple' => true, 'classselect' => "", 'ftype' => 'select', 'name' => 'Groups', 'id' => 'groups[]', 'placeholder' => 'Select group', 'data' => Group::get()->pluck('name', 'id'), 'required' => true];
                 
        return view('livewire.user-contact-box',['fields_groups'=> $fields_groups]);
    }
}
