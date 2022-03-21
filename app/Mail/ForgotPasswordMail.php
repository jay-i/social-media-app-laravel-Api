<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $passwordResetData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passwordResetData)
    {
        $this->passwordResetData = $passwordResetData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('api/users/forgotPassword/' . $this->passwordResetData->token);
        return $this->from('info@lpgnigeriarevamp.com')->view('mail.forgot_password')->with([
            'email' => $this->passwordResetData->email,
            'url' => $url
        ]);
    }
}
