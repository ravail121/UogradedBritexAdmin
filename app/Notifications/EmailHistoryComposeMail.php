<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailHistoryComposeMail extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        $subject = $this->data['subject'];
        $body    = $this->data['body'];
        $from    = $this->data['from'];

        $mailMessage = (new MailMessage)
                    ->subject($subject)
                    ->from($from);

        if($this->data['cc']){
            $cc = explode(",",$this->data['cc']);
            $mailMessage->cc($cc);
        }
                
        if($this->data['bcc']) {
            $bcc = explode(",",$this->data['bcc']);
            $mailMessage->bcc($bcc);
        }

        if($this->data['reply_to']) {
            $mailMessage->replyTo($this->data['reply_to']);   
        }
        
        $mailMessage->line($body);

        return $mailMessage;
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
