<?php

namespace App\Mail\FMDQ;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $create;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($create)
    {
        //
        $this->create = $create;
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
            ->view('emails.fmdq.create')
            ->with(['create' => $this->create]);
    }
}
