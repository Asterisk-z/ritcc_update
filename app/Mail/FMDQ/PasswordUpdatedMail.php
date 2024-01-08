<?php

namespace App\Mail\FMDQ;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordUpdatedMail extends Mailable
//  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $updated;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($updated)
    {
        //
        $this->updated = $updated;
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
            ->view('emails.fmdq.changePassword')
            ->with(['updated' => $this->updated]);
    }
}
