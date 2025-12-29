<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->formData['email'], $this->formData['name'])
            ->to(env('MAIL_TO_ADDRESS'), env('MAIL_TO_NAME', 'Anantkamal Software Labs Team'))
            ->subject('New Contact Form Submission: ' . $this->formData['subject'])
            ->view('emails.contact-form');
    }
}
