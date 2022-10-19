<?php

namespace App\Listeners;

use Config;
use App\Company;
use App\Model\Customer;
use App\Events\RejectPort;
use App\Notifications\PortRejectionMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPortRejectEmail
{
    use EmailLayout;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $customerId   = $event->customerId;
        $subject = $event->subject;
        $message = $event->message;
        $customer = Customer::find($customerId);

        $email['to'] = $customer->email;
        $email['body'] = preg_replace("/[\n]/","<br>",$message);

        $dataRow = [
            'customer'    => $customer
        ];

        $row = $this->makeEmailLayout((object) $email, $customer, $dataRow);

        $configurationSet = $this->setMailConfiguration($customer->company_id);

        if ($configurationSet) {
            return false;
        }
        
        $customer->notify(new PortRejectionMail($customer, $subject, $row['body']));
    }
}
