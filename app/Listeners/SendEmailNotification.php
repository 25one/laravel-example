<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
//use Illuminate\Auth\Events\Login; //for login...
use App\Services\Guzzle\Mail;

class SendEmailNotification
{

    protected $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mail $mail)
    {
        $this->mailer = $mail;
    }

    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->mailer->emailTo = config('app.adminemail');
        $this->mailer->message = 'Was registred ' . $event->user->email; 

        $this->mailer->funcGet();
    }
}
