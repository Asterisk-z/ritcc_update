<?php

namespace App\Mail\FMDQ;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $update;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($update)
    {
        //
        $this->update = $update;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RITCC Auctioning System')
            ->from('no-reply@fmdqgroup.com', 'RITCC Auctioning System')
            ->view('emails.fmdq.update')
            ->with(['update' => $this->update]);
    }
}