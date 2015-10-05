<?php namespace Congredi\NotificationSystem\Drivers\SMS;

use Clickatell\Api\ClickatellHttp;

class ClickatellSMS implements DriverInterface
{
	/**
	 * @var \Clickatell\Api\ClickatellHttp;
	 */
	protected $clickatell;

	public function __construct(ClickatellHttp $clickatell)
	{
		$this->clickatell = $clickatell;
	}

	/**
	 * @param \Congredi\NotificationSystem\Drivers\SMS\SmsMessage $message
	 */
	public function send(SmsMessage $message)
	{
		//for now, will skip from and attachments for Clickatell.
		$from        = $message->getFrom();
		$attachments = $message->getAttachImages();

		$bodyMessage = $message->composeMessage();
		$receivers   = $message->getTo();

		if (!empty($receivers)) {
			$this->clickatell->sendMessage($receivers, $bodyMessage);
		}
	}
}