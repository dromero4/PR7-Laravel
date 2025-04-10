<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetMail extends Mailable
{
    public $token;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Restablecimiento de password')
            ->view('emails.password_reset')
            ->with([
                'token' => $this->token,
                'email' => $this->email,
            ]);
    }
}
