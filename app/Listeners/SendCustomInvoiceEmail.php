<?php

namespace App\Listeners;

use Notification;
use App\Model\Order;
use App\Model\Invoice;
use App\Model\Customer;
use App\Model\EmailTemplate;
use App\Notifications\SendEmails;
use App\Events\CustomInvoiceAdded;
use Illuminate\Notifications\Notifiable;

class SendCustomInvoiceEmail
{
    use EmailLayout, Notifiable;
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
     * @param  CustomInvoiceAdded  $event
     * @return void
     */
    public function handle(CustomInvoiceAdded $event)
    {
        $data = $event->data;
        $amount = $event->data['amount'];
        if (isset($data['invoice_id'])) {

            $invoice = Invoice::find($data['invoice_id']);

            $customer = $invoice->Customer;

            $order    = Order::where('invoice_id', $invoice->id)->first();

        } elseif (isset($data['customer_id'])) {

            $customer = Customer::find($data['customer_id']);

        }

        $dataRow['customer'] = $customer;

        $configurationSet = $this->setMailConfiguration($dataRow['customer']['company_id']);

        if ($configurationSet) {
            return false;
        }

        $emailTemplates = EmailTemplate::where('company_id', $customer->company_id)->where('code', 'custom-invoice')->get();
        
        foreach ($emailTemplates as $emailTemplate) {
            $row = $this->makeEmailLayout($emailTemplate, $dataRow['customer'], $dataRow);
            $amountAdded = str_replace('[amount]', '$'.$amount, $row['body']);
            $link = isset($invoice) && $invoice->count() ? 'Click '.'<a href = '. config('internal.__BRITEX_API_BASE_URL') .'/invoice?order_hash='.$order->hash.'>Here</a>'.' to download pdf for your invoice.' : '';
			$message   = isset($invoice) && $invoice->count() ? str_replace('[link]', $link, $amountAdded) : str_replace('[link]', '', $amountAdded);
            Notification::route('mail', $row['email'])->notify(new SendEmails($emailTemplate, $message, $row['email'], $dataRow['customer']['business_verification_id'] , $dataRow['customer']['id']));
        }

    }

}
