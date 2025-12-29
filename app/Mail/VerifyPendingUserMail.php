<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\PendingUser;

class VerifyPendingUserMail extends Mailable
{
     use Queueable, SerializesModels;

    public $pending;

    /**
     * Create a new message instance.
     *
     * @param PendingUser $pending
     */
    public function __construct(PendingUser $pending)
    {
        $this->pending = $pending;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verify Your Email Address')
            ->markdown('emails.verify_email')
            ->with([
                'token' => $this->pending->email_verification_token,
                'email' => $this->pending->email,
                'name'  => $this->pending->name,
                'verify_url' => route('pending.verify', $this->pending->email_verification_token),
            ]);
    }
}
