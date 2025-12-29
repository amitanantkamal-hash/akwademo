<?php

namespace Modules\Agents\Http\Controllers;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AgentWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $agent;
    public $plainPassword;
    public $loginUrl;
    public $company;

    /**
     * Create a new message instance.
     */
    public function __construct(User $agent, string $plainPassword)
    {
        $this->agent = $agent;
        $this->plainPassword = $plainPassword;
        $this->company = $agent->company;
        $this->loginUrl = config('app.url') . '/login';
    }

    /**
     * Build the message.
     */
    public function build(): self
    {   
        return $this->subject('Welcome to ' . ($this->company->name ?? config('app.name')) . ' - Your Agent Account')
                ->view('agents::emails.agent_welcome')
                ->with([
                    'loginUrl' => $this->loginUrl,
                    'email' => $this->agent->email,
                    'plainPassword' => $this->plainPassword,
                    'company' => $this->company,
                    'agent' => $this->agent,
                ]);
    }
}