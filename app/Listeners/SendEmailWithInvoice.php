<?php

namespace App\Listeners;

use Notification;
use App\Model\EmailTemplate;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\EmailWithAttachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailWithInvoice
{

    use EmailLayout;

    public $invoice, $type, $pdf;

    const STATUS_CODE = [
        'custom charge'   => 'custom-charge',
    ];

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
        $invoice = $event->invoice;
        $type = $event->type;
        $invoicePath = $event->invoicePath;

        $customer = $invoice->customer;
        $dataRow = [
            'invoice'  => $invoice,
            'customer' => $customer,
        ];

        $configurationSet = $this->setMailConfiguration($dataRow['customer']['company_id']);

        if ($configurationSet) {
            return false;
        }

        $emailTemplates = EmailTemplate::where('company_id', $dataRow['customer']['company_id'])
        ->where('code', self::STATUS_CODE[$type])
        ->get();


	    foreach ($emailTemplates as $key => $emailTemplate) {
            $row = $this->makeEmailLayout($emailTemplate, $dataRow['customer'], $dataRow);

            Notification::route('mail', $row['email'])->notify(new EmailWithAttachment($invoicePath, $emailTemplate, $customer, $row['body'], $row['email'], null));
        }
    }
}
