<?php

namespace App\Livewire;

use Livewire\Component;
use Modules\Contacts\Models\Contact as ModelsContact;

class Contact extends Component
{
    public $contact = null;
    public $contacts;
    public $groups;
    public $camposAdicionales;

    public $filterVisible = false;

    protected $listeners = [
        'selectContact' => 'setContact',
        'updateSubscriptionToContact' => 'updateSubsOfContactView'
    ];
    public function setContact($contact)
    {
        $this->contact = $contact;
    }
    public function mount($setup)
    {
        $this->contacts = $setup['contacts'];
        $this->contact = $this->contacts[0];
        $this->groups = $setup['groups'];
        $this->camposAdicionales = $setup['camposAdicionales'];
        // $this->items = $setup['items'];
    }
    public function updateSubsOfContactView($contact)
    {
        $this->contact = $contact;
        foreach ($this->contacts as $contactUp) {
            if ($contactUp->id == $this->contact['id']) {
                $contactUp->subscribed =  $this->contact['subscribed'];
                break;
            }
        }
    }

    public function toggleSubscriptionOnContact($id)
    {
        $contactModel = ModelsContact::with('fields')->find($id);
        if ($contactModel) {
            $contactModel->subscribed = $contactModel->subscribed ? 0 : 1;
            $contactModel->save();
            foreach ($this->contacts as &$contact) {
                if ($contact->id == $id) {
                    $contact->subscribed = $contactModel->subscribed;
                    break;
                }
            }
            $this->contact = $contactModel;
            $this->dispatch('updateContactSubcription', $this->contact);
        } else {
            session()->flash('error', 'Contact not found');
        }
    }
    public function toggleFilters()
    {
        $this->filterVisible = !$this->filterVisible;
    }
    public function render()
    {
        return view('livewire.contact');
    }
}
