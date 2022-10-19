<?php

namespace App\Listeners;

use Notification;
use App\Model\Customer;
use App\Model\EmailTemplate;
use App\Events\PortingComplete;
use App\Notifications\SendEmails;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPortingCompleteEmail
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
	public function handle(PortingComplete $event)
	{
		$customerId   = $event->customerId;
		$customer = Customer::find($customerId);

		$dataRow =[
			'customer'     => $customer,
			'port'         => $event->port,
			'subscription' => $event->port->subscription,
		];

		$configurationSet = $this->setMailConfiguration($customer->company_id);

		if ($configurationSet) {
			return false;
		}

		$emailTemplates = EmailTemplate::where('company_id', $customer->company_id)->where('code', 'port-complete')->get();

		foreach ($emailTemplates as $key => $emailTemplate) {
			$row = $this->makeEmailLayout($emailTemplate, $dataRow['customer'], $dataRow);

			Notification::route('mail', $row['email'])->notify(new SendEmails( $emailTemplate, $row['body'], $row['email'], $dataRow['customer']['business_verification_id'] , $dataRow['customer']['id']));
		}
	}
}