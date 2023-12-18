<?php

namespace App\Mail\FMDQ;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeleteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $delete;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($delete)
    {
        //
        $this->delete = $delete;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RITCC Auctioning System')
            ->from('no-reply@fmdqgroup.com')
            ->view('emails.fmdq.delete')
            ->with(['delete' => $this->delete]);
    }
}
