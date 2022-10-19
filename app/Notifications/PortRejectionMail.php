<?php

namespace App\Notifications;

use Auth;
use App\Company;
use App\Model\EmailLog;
use Illuminate\Bus\Queueable;
use App\Support\Utilities\ApiConnect;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PortRejectionMail extends Notification
{
    use Queueable;
    use ApiConnect, EmailRecord;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($customer, $subject, $message)
    {
        $this->customer = $customer;
        $this->subject  = $subject;
        $this->message  = $message;
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
        $company = Company::find($this->customer->company_id);

        $data = [
        	'company_id'                => $this->customer->company_id,
            'customer_id'               => $this->customer->id,
            'staff_id'                  => $user->id,
            'to'                        => $this->customer->email,
            'business_verficiation_id'  => $this->customer->business_verification_id,
            'subject'                   => $this->subject,
            'from'                      => $company->support_email,
            'body'                      => $this->message,
        ];

        $emailLog = EmailLog::create($data);

        return (new MailMessage)
                ->subject($this->subject)
                ->from($company->support_email)
                ->line($this->message);
    }
}