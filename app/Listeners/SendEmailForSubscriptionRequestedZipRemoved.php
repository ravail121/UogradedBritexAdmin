<?php

namespace App\Listeners;

use Notification;
use App\Model\Subscription;
use App\Model\EmailTemplate;
use App\Notifications\SendEmails;
use Illuminate\Notifications\Notifiable;

class SendEmailForSubscriptionRequestedZipRemoved
{
	use EmailLayout, Notifiable;

	const STATUS_CODE = [
		'requested-zip-removal'    => 'requested-zip-removal'
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



		$subscription = Subscription::whereId($subscriptionId)->with('customer')->first();

		$subscription['phone_number'] = $subscription->phoneNumberFormatted;

		$dataRow = [
			'subscription' => $subscription,
			'customer'     =>  $subscription->customer,
		];

		$configurationSet = $this->setMailConfiguration($dataRow['customer']['company_id']);

		if ($configurationSet) {
			return false;
		}

		$emailTemplates = EmailTemplate::where('company_id', $dataRow['customer']['company_id'])
		                               ->where('code', self::STATUS_CODE['requested-zip-removal'])
		                               ->get();

		foreach ($emailTemplates as $emailTemplate) {
			$row = $this->makeEmailLayout($emailTemplate, $dataRow['customer'], $dataRow);

			Notification::route('mail', $row['email'])->notify(new SendEmails( $emailTemplate, $row['body'], $row['email'], $dataRow['customer']['business_verification_id'] , $dataRow['customer']['id']));
		}

	}
}
