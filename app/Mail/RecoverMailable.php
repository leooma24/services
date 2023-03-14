<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = '';
    public $token = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->subject = $data['subject'];
        $this->token = $data['token'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.recover', ['token' => $this->token])->subject($this->subject);
    }
}
