<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InfoNotification extends Notification implements ShouldQueue
{
    // implements ShouldQueue
    use Queueable;

    protected $message;
    protected $attachment;
    protected $subject;
    protected $cc;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $subject = "Info", $cc = [], $attachment = [])
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->cc = $cc;
        $this->attachment = $attachment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $notifiable;
        $info = $this->message;

        $mail = (new MailMessage)
            ->subject(config('app.name') . " - " . $this->subject)
            ->view('mails.info', compact('user', 'info'));

        if ($this->cc) {
            $mail = $mail->cc($this->cc);
        }

        if ($this->attachment) {
            $mail = $mail->attach($this->attachment['saved_path'], [
                'as' => $this->attachment['name'],
            ]);
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
