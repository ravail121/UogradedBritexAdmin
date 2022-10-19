<?php

namespace App\Listeners;

use Notification;
use App\Model\Subscription;
use App\Model\EmailTemplate;
use App\Notifications\SendEmails;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailForChangedSubcriptionStatus
{
    use EmailLayout;

    const STATUS_CODE = [
        'for-activation'    => 'for-activation',
        'active'            => 'activation-complete',
        'closed'            => 'closed',
        'suspended'         => 'suspended',
        'close-scheduled'   => 'scheduled close',
        'suspend-scheduled' => 'scheduled suspend'
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
        $subscriptionId = $event->subscriptionId;

        $subscription = Subscription::whereId($subscriptionId)->with('customer', 'plans')->first();
        $subscription['phone_number'] = $subscription->phoneNumberFormatted;
        $subscription['suspended_date'] = $this->getDateFormated($subscription['suspended_date']);
        $subscription['scheduled_suspend_date'] = $this->getDateFormated($subscription['scheduled_suspend_date']);
        $subscription['scheduled_close_date'] = $this->getDateFormated($subscription['scheduled_close_date']);
        $subscription['closed_date'] = $this->getDateFormated($subscription['closed_date']);

        $dataRow = [
            'subscription' => $subscription,
            'customer'    =>  $subscription->customer,
            'plan'        =>  $subscription->plans,
        ];
        
        $addons = $subscription->namesOfSubscriptionAddonNotRemoved;
        $addonsName = $addons->implode(',');

        $configurationSet = $this->setMailConfiguration($dataRow['customer']['company_id']);

        if ($configurationSet) {
            return false;
        }

        if($event->subStatus){
            $emailTemplates = EmailTemplate::where('company_id', $dataRow['customer']['company_id'])
            ->where('code', self::STATUS_CODE[$subscription->sub_status])
            ->get();
        }else{
            $emailTemplates = EmailTemplate::where('company_id', $dataRow['customer']['company_id'])
            ->where('code', self::STATUS_CODE[$subscription->status])
            ->get();
        }

        foreach ($emailTemplates as $key => $emailTemplate) {
            $row = $this->makeEmailLayout($emailTemplate, $dataRow['customer'], $dataRow);

            $row['body'] = $this->addFieldsToBody(['[addon__name]'], [$addonsName], $row['body']);

            Notification::route('mail', $row['email'])->notify(new SendEmails( $emailTemplate, $row['body'], $row['email'], $dataRow['customer']['business_verification_id'] , $dataRow['customer']['id']));
        }

    }
}
