<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate;

class SendSmtpMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function getArrayValue($key, $array, $default = null)
    {
        return $this->arrayCheck($key, $array) ? $array[$key] : $default;
    }

    public function arrayCheck($key, $array): bool
    {
        return is_array($array) && count($array) > 0 && array_key_exists($key, $array) && ! empty($array[$key]) && $array[$key] != 'null';
    }

    public function EmailTemplate($title)
    {
        return EmailTemplate::where('title', $title)->first();
    }

    public function build()
    {

        $this->data['content']['body'] = '';
        $subject                       = $this->getArrayValue('subject', $this->data['content']);
        if ($this->arrayCheck('template_title', $this->data['content'])) {
            $user                          = $this->data['content']['user'];
            $template                      = $this->EmailTemplate($this->data['content']['template_title']);
            $tags                          = ['{name}', '{email}', '{site_name}', '{otp}', '{confirmation_link}', '{reset_link}', '{login_link}'];

            $confirmation_link             = getArrayValue('confirmation_link', $this->data['content']);
            $reset_link                    = getArrayValue('reset_link', $this->data['content']);
            $login_link                    = getArrayValue('login_link', $this->data['content']);

            $replaces                      = [
                $user->name,
                $user->email,
                env('APP_NAME'),
                getArrayValue('otp', $this->data['content']),
                '<a href="' . $confirmation_link . '">' . $confirmation_link . '</a>',
                '<a href="' . $reset_link . '">' . $reset_link . '</a>',
                '<a href="' . $login_link . '">' . $login_link . '</a>'
            ];
            $subject                       = str_replace($tags, $replaces, $template->subject);
            $this->data['content']['body'] = str_replace($tags, $replaces, $template->body);
        }
        // dd($this->data);
        return $this->subject($subject)->view($this->data['view'], $this->data['content']);
    }
}
