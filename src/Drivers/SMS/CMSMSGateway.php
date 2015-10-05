<?php namespace Congredi\NotificationSystem\Drivers\SMS;


class CMSMSGateway implements DriverInterface
{
	/**
	 * @var string
	 */
	private $token;

	/**
	 * @param string $token
	 */
	public function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 * @param \Congredi\NotificationSystem\Drivers\SMS\SmsMessage $message
	 */
	public function send(SmsMessage $message)
	{
		//Not used for now
		$attachments = $message->getAttachImages();

		//This can be also a string.
		$from = $message->getFrom();

		$bodyMessage = $message->composeMessage();

		$receivers = $message->getTo();

		if (!empty($receivers)) {
			foreach ($receivers as $receiver) {
				$this->sendMessage($from, $receiver, $bodyMessage);
			}
		}
	}

	/**
	 * @param $from
	 * @param $recipient
	 * @param $message
	 * @return mixed
	 */
	private function sendMessage($from, $recipient, $message)
	{
		$xml = $this->buildMessageXML($from, $recipient, $message);

		$ch = curl_init(); //cURL v7.18.1+ and OpenSSL 0.9.8j+ required
		curl_setopt_array($ch, [
			CURLOPT_URL            => 'https://sgw01.cm.nl/gateway.ashx',
			CURLOPT_HTTPHEADER     => array('Content-Type: application/xml'),
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $xml,
			CURLOPT_RETURNTRANSFER => true
		]);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}

	/**
	 * @param $from
	 * @param $recipient
	 * @param $message
	 * @return mixed
	 */
	private function buildMessageXML($from, $recipient, $message)
	{
		$xml = new \SimpleXMLElement('<MESSAGES/>');

		$authentication = $xml->addChild('AUTHENTICATION');
		$authentication->addChild('PRODUCTTOKEN', $this->token);

		$msg = $xml->addChild('MSG');
		$msg->addChild('FROM', $from);
		$msg->addChild('TO', $recipient);
		$msg->addChild('BODY', $message);

		return $xml->asXML();
	}

}