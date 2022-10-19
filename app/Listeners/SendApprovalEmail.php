<?php

namespace App\Listeners;

use Mail;
use Config;
use App\Company;
use Notification;
use App\Model\Order;
use App\Model\EmailTemplate;
use App\Notifications\SendEmails;
use App\Model\BusinessVerification;
use Illuminate\Notifications\Notifiable;
use App\Events\BusinessVerificationApproved;

class SendApprovalEmail
{
    use Notifiable;

    const URL = '/checkout?verification_hash=';

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
    
    public function handle(BusinessVerificationApproved $event)
    {
        $bizHash   = $event->bizHash;
        $bizVerification = BusinessVerification::hash($bizHash)->first();
        $dataRow['business_verification'] = $bizVerification;
        $order           = Order::find($bizVerification->order_id);
        
        $configurationSet = $this->setMailConfiguration($order);

        if ($configurationSet) {
            return false;
        }

        $company = Company::find($order->company_id);
        
        $url = url($company->url.self::URL.$bizVerification->hash.'&order_hash='.$order->hash);
        
        $emailTemplates = EmailTemplate::where('company_id', $order->company_id)->where('code', 'biz-verification-approved')->get();


        foreach ($emailTemplates as $key => $emailTemplate) {
            if(filter_var($emailTemplate->to, FILTER_VALIDATE_EMAIL)){
                $email = $emailTemplate->to;
            }else{
                $email = $bizVerification->email;
            }

            $names = array();
            $column = preg_match_all('/\[(.*?)\]/s', $emailTemplate->body, $names);
            $table = null;
            $replaceWith = null;

            foreach ($names[1] as $key => $name) {
                $dynamicField = explode("__",$name);
                if($table != $dynamicField[0]){
                    if(isset($dataRow[$dynamicField[0]])){
                        $data = $dataRow[$dynamicField[0]]; 
                        $table = $dynamicField[0];
                    }else{
                        unset($names[0][$key]);
                        continue;
                    }
                }
                $replaceWith[$key] = $data->{$dynamicField[1]} ?: $names[0][$key];
            }
            array_push($names[0], '[HERE]');
            array_push($replaceWith, $url);

            $body = $emailTemplate->newBody($names[0], $replaceWith);

            Notification::route('mail', $email)->notify(new SendEmails( $emailTemplate, $body, $email, $bizVerification->id , null));
        }       
    }

    /**
     * This method sets the Configuration of the Mail according to the Company
     * 
     * @param Order $order
     * @return boolean
     */
    protected function setMailConfiguration(Order $order)
    {
        $company = Company::find($order->company_id);
        $config = [
            'driver'        => $company->smtp_driver,
            'host'          => $company->smtp_host,
            'port'          => $company->smtp_port,
            'username'      => $company->smtp_username,
            'password'      => $company->smtp_password,
            'encryption'    => $company->smtp_encryption,
        ];

        Config::set('mail',$config);
        return false;
    }

}
