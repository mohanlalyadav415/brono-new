<?php 
// app/Mail/ResetPassword.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url(config('app.url') . route('password.reset', $this->token, false));

        return $this->subject('Your Password Reset Link')
            ->view('emails.password-reset') 
            ->with([
                'actionUrl' => $url,
                'actionText' => 'Reset Password',
            ]);
    }
}

 ?>