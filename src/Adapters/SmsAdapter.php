<?php namespace Congredi\NotificationSystem\Adapters;

use Congredi\NotificationSystem\Notifications\SMS;
use Congredi\NotificationSystem\Providers\SMSNotification;

class SmsAdapter
{
	/**
	 * @var
	 */
	protected $smsNotification;

	public function __construct(SMSNotification $SMSNotification)
	{
		$this->smsNotification = $SMSNotification;
	}

	/**
	 * @param $SMSNotification
	 */
	public function setSMSNotificationProvider($SMSNotification)
	{
		$this->smsNotification = $SMSNotification;
	}

	/**
	 * @param \Congredi\NotificationSystem\Notifications\SMS $smsData
	 */
	public function send(SMS $smsData)
	{
		$this->smsNotification->setPretending($smsData->pretending);

		$this->smsNotification->send($smsData->message, $smsData->messageData, function ($sms) use ($smsData) {
			if (!empty($smsData->from)) {
				$sms->from($smsData->from);
			}

			foreach ($smsData->receivers as $receiver) {
				$sms->to($receiver);
			}

			if (!empty($smsData->attachments) && count($smsData->attachments) > 0) {
				foreach ($smsData->attachments as $attachment) {
					$sms->attachImage($attachment);
				}
			}
		});
	}
}