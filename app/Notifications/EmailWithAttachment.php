<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailWithAttachment extends Notification
{
    use Queueable, EmailRecord;

    public $pdf;
    public $emailTemplate;
    public $customer;
    public $email;
    public $note;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoicePath, $emailTemplate, $customer, $body, $email, $note)
    {
        $this->invoicePath   = $invoicePath;
        $this->emailTemplate = $emailTemplate;
        $this->customer   = $customer;
        $this->body = $body;
        $this->email = $email;
        $this->note = $note;
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
        $mailMessage = $this->getEmailWithAttachment($this->emailTemplate, $this->customer, $this->body, $this->email, $this->invoicePath, ['mime' => 'application/pdf',], $this->note);

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
