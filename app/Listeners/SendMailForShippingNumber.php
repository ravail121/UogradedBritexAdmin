<?php

namespace App\Listeners;

use Notification;
use App\Model\EmailTemplate;
use App\Notifications\SendEmails;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailForShippingNumber
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
		$trackingNum   = $event->trackingNum;
		$table         = $event->table;

		$dataRow = [
			'customer'    => $table->customer,
		];

		if($table->device && $table->sim){
			$productName = $table->device->name.' & '.$table->sim->name;
		}elseif ($table->device) {
			$productName = $table->device->name;
		}elseif ($table->sim) {
			$productName = $table->sim->name;
		}

		$configurationSet = $this->setMailConfiguration($dataRow['customer']['company_id']);
		if ($configurationSet) {
			return false;
		}

		$emailTemplates = EmailTemplate::where('company_id', $dataRow['customer']['company_id'])
		                               ->where('code', 'shipping-tracking')
		                               ->get();

		foreach ($emailTemplates as $key => $emailTemplate) {
			$row = $this->makeEmailLayout($emailTemplate, $dataRow['customer'], $dataRow);

			$row['body'] = $this->addFieldsToBody(['[product_name]','[tracking_num]'], [$productName, $trackingNum], $row['body']);

			Notification::route('mail', $row['email'])->notify(new SendEmails( $emailTemplate, $row['body'], $row['email'], $dataRow['customer']['business_verification_id'] , $dataRow['customer']['id']));
		}
	}
}
