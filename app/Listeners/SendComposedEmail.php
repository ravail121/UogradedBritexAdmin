<?php

namespace App\Listeners;

use Mail;
use Config;
use App\Company;
use Notification;
use App\Model\Customer;
use App\Model\EmailLog;
use App\Events\EmaillLog;
use App\Events\ComposeEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\EmailHistoryComposeMail;

class SendComposedEmail
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
     * @param  ComposeEmail  $event
     * @return void
     */
    public function handle(ComposeEmail $event)
    {
        $customerId = $event->data['customer_id'];

        $customer = Customer::find($customerId);
        $dataRow['customer'] = $customer;

        $configurationSet = $this->setMailConfiguration($customer->company_id);

        if ($configurationSet) {
            return false;
        }

        $event->data['body'] = $this->makeEmailBody((object) $event->data, $dataRow);
        $event->data['company_id'] = $customer->company_id;

        $emailLog = EmailLog::create($event->data); 
        
        Notification::route('mail', $event->data['to'])->notify(new EmailHistoryComposeMail($event->data));
    }
}
