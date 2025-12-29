<?php

namespace App\Livewire;

use Livewire\Component;
use Modules\Wpbox\Models\Contact;

class CheckContact extends Component
{
    public $contacts;
    public $showContacts = true;

    public $listeners = [
        'renderlist' => 'renderlist',
        'closeCheckContact' => 'handleCloseCheckContact',
        'openCheckContact' => 'handleOpenCheckContact',
    ];

    public function handleCloseCheckContact()
    {
        $this->showContacts = false;
    }

    public function handleOpenCheckContact()
    {
        $this->showContacts = true;
    }

    public function mount($contacts)
    {
        $this->contacts = $contacts;
    }

    public function renderlist()
    {
        $this->contacts = Contact::with('fields','groups')->where('company_id', auth()->user()->company->id)->get();
    }

    public function render()
    {
        return view('livewire.check-contact');
    }
}
