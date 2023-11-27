<?php

namespace App\Mail\FMDQ;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $rejected;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rejected)
    {
        //
        $this->rejected = $rejected;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RITCC Auctioning System')
            ->from('no-reply@fmdqgroup.com', 'FMDQ RITCC Auctioning System')
            ->view('emails.fmdq.rejected')
            ->with(['rejected' => $this->rejected]);
    }
}