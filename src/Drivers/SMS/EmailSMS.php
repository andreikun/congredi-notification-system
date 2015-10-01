<?php namespace Congredi\NotificationSystem\Drivers\SMS;

use Illuminate\Contracts\Mail\Mailer;

class EmailSMS implements DriverInterface
{
	protected $mailer;

	/**
	 * Creates the EmailSMS Instance.
	 *
	 * @param \Illuminate\Contracts\Mail\Mailer $mailer
	 */
	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function send(SmsMessage $message)
	{
		$me = $this;

		$this->mailer->send(
			$message->getView(),
			$message->getData(),
			function ($email) use ($me, $message) {

				$isSMS = $message->isMMS();

				foreach ($message->getToWithCarriers() as $number) {
					$email->to($me->buildEmailAddress($number, $isSMS));
				}
				if ($message->getAttachImages()) {
					foreach ($message->getAttachImages() as $image) {
						$email->attach($image);
					}
				}

				$email->from($message->getFrom());
			});
	}

	/**
	 * Builds the email address of a number.
	 *
	 * @param $number
	 * @return string
	 */
	protected function buildEmailAddress($number, $isSMS)
	{
		if (!$number['carrier']) {
			throw new \InvalidArgumentException('A carrier must be specified if using the E-Mail Driver.');
		}

		return $number['number'] . '@' . $this->lookupGateway($number['carrier'], $isSMS);
	}

	/**
	 * Finds the gateway based on the carrier and MMS.
	 *
	 * @param $carrier
	 * @param $mms
	 * @return string
	 */
	protected function lookupGateway($carrier, $mms)
	{
		if ($mms) {
			return $this->lookupMMSCarrier($carrier);
		}

		return $this->lookupSMSCarrier($carrier);
	}

	/**
	 * @param $carrier
	 * @return string
	 */
	protected function lookupMMSCarrier($carrier)
	{
		switch ($carrier) {
			case 'att':
				return 'mms.att.net';
			case 'airfiremobile':
				throw new \InvalidArgumentException('Air Fire Mobile does not support Email Gateway MMS messages.');
			case 'alaskacommunicates':
				return 'msg.acsalaska.com';
			case 'ameritech':
				throw new \InvalidArgumentException('Ameritech does not support Email Gateway MMS messages.');
			case 'assurancewireless':
				return 'vmobl.com';
			case 'boostmobile':
				return 'myboostmobile.com';
			case 'cleartalk':
				throw new \InvalidArgumentException('Clear Talk does not support Email Gateway MMS messages.');
			case 'cricket':
				return 'mms.mycricket.com ';
			case 'metropcs':
				return 'mymetropcs.com';
			case 'nextech':
				throw new \InvalidArgumentException('NexTech does not support Email Gateway MMS messages.');
			case 'rogerswireless':
				return 'mms.rogers.com';
			case 'unicel':
				return 'utext.com';
			case 'verizonwireless':
				return 'vzwpix.com';
			case 'virginmobile':
				return 'vmpix.com';
			case 'tmobile':
				return 'tmomail.net';
			default:
				throw new \InvalidArgumentException('Carrier specified is not found.');
		}
	}

	/**
	 * @param $carrier
	 * @return string
	 */
	protected function lookupSMSCarrier($carrier)
	{
		switch ($carrier) {
			case 'att':
				return 'txt.att.net';
			case 'airfiremobile':
				return 'sms.airfiremobile.com';
			case 'alaskacommunicates':
				return 'msg.acsalaska.com';
			case 'ameritech':
				return 'paging.acswireless.com';
			case 'assurancewireless':
				return 'vmobl.com';
			case 'boostmobile':
				return 'sms.myboostmobile.com';
			case 'cleartalk':
				return 'sms.cleartalk.us';
			case 'cricket':
				return 'sms.mycricket.com';
			case 'metropcs':
				return 'mymetropcs.com';
			case 'nextech':
				return 'sms.ntwls.net';
			case 'rogerswireless':
				return 'sms.rogers.com';
			case 'unicel':
				return 'utext.com';
			case 'verizonwireless':
				return 'vtext.com';
			case 'virginmobile':
				return 'vmobl.com';
			case 'tmobile':
				return 'tmomail.net';
			default:
				throw new \InvalidArgumentException('Carrier specified is not found.');
		}
	}
}