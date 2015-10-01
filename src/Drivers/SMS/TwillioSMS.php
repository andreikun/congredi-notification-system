<?php namespace Congredi\NotificationSystem\Drivers\SMS;


class TwillioSMS implements DriverInterface
{
	/**
	 * @var \Services_Twilio
	 */
	protected $twillioClient;

	public function __construct(\Services_Twilio $twilio)
	{
		$this->twillioClient = $twilio;
	}

	/**
	 * @param \Congredi\NotificationSystem\Drivers\SMS\SmsMessage $message
	 */
	public function send(SmsMessage $message)
	{
		$from = $message->getFrom();

		$bodyMessage = $message->composeMessage();

		foreach ($message->getTo() as $receiver) {
			$this->twillioClient->account->messages->sendMessage([
				'To' => $receiver,
				'From' => $from,
				'Body' => $bodyMessage,
				'MediaUrl' => $message->getAttachImages(),
			]);
		}
	}
}