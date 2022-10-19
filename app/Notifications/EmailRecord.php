<?php

namespace App\Notifications;

use Auth;
use App\Model\EmailLog;
use App\Model\SystemEmailTemplateDynamicField;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Trait EmailRecord
 *
 * @package App\Notifications
 */
trait EmailRecord
{

	/**
	 * @param      $emailTemplate
	 * @param      $customerId
	 * @param      $body
	 * @param      $email
	 * @param      $bizVerificationId
	 * @param null $note
	 *
	 * @return MailMessage
	 */
	public function getMailDetails($emailTemplate, $customerId, $body, $email, $bizVerificationId, $note = null)
	{

		$this->storeEmailLog($customerId, $email, $bizVerificationId, $emailTemplate, $note, $body);

		$mailMessage = $this->addEmailDetails($emailTemplate, $body);

		return $mailMessage;
	}

	/**
	 * @param      $emailTemplate
	 * @param      $customerId
	 * @param      $body
	 * @param      $email
	 * @param      $bizVerificationId
	 * @param      $subject
	 * @param null $note
	 *
	 * @return MailMessage
	 */
	public function getMailDetailsForRejection($emailTemplate, $customerId, $body, $email, $bizVerificationId, $subject, $note = null)
	{

		$this->storeEmailLog($customerId, $email, $bizVerificationId, $emailTemplate, $note, $body, $subject);

		$mailMessage = $this->addEmailDetails($emailTemplate, $body, $subject);

		return $mailMessage;
	}

	/**
	 * @param      $emailTemplate
	 * @param      $body
	 * @param null $subject
	 *
	 * @return MailMessage
	 */
	public function addEmailDetails($emailTemplate, $body, $subject = null)
	{
		$mailMessage = (new MailMessage)
			->subject($subject ?: $emailTemplate->subject)
			->from($emailTemplate->from);

		if($emailTemplate->reply_to){
			$mailMessage->replyTo($emailTemplate->reply_to);
		}

		if($emailTemplate->cc){
			$cc = explode(",",$emailTemplate->cc);
			$mailMessage->cc($cc);
		}

		if($emailTemplate->bcc){
			$bcc = explode(",",$emailTemplate->bcc);
			$mailMessage->bcc($bcc);
		}

		$mailMessage->line($body);


		return $mailMessage;
	}

	/**
	 * @param      $customerId
	 * @param      $email
	 * @param      $bizVerificationId
	 * @param      $emailTemplate
	 * @param      $note
	 * @param      $body
	 * @param null $subject
	 */
	protected function storeEmailLog($customerId, $email , $bizVerificationId, $emailTemplate, $note, $body, $subject = null)
	{
		$user = Auth::user();

		$data = [
			'staff_id'                 => $user->id,
			'customer_id'              => $customerId,
			'company_id'               => $user->company_id,
			'to'                       => $email,
			'business_verficiation_id'  => $bizVerificationId,
			'subject'                  => $subject ?: $emailTemplate->subject,
			'from'                     => $emailTemplate->from,
			'cc'                       => $emailTemplate->cc,
			'bcc'                      => $emailTemplate->bcc,
			'body'                     => $body,
			'notes'                    => $note,
		];

		$emailLog = EmailLog::create($data);
	}

	/**
	 * @param      $emailTemplate
	 * @param      $customer
	 * @param      $body
	 * @param      $email
	 * @param      $invoicePath
	 * @param      $attachData
	 * @param null $note
	 *
	 * @return MailMessage
	 */
	public function getEmailWithAttachment($emailTemplate, $customer, $body, $email, $invoicePath, $attachData, $note = null)
	{

		$mailMessage = $this->getMailDetails($emailTemplate, $customer->id, $body, $email, $customer->business_verification_id);

		$mailMessage->attach($invoicePath, $attachData);

		return $mailMessage;
	}
}
