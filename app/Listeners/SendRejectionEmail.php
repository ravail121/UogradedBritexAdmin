<?php

namespace App\Listeners;

use App\Company;
use Notification;
use App\Model\Order;
use App\Model\EmailTemplate;
use App\Model\BusinessVerification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SendEmailforRejection;
use App\Events\BusinessVerificationRejected;

class SendRejectionEmail
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
     * @param  BusinessVerificationCreated  $event
     * @return void
     */
    public function handle(BusinessVerificationRejected $event)
    {
        $bizHash = $event->bizHash;
        $message = $event->message;
        $subject = $event->subject;
        
        $bizVerification = BusinessVerification::hash($bizHash)->first();
        $order = Order::find($bizVerification->order_id);

        $dataRow = [
            'business_verification' => $bizVerification,
            'order'                 => $order,
        ];

        $configurationSet = $this->setMailConfiguration($order->company_id);

        if ($configurationSet) {
            return false;
        }

        $emailTemplates = EmailTemplate::where('company_id', $order->company_id)->where('code', 'biz-verification-rejected')->get();

        foreach ($emailTemplates as $key => $emailTemplate) {

            (object) $emailTemplate['body'] = str_replace('[additional_message]', $message, $emailTemplate->body);

            $row = $this->makeEmailLayout($emailTemplate, $dataRow['business_verification'], $dataRow);

            Notification::route('mail', $row['email'])->notify(new SendEmailforRejection($emailTemplate, $row['body'], $row['email'], $bizVerification->id, null , $subject)); 
        }  
        
    }
}
