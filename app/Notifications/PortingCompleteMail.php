<?php

namespace App\Notifications;

use Auth;
use App\Company;
use App\Model\EmailLog;
use App\Model\Customer;
use App\Model\EmailTemplate;
use Illuminate\Bus\Queueable;
use App\Support\Utilities\ApiConnect;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\SystemEmailTemplateDynamicFields;
use Illuminate\Notifications\Messages\MailMessage;

class PortingCompleteMail extends Notification
{
    use Queueable;
    use ApiConnect, EmailRecord;

    public $customer;
    public $emailTemplate;
    public $body;
    public $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, $emailTemplate, $body, $email)
    {
        $this->customer = $customer;
        $this->emailTemplate = $emailTemplate;
        $this->body = $body;
        $this->email = $email;
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
        $user = Auth::user();

        $data = ['company_id'          => $this->customer->company_id,
            'customer_id'              => $this->customer->id,
            'staff_id'                 => $user->id,
            'to'                       => $this->customer->email,
            'business_verficiation_id' => $this->customer->business_verification_id,
            'subject'                  => $this->emailTemplate->subject,
            'from'                     => $this->emailTemplate->from,
            'body'                     => $this->body,
            'cc'                       => $this->emailTemplate->cc,
            'bcc'                      => $this->emailTemplate->bcc,
        ];

        $emailLog = EmailLog::create($data);
        $mailMessage = $this->addEmailDetails($this->emailTemplate, $this->body);

        return $mailMessage;

    }
}