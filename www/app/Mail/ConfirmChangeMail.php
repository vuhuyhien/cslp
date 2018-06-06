<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $changeEmail, $link)
    {
        $this->user = $user;
        $this->changeEmail = $changeEmail;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.confirm-change-email')
                    ->with([
                        'name' => $this->user->fullname,
                        'oldEmail' => $this->user->email,
                        'newEmail' => $this->changeEmail->email,
                        'link' => $this->link,
                    ]);
    }
}
