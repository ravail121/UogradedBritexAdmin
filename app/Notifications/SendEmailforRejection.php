<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Support\Utilities\ApiConnect;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendEmailforRejection extends Notification
{
    use Queueable;
    use ApiConnect, EmailRecord;

    public $emailTemplate;
    public $body;
    public $email;
    public $customerId;
    public $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($emailTemplate, $body, $email, $bizVerificationId, $customerId, $subject)
    {
        $this->emailTemplate   = $emailTemplate;
        $this->body = $body;
        $this->email = $email;
        $this->bizVerificationId = $bizVerificationId;
        $this->customerId = $customerId;
        $this->subject = $subject;
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
        $mailMessage = $this->getMailDetailsForRejection($this->emailTemplate, $this->customerId, $this->body, $this->email, $this->bizVerificationId, $this->subject);

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
