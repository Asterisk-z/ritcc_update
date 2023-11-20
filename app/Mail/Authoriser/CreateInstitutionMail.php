<?php

namespace App\Mail\Authoriser;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateInstitutionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $new;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($new)
    {
        //
        $this->new = $new;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RITCC Auctioning System')
            ->from('no-reply@fmdqgroup.com', 'FMDQ RITCC Auctioning')
            ->view('emails.authoriser.create-institution')
            ->with(['new' => $this->new]);
    }
}
